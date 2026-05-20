<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessControlTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/tracks');
        $response->assertRedirect('/login');
    }

    public function test_artist_cannot_access_admin_share_update(): void
    {
        $artistUser = User::factory()->create(['role' => 'artist']);

        $response = $this->actingAs($artistUser)->post('/admin/shares', [
            'track_ids' => [1],
            'share_percent' => 15,
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_access_reports_page(): void
    {
        $admin = User::factory()->admin()->create();
        $response = $this->actingAs($admin)->get('/reports');
        $response->assertStatus(200);
    }

    public function test_artist_sees_only_own_tracks(): void
    {
        $artistA = \App\Models\Artist::factory()->create();
        $artistB = \App\Models\Artist::factory()->create();
        $trackA = \App\Models\Track::factory()->create(['title' => 'Only A']);
        $trackB = \App\Models\Track::factory()->create(['title' => 'Only B']);
        $trackA->artists()->attach($artistA->id, ['share_percent' => 100]);
        $trackB->artists()->attach($artistB->id, ['share_percent' => 100]);
        $userA = User::factory()->create(['role' => 'artist', 'artist_id' => $artistA->id]);

        $response = $this->actingAs($userA)->get('/tracks');
        $response->assertStatus(200);
        $response->assertSee('Only A');
        $response->assertDontSee('Only B');
    }
}
