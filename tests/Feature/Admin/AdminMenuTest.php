<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\AdminMenu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_role_sees_the_dashboard_item(): void
    {
        foreach ([User::ROLE_ADMIN, User::ROLE_BKK, User::ROLE_HUMAS, User::ROLE_SPMB, User::ROLE_BLUD] as $role) {
            $items = AdminMenu::itemsFor(User::factory()->create(['role' => $role]));

            $this->assertSame('admin.dashboard', $items[0]['route'], "Role {$role} harus punya dashboard.");
        }
    }

    public function test_bkk_sees_lowongan_but_not_artikel(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->bkk()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.lowongan.index', $routes);
        $this->assertNotContains('admin.guru.index', $routes);
    }

    public function test_humas_sees_artikel_but_not_lowongan(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->humas()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.artikel.index', $routes);
        $this->assertNotContains('admin.lowongan.index', $routes);
    }

    public function test_spmb_sees_calon_siswa_but_not_mitra(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->spmb()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.calon-siswa.index', $routes);
        $this->assertNotContains('admin.mitra.index', $routes);
    }

    public function test_admin_sees_every_menu_item(): void
    {
        $items = AdminMenu::itemsFor(User::factory()->admin()->create());

        $routes = array_column($items, 'route');

        $this->assertContains('admin.lowongan.index', $routes);
        $this->assertContains('admin.users.index', $routes);
        $this->assertContains('admin.settings.edit', $routes);
    }
}
