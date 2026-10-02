<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_layout_renders_sidebar_and_topbar(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Panel Admin', false);
        $response->assertSee($admin->name);
        $response->assertSee('Super Admin');
    }

    public function test_logout_form_is_present(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertSee(route('logout'), false);
    }

    public function test_menu_only_shows_items_available_for_role(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->get(route('admin.dashboard'));

        // Fase 1: hanya admin.dashboard yang terdaftar; modul Pusat Karir
        // belum punya route, jadi itemnya juga tidak tampil di sidebar.
        $response->assertSee('Dashboard', false);
        $response->assertDontSee('Pengguna', false);
        $response->assertDontSee('Lowongan', false);
    }

    public function test_admin_menu_hides_modules_not_yet_implemented(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        // Modul Lowongan belum punya route di Fase 1, jadi tidak boleh tampil.
        $response->assertDontSee('Lowongan', false);
        $response->assertSee('Dashboard', false);
    }
}
