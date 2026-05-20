<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\ManualAdjustment;
use App\Models\PlatformRate;
use App\Models\RevenueEntry;
use App\Services\DataSimulatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class AdminDataController extends Controller
{
    public function __construct(private readonly DataSimulatorService $simulator)
    {
    }

    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'rates' => PlatformRate::orderBy('platform')->get(),
            'incidents' => Incident::with(['artist', 'track'])->latest()->limit(50)->get(),
            'entries' => RevenueEntry::with('track')->latest()->limit(30)->get(),
        ]);
    }

    public function runDailySync(): RedirectResponse
    {
        $count = $this->simulator->generateDaily();

        return back()->with('status', "Daily sync completed. Generated {$count} rows.");
    }

    public function runMonthlySync(): RedirectResponse
    {
        $count = $this->simulator->generateMonthly(now()->subMonth());

        return back()->with('status', "Monthly sync completed. Generated {$count} payout rows.");
    }

    public function updateRate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'platform' => ['required', 'string', 'max:100'],
            'country' => ['required', 'string', 'size:2'],
            'subscription_type' => ['required', 'string', 'max:50'],
            'rate_per_stream_rub' => ['required', 'numeric', 'min:0'],
        ]);

        PlatformRate::updateOrCreate(
            [
                'platform' => $data['platform'],
                'country' => strtoupper($data['country']),
                'subscription_type' => $data['subscription_type'],
            ],
            ['rate_per_stream_rub' => $data['rate_per_stream_rub']]
        );

        return back()->with('status', 'Platform rate saved.');
    }

    public function manualAdjust(Request $request, RevenueEntry $entry): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['nullable', 'numeric', 'min:0'],
            'streams' => ['nullable', 'integer', 'min:0'],
            'fx_rate_to_rub' => ['nullable', 'numeric', 'min:0'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);

        foreach (['amount', 'streams', 'fx_rate_to_rub'] as $field) {
            if (! array_key_exists($field, $data) || $data[$field] === null) {
                continue;
            }

            ManualAdjustment::create([
                'revenue_entry_id' => $entry->id,
                'changed_by_user_id' => $request->user()->id,
                'field' => $field,
                'old_value' => (string) $entry->{$field},
                'new_value' => (string) $data[$field],
                'reason' => $data['reason'] ?? null,
            ]);

            $entry->{$field} = $data[$field];
        }

        $entry->is_manual_corrected = true;
        $entry->save();

        return back()->with('status', 'Manual correction saved and protected from overwrite.');
    }

    public function exportRevenueCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="normalized_revenue.csv"',
        ];

        $callback = function (): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['track', 'isrc', 'date', 'platform', 'country', 'streams', 'expected_rub', 'actual_rub', 'manual_corrected']);

            RevenueEntry::with('track')->orderBy('revenue_date')->chunk(500, function ($rows) use ($out): void {
                foreach ($rows as $row) {
                    fputcsv($out, [
                        $row->track?->title,
                        $row->track?->isrc,
                        $row->revenue_date?->format('Y-m-d'),
                        $row->platform,
                        $row->country,
                        $row->streams,
                        $row->expected_amount_rub,
                        $row->amount,
                        $row->is_manual_corrected ? 'yes' : 'no',
                    ]);
                }
            });
            fclose($out);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function exportIncidentsCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="incidents.csv"',
        ];

        $callback = function (): void {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['id', 'type', 'message', 'deviation_percent', 'track', 'artist', 'created_at']);
            Incident::with(['track', 'artist'])->orderByDesc('id')->chunk(500, function ($rows) use ($out): void {
                foreach ($rows as $row) {
                    fputcsv($out, [
                        $row->id,
                        $row->type,
                        $row->message,
                        $row->deviation_percent,
                        $row->track?->title,
                        $row->artist?->name,
                        $row->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });
            fclose($out);
        };

        return Response::stream($callback, 200, $headers);
    }
}
