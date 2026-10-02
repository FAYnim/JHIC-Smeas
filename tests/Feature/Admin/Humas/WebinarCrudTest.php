<?php

namespace Tests\Feature\Admin\Humas;

use App\Models\User;
use App\Models\Webinar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebinarCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $humas;

    private User $bkk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->humas = User::factory()->create(['role' => User::ROLE_HUMAS]);
        $this->bkk = User::factory()->create(['role' => User::ROLE_BKK]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.webinar.index'))->assertRedirect(route('login'));
    }

    public function test_bkk_is_forbidden(): void
    {
        $this->actingAs($this->bkk)->get(route('admin.webinar.index'))->assertForbidden();
    }

    public function test_humas_can_view_index(): void
    {
        $this->actingAs($this->humas)->get(route('admin.webinar.index'))->assertOk();
    }

    public function test_can_create_webinar(): void
    {
        $response = $this->actingAs($this->humas)->post(route('admin.webinar.store'), [
            'title' => 'Strategi Menembus Magang Internasional 2026',
            'slug' => '',
            'description' => 'Webinar inspiratif tips dan trik lolos seleksi magang luar negeri.',
            'speaker' => 'Dr. Hendra Gunawan',
            'platform' => 'Zoom Meeting',
            'location' => 'Online via Zoom',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'start_time' => '09:00 WIB',
            'registration_url' => 'https://zoom.us/webinar/register/12345',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.webinar.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('webinars', [
            'title' => 'Strategi Menembus Magang Internasional 2026',
            'speaker' => 'Dr. Hendra Gunawan',
            'is_published' => 1,
        ]);
    }

    public function test_can_update_webinar(): void
    {
        $webinar = Webinar::create([
            'title' => 'Webinar Lama',
            'slug' => 'webinar-lama',
            'description' => 'Deskripsi lama',
            'speaker' => 'Pembicara Lama',
            'platform' => 'Zoom',
            'location' => 'Online',
            'start_date' => now()->addDays(5),
            'start_time' => '10:00 WIB',
            'registration_url' => 'https://example.com/reg',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->humas)->put(route('admin.webinar.update', $webinar), [
            'title' => 'Webinar Diperbarui',
            'slug' => 'webinar-diperbarui',
            'description' => 'Deskripsi baru',
            'speaker' => 'Pembicara Baru',
            'platform' => 'Google Meet',
            'location' => 'Online Meet',
            'start_date' => now()->addDays(10)->format('Y-m-d'),
            'start_time' => '13:00 WIB',
            'registration_url' => 'https://meet.google.com/xyz',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.webinar.index'));
        $this->assertDatabaseHas('webinars', [
            'id' => $webinar->id,
            'title' => 'Webinar Diperbarui',
            'platform' => 'Google Meet',
        ]);
    }

    public function test_can_toggle_publish(): void
    {
        $webinar = Webinar::create([
            'title' => 'Webinar Toggle',
            'slug' => 'webinar-toggle',
            'description' => 'Deskripsi',
            'speaker' => 'Pembicara',
            'platform' => 'Zoom',
            'location' => 'Online',
            'start_date' => now()->addDays(3),
            'start_time' => '09:00 WIB',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->humas)->patch(route('admin.webinar.toggle-publish', $webinar));

        $response->assertRedirect();
        $this->assertDatabaseHas('webinars', [
            'id' => $webinar->id,
            'is_published' => 0,
        ]);
    }

    public function test_can_delete_webinar(): void
    {
        $webinar = Webinar::create([
            'title' => 'Webinar Dihapus',
            'slug' => 'webinar-dihapus',
            'description' => 'Deskripsi',
            'speaker' => 'Pembicara',
            'platform' => 'Zoom',
            'location' => 'Online',
            'start_date' => now()->addDays(2),
            'start_time' => '10:00 WIB',
            'is_published' => true,
        ]);

        $response = $this->actingAs($this->humas)->delete(route('admin.webinar.destroy', $webinar));

        $response->assertRedirect(route('admin.webinar.index'));
        $this->assertDatabaseMissing('webinars', ['id' => $webinar->id]);
    }
}
