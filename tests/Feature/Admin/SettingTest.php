<?php

namespace Tests\Feature\Admin;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;

    private User $humasUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->humasUser = User::factory()->create(['role' => User::ROLE_HUMAS]);
    }

    public function test_only_admin_can_access_settings(): void
    {
        $responseGuest = $this->get(route('admin.settings.edit'));
        $responseGuest->assertRedirect(route('login'));

        $responseHumas = $this->actingAs($this->humasUser)->get(route('admin.settings.edit'));
        $responseHumas->assertForbidden();

        $responseAdmin = $this->actingAs($this->adminUser)->get(route('admin.settings.edit'));
        $responseAdmin->assertOk();
    }

    public function test_admin_can_update_settings(): void
    {
        $response = $this->actingAs($this->adminUser)->put(route('admin.settings.update'), [
            'settings' => [
                'site_name' => 'SMK Negeri 1 Surabaya Hebat',
                'school_phone' => '031-88889999',
                'school_email' => 'halo@smkn1sby.sch.id',
                'social_instagram' => 'https://instagram.com/smkn1sby_official',
            ],
        ]);

        $response->assertRedirect(route('admin.settings.edit'));
        $response->assertSessionHas('success');

        $this->assertEquals('SMK Negeri 1 Surabaya Hebat', Setting::get('site_name'));
        $this->assertEquals('031-88889999', Setting::get('school_phone'));
        $this->assertEquals('halo@smkn1sby.sch.id', Setting::get('school_email'));
        $this->assertEquals('https://instagram.com/smkn1sby_official', Setting::get('social_instagram'));
    }
}
