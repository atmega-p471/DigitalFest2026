<?php

namespace Database\Seeders;

use App\Models\Artist;
use App\Models\PlatformRate;
use App\Models\RevenueEntry;
use App\Models\Track;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $artistA = Artist::create([
            'name' => 'Ayan',
            'stage_name' => 'Ayan',
            'bio' => 'Pop artist from label roster.',
        ]);

        $artistB = Artist::create([
            'name' => 'Nika',
            'stage_name' => 'Nika',
            'bio' => 'RNB singer with multiple singles.',
        ]);

        $track1 = Track::create([
            'title' => 'Midnight City Lights',
            'isrc' => 'RUAAA2600001',
            'release_date' => '2026-03-10',
            'genre' => 'Pop',
            'notes' => 'Main spring release.',
        ]);

        $track2 = Track::create([
            'title' => 'Ocean Echo',
            'isrc' => 'RUAAA2600002',
            'release_date' => '2026-04-02',
            'genre' => 'RNB',
            'notes' => 'Collaboration single.',
        ]);

        $track1->artists()->attach($artistA->id, ['share_percent' => 70]);
        $track1->artists()->attach($artistB->id, ['share_percent' => 30]);
        $track2->artists()->attach($artistB->id, ['share_percent' => 100]);

        PlatformRate::create([
            'platform' => 'Yandex Music',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'rate_per_stream_rub' => 0.030000,
        ]);
        PlatformRate::create([
            'platform' => 'VK Music',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'rate_per_stream_rub' => 0.025000,
        ]);
        PlatformRate::create([
            'platform' => 'Spotify',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'rate_per_stream_rub' => 0.028000,
        ]);

        RevenueEntry::create([
            'track_id' => $track1->id,
            'revenue_date' => '2026-03-15',
            'streams' => 3500000,
            'amount' => 100000,
            'expected_amount_rub' => 98000,
            'currency' => 'RUB',
            'platform' => 'Yandex Music',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'source' => 'Streaming',
            'fx_rate_to_rub' => 1,
        ]);
        RevenueEntry::create([
            'track_id' => $track1->id,
            'revenue_date' => '2026-04-15',
            'streams' => 4000000,
            'amount' => 120000,
            'expected_amount_rub' => 115000,
            'currency' => 'RUB',
            'platform' => 'Spotify',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'source' => 'Streaming',
            'fx_rate_to_rub' => 1,
        ]);
        RevenueEntry::create([
            'track_id' => $track2->id,
            'revenue_date' => '2026-04-20',
            'streams' => 1900000,
            'amount' => 65000,
            'expected_amount_rub' => 64000,
            'currency' => 'RUB',
            'platform' => 'VK Music',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'source' => 'Ads',
            'fx_rate_to_rub' => 1,
        ]);

        User::create([
            'name' => 'Label Admin',
            'email' => 'admin@label.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'artist_id' => null,
        ]);

        User::create([
            'name' => 'Artist User',
            'email' => 'artist@label.local',
            'password' => Hash::make('password'),
            'role' => 'artist',
            'artist_id' => $artistA->id,
        ]);

        User::create([
            'name' => 'Artist B User',
            'email' => 'artistb@label.local',
            'password' => Hash::make('password'),
            'role' => 'artist',
            'artist_id' => $artistB->id,
        ]);
    }
}
