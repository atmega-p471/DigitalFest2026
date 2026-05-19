<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\RevenueEntry;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_artist_can_create_own_report(): void
    {
        $artist = Artist::factory()->create();
        $track = Track::factory()->create();
        $track->artists()->attach($artist->id, ['share_percent' => 50]);
        RevenueEntry::factory()->create([
            'track_id' => $track->id,
            'revenue_date' => '2026-05-01',
            'amount' => 1000,
        ]);
        $user = User::factory()->create([
            'role' => 'artist',
            'artist_id' => $artist->id,
        ]);

        $response = $this->actingAs($user)->post('/reports', [
            'artist_id' => $artist->id,
            'period_from' => '2026-05-01',
            'period_to' => '2026-05-31',
            'track_ids' => [$track->id],
        ]);

        $response->assertRedirect('/reports');
        $this->assertDatabaseHas('reports', [
            'artist_id' => $artist->id,
            'created_by_user_id' => $user->id,
            'total_amount' => 500.00,
        ]);
    }
}
