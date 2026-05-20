<?php

namespace Tests\Feature;

use App\Models\Artist;
use App\Models\PlatformRate;
use App\Models\Track;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SimulatorWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_generate_daily_data_and_incidents(): void
    {
        $artist = Artist::factory()->create();
        $track = Track::factory()->create();
        $track->artists()->attach($artist->id, ['share_percent' => 100]);
        PlatformRate::create([
            'platform' => 'Yandex Music',
            'country' => 'RU',
            'subscription_type' => 'premium',
            'rate_per_stream_rub' => 0.03,
        ]);
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post('/admin/sync/daily');
        $response->assertStatus(302);
        $this->assertDatabaseCount('revenue_entries', 4);
        $this->assertDatabaseHas('incidents', ['type' => 'revenue_deviation']);
    }
}
