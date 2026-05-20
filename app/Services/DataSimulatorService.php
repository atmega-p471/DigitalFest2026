<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\Incident;
use App\Models\PlatformRate;
use App\Models\Payout;
use App\Models\RevenueEntry;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DataSimulatorService
{
    public function generateDaily(?Carbon $forDate = null): int
    {
        $date = ($forDate ?? now())->toDateString();
        $tracks = Track::with('artists')->get();
        $platforms = ['Yandex Music', 'VK Music', 'Spotify', 'Apple Music'];
        $countries = ['RU', 'KZ', 'BY'];
        $types = ['premium', 'free'];
        $created = 0;

        foreach ($tracks as $track) {
            foreach ($platforms as $platform) {
                $country = $countries[array_rand($countries)];
                $subType = $types[array_rand($types)];

                $duplicate = RevenueEntry::where('track_id', $track->id)
                    ->whereDate('revenue_date', $date)
                    ->where('platform', $platform)
                    ->where('country', $country)
                    ->where('subscription_type', $subType)
                    ->first();

                if ($duplicate) {
                    continue;
                }

                $rate = PlatformRate::query()
                    ->where('platform', $platform)
                    ->where('country', $country)
                    ->where('subscription_type', $subType)
                    ->first();

                $rateValue = (float) ($rate?->rate_per_stream_rub ?? 0.03);
                $streams = random_int(500, 30000);
                $expected = $streams * $rateValue;
                $noise = random_int(-8, 8) / 100;
                $amount = $expected * (1 + $noise);

                $entry = RevenueEntry::create([
                    'track_id' => $track->id,
                    'revenue_date' => $date,
                    'streams' => $streams,
                    'amount' => round($amount, 2),
                    'expected_amount_rub' => round($expected, 2),
                    'currency' => 'RUB',
                    'platform' => $platform,
                    'country' => $country,
                    'subscription_type' => $subType,
                    'source' => 'DataLens Simulator',
                    'fx_rate_to_rub' => 1,
                ]);
                $created++;

                $this->createDeviationIncidentIfNeeded($entry);
                $this->ensureArtistCoverageIncident($track);
            }
        }

        return $created;
    }

    public function generateMonthly(Carbon $monthDate): int
    {
        $periodStart = $monthDate->copy()->startOfMonth()->toDateString();
        $periodEnd = $monthDate->copy()->endOfMonth()->toDateString();
        $created = 0;

        $artists = Artist::with(['tracks.revenueEntries', 'tracks.artists'])->get();
        foreach ($artists as $artist) {
            foreach ($artist->tracks as $track) {
                $gross = $track->revenueEntries
                    ->whereBetween('revenue_date', [$periodStart, $periodEnd])
                    ->sum('amount');
                $share = (float) ($track->pivot->share_percent ?? 0);
                $amount = round($gross * ($share / 100), 2);

                if ($amount <= 0) {
                    continue;
                }

                Payout::create([
                    'artist_id' => $artist->id,
                    'track_id' => $track->id,
                    'period_start' => $periodStart,
                    'period_end' => $periodEnd,
                    'amount' => $amount,
                    'currency' => 'RUB',
                    'status' => 'accrued',
                ]);
                $created++;
            }
        }

        return $created;
    }

    private function createDeviationIncidentIfNeeded(RevenueEntry $entry): void
    {
        $expected = (float) $entry->expected_amount_rub;
        $actual = (float) $entry->amount;

        if ($expected <= 0) {
            return;
        }

        $deviationPercent = abs(($actual - $expected) / $expected) * 100;
        if ($deviationPercent <= 2) {
            return;
        }

        Incident::create([
            'track_id' => $entry->track_id,
            'artist_id' => $entry->track?->artists()->first()?->id,
            'type' => 'revenue_deviation',
            'message' => 'Deviation is higher than 2% between expected and actual revenue.',
            'deviation_percent' => round($deviationPercent, 2),
            'meta' => [
                'revenue_entry_id' => $entry->id,
                'expected' => $expected,
                'actual' => $actual,
            ],
        ]);
    }

    private function ensureArtistCoverageIncident(Track $track): void
    {
        if ($track->artists->isNotEmpty()) {
            return;
        }

        Incident::create([
            'track_id' => $track->id,
            'artist_id' => null,
            'type' => 'missing_track_artist',
            'message' => 'Track is missing artist mapping and cannot be distributed.',
            'meta' => ['isrc' => $track->isrc],
        ]);
    }
}
