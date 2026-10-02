<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_one_account_per_role(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->assertDatabaseHas('users', ['email' => 'admin@smkn1.surabaya.sch.id', 'role' => 'admin']);
        $this->assertDatabaseHas('users', ['email' => 'bkk@smkn1.surabaya.sch.id', 'role' => 'bkk']);
        $this->assertDatabaseHas('users', ['email' => 'humas@smkn1.surabaya.sch.id', 'role' => 'humas']);
        $this->assertDatabaseHas('users', ['email' => 'spmb@smkn1.surabaya.sch.id', 'role' => 'spmb']);
    }

    public function test_seeder_is_idempotent(): void
    {
        $this->seed(AdminUserSeeder::class);
        $this->seed(AdminUserSeeder::class);

        $this->assertSame(4, User::query()->count());
    }

    public function test_seeded_account_can_authenticate(): void
    {
        $this->seed(AdminUserSeeder::class);

        $this->post(route('login.store'), [
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticated();
    }
}
