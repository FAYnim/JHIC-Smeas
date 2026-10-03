<?php

namespace Tests\Feature\Admin\Blud;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BludRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_blud_role_can_be_stored_and_has_label(): void
    {
        $user = User::factory()->blud()->create();

        $this->assertSame(User::ROLE_BLUD, $user->fresh()->role);
        $this->assertSame('Staf BLUD', $user->roleLabel());
    }

    public function test_admin_can_create_blud_user(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => 'Staf BLUD',
            'email' => 'blud@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => User::ROLE_BLUD,
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['email' => 'blud@example.test', 'role' => 'blud']);
    }
}
