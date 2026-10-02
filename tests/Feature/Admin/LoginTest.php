<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get(route('login'))->assertOk();
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $bkk = User::factory()->bkk()->create([
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($bkk);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->bkk()->create([
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'bkk@smkn1.surabaya.sch.id',
            'password' => 'salah-total',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_for_unknown_email(): void
    {
        $this->post(route('login.store'), [
            'email' => 'tidak-ada@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_account_without_role_is_rejected(): void
    {
        User::factory()->withoutRole()->create([
            'email' => 'baru@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'baru@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_requires_email_and_password(): void
    {
        $this->post(route('login.store'), [])
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_user_can_logout(): void
    {
        $bkk = User::factory()->bkk()->create();

        $this->actingAs($bkk)
            ->post(route('logout'))
            ->assertRedirect(route('beranda'));

        $this->assertGuest();
    }
}
