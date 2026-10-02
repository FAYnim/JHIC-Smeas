<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LamaranReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_lamaran_list_and_filter_by_status(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create(['title' => 'Teknisi Jaringan']);
        MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-TEL-20261001-ABC12345',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.lamaran.index'));
        $response->assertOk();
        $response->assertSee('1234567890');
        $response->assertSee('PKL-TEL-20261001-ABC12345');
    }

    public function test_bkk_user_can_update_lamaran_status(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create();
        $app = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-TEL-20261001-ABC12345',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($bkk)->patch(route('admin.lamaran.update-status', $app), [
            'status' => 'accepted',
        ]);

        $response->assertRedirect();
        $this->assertEquals('accepted', $app->fresh()->status);
    }
}
