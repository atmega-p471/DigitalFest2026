<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Incident;
use App\Models\Payout;
use App\Models\Report;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $artists = $user->isAdmin()
            ? Artist::orderBy('name')->get()
            : Artist::where('id', $user->artist_id)->get();

        $tracksQuery = Track::orderBy('title');
        if (! $user->isAdmin()) {
            $tracksQuery->whereHas('artists', fn ($q) => $q->where('artists.id', $user->artist_id));
        }
        $tracks = $tracksQuery->get();

        $reports = Report::with(['artist', 'creator'])->latest()->limit(20)->get();

        if (! $user->isAdmin()) {
            $reports = $reports->where('artist_id', $user->artist_id)->values();
        }

        $payouts = Payout::with(['artist', 'track'])->latest()->limit(30)->get();
        if (! $user->isAdmin()) {
            $payouts = $payouts->where('artist_id', $user->artist_id)->values();
        }

        $incidents = Incident::with(['artist', 'track'])->latest()->limit(30)->get();
        if (! $user->isAdmin()) {
            $incidents = $incidents->where('artist_id', $user->artist_id)->values();
        }

        return view('reports.index', [
            'artists' => $artists,
            'tracks' => $tracks,
            'reports' => $reports,
            'payouts' => $payouts,
            'incidents' => $incidents,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'artist_id' => ['required', 'integer', 'exists:artists,id'],
            'period_from' => ['required', 'date'],
            'period_to' => ['required', 'date', 'after_or_equal:period_from'],
            'track_ids' => ['nullable', 'array'],
            'track_ids.*' => ['integer', 'exists:tracks,id'],
        ]);

        if (! $user->isAdmin() && (int) $data['artist_id'] !== (int) $user->artist_id) {
            abort(403, 'Artists can create only own reports.');
        }

        $artist = Artist::with(['tracks.revenueEntries', 'tracks.artists'])->findOrFail($data['artist_id']);
        $selectedTrackIds = collect($data['track_ids'] ?? [])->map(fn ($id) => (int) $id);

        $totalAmount = $artist->tracks
            ->filter(function ($track) use ($selectedTrackIds) {
                return $selectedTrackIds->isEmpty() || $selectedTrackIds->contains((int) $track->id);
            })
            ->sum(function ($track) use ($data, $artist) {
                $gross = $track->revenueEntries
                    ->whereBetween('revenue_date', [$data['period_from'], $data['period_to']])
                    ->sum('amount');

                $artistLink = $track->artists->firstWhere('id', $artist->id);
                $sharePercent = (float) ($artistLink?->pivot?->share_percent ?? 0);

                return $gross * ($sharePercent / 100);
            });

        Report::create([
            'created_by_user_id' => $user->id,
            'artist_id' => $artist->id,
            'period_from' => $data['period_from'],
            'period_to' => $data['period_to'],
            'total_amount' => round((float) $totalAmount, 2),
            'currency' => 'RUB',
        ]);

        return redirect()
            ->route('reports.index')
            ->with('status', 'Report created successfully.');
    }
}
