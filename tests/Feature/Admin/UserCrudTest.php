<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    private User $bkkUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->bkkUser = User::factory()->create(['role' => User::ROLE_BKK]);
    }

    public function test_only_admin_can_access_user_crud(): void
    {
        $responseGuest = $this->get(route('admin.users.index'));
        $responseGuest->assertRedirect(route('login'));

        $responseBkk = $this->actingAs($this->bkkUser)->get(route('admin.users.index'));
        $responseBkk->assertForbidden();

        $responseAdmin = $this->actingAs($this->adminUser)->get(route('admin.users.index'));
        $responseAdmin->assertOk();
    }

    public function test_admin_can_create_new_staff_user(): void
    {
        $response = $this->actingAs($this->adminUser)->post(route('admin.users.store'), [
            'name' => 'Staf Humas Baru',
            'email' => 'humasbaru@smkn1sby.sch.id',
            'password' => 'password123',
            'role' => User::ROLE_HUMAS,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Staf Humas Baru',
            'email' => 'humasbaru@smkn1sby.sch.id',
            'role' => User::ROLE_HUMAS,
        ]);

        $newUser = User::where('email', 'humasbaru@smkn1sby.sch.id')->first();
        $this->assertTrue(Hash::check('password123', $newUser->password));
    }

    public function test_admin_can_update_user(): void
    {
        $staff = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'oldemail@smkn1sby.sch.id',
            'role' => User::ROLE_SPMB,
        ]);

        $response = $this->actingAs($this->adminUser)->put(route('admin.users.update', $staff), [
            'name' => 'New Name Updated',
            'email' => 'newemail@smkn1sby.sch.id',
            'password' => '', // kosong artinya tidak ganti password
            'role' => User::ROLE_BKK,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $staff->id,
            'name' => 'New Name Updated',
            'email' => 'newemail@smkn1sby.sch.id',
            'role' => User::ROLE_BKK,
        ]);
    }

    public function test_admin_can_delete_other_user(): void
    {
        $staff = User::factory()->create(['role' => User::ROLE_BKK]);

        $response = $this->actingAs($this->adminUser)->delete(route('admin.users.destroy', $staff));
        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $staff->id]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $response = $this->actingAs($this->adminUser)->delete(route('admin.users.destroy', $this->adminUser));
        $response->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $this->adminUser->id]);
    }
}
