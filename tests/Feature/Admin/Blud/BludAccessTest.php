<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\User;
use App\Support\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_blud_user_can_access_blud_pages_but_not_users(): void
    {
        $blud = User::factory()->blud()->create();

        $this->actingAs($blud)->get(route('admin.produk-blud.index'))->assertOk();
        $this->actingAs($blud)->get(route('admin.moderasi-blud.index'))->assertOk();
        $this->actingAs($blud)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($blud)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_blud_menu_contains_only_blud_and_dashboard(): void
    {
        $routes = array_column(AdminMenu::itemsFor(User::factory()->blud()->create()), 'route');

        $this->assertContains('admin.dashboard', $routes);
        $this->assertContains('admin.pesanan-blud.index', $routes);
        $this->assertContains('admin.produk-blud.index', $routes);
        $this->assertContains('admin.moderasi-blud.index', $routes);
        $this->assertNotContains('admin.users.index', $routes);
        $this->assertNotContains('admin.lowongan.index', $routes);
    }
}
