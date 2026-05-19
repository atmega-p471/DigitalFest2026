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
}
