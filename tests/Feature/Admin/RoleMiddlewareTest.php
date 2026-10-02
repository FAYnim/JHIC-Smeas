<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_user_with_wrong_role_gets_403(): void
    {
        $bkk = User::factory()->bkk()->create();

        $this->actingAs($bkk)
            ->get('/admin-humas-only')
            ->assertForbidden();
    }

    public function test_user_with_matching_role_is_allowed(): void
    {
        $humas = User::factory()->humas()->create();

        $this->actingAs($humas)
            ->get('/admin-humas-only')
            ->assertOk();
    }

    public function test_admin_passes_every_role_check(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get('/admin-humas-only')
            ->assertOk();
    }

    public function test_user_without_role_gets_403(): void
    {
        $staff = User::factory()->withoutRole()->create();

        $this->actingAs($staff)
            ->get('/admin-humas-only')
            ->assertForbidden();
    }

    public function test_multiple_allowed_roles_are_supported(): void
    {
        $bkk = User::factory()->bkk()->create();

        $this->actingAs($bkk)
            ->get('/admin-bkk-or-humas')
            ->assertOk();
    }
}
