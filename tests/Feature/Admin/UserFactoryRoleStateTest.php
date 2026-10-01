<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFactoryRoleStateTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_state_assigns_admin_role(): void
    {
        $user = User::factory()->admin()->create();

        $this->assertSame(User::ROLE_ADMIN, $user->role);
        $this->assertTrue($user->isAdmin());
    }

    public function test_bkk_state_assigns_bkk_role(): void
    {
        $this->assertSame(User::ROLE_BKK, User::factory()->bkk()->create()->role);
    }

    public function test_humas_state_assigns_humas_role(): void
    {
        $this->assertSame(User::ROLE_HUMAS, User::factory()->humas()->create()->role);
    }

    public function test_spmb_state_assigns_spmb_role(): void
    {
        $this->assertSame(User::ROLE_SPMB, User::factory()->spmb()->create()->role);
    }

    public function test_without_role_state_leaves_role_null(): void
    {
        $this->assertNull(User::factory()->withoutRole()->create()->role);
    }
}
