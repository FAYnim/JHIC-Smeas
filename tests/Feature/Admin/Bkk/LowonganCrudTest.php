<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LowonganCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.lowongan.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_humas_role_is_forbidden(): void
    {
        $humas = User::factory()->humas()->create();
        $response = $this->actingAs($humas)->get(route('admin.lowongan.index'));
        $response->assertForbidden();
    }

    public function test_bkk_user_can_view_lowongan_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        Lowongan::factory()->create(['title' => 'Software Engineer PKL']);

        $response = $this->actingAs($bkk)->get(route('admin.lowongan.index'));
        $response->assertOk();
        $response->assertSee('Software Engineer PKL');
    }

    public function test_bkk_user_can_create_lowongan_with_auto_slug_and_logo(): void
    {
        Storage::fake('public');
        $bkk = User::factory()->bkk()->create();

        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->actingAs($bkk)->post(route('admin.lowongan.store'), [
            'company_name' => 'PT Inovasi Digital',
            'company_short' => 'Inovasi',
            'title' => 'Junior Web Programmer',
            'jenis' => 'magang',
            'location' => 'Surabaya',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'kuota' => 5,
            'metode_kerja' => 'On-site',
            'deskripsi' => 'Deskripsi pekerjaan magang...',
            'tanggung_jawab' => "Membuat fitur web\nDebugging error",
            'kualifikasi' => "Menguasai PHP & Laravel\nDisiplin",
            'benefits' => "Uang saku\nSertifikat",
            'batas_pendaftaran' => now()->addDays(20)->format('Y-m-d'),
            'is_published' => '1',
            'logo' => $file,
        ]);

        $response->assertRedirect(route('admin.lowongan.index'));
        $this->assertDatabaseHas('lowongans', [
            'company_name' => 'PT Inovasi Digital',
            'slug' => 'junior-web-programmer',
            'is_published' => 1,
        ]);

        $lowongan = Lowongan::where('slug', 'junior-web-programmer')->firstOrFail();
        $this->assertNotNull($lowongan->logo_path);
        Storage::disk('public')->assertExists($lowongan->logo_path);
    }

    public function test_bkk_user_can_toggle_publish(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create(['is_published' => true]);

        $response = $this->actingAs($bkk)->patch(route('admin.lowongan.toggle-publish', $lowongan));
        $response->assertRedirect();

        $this->assertFalse($lowongan->fresh()->is_published);
    }

    public function test_bkk_user_can_delete_lowongan(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create();

        $response = $this->actingAs($bkk)->delete(route('admin.lowongan.destroy', $lowongan));
        $response->assertRedirect(route('admin.lowongan.index'));

        $this->assertDatabaseMissing('lowongans', ['id' => $lowongan->id]);
    }

    public function test_store_without_optional_multiline_fields_succeeds(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->post(route('admin.lowongan.store'), [
            'company_name' => 'PT Tanpa Dokumen',
            'title' => 'Posisi Tanpa Dokumen',
            'jenis' => 'lowongan',
            'location' => 'Surabaya',
            'duration' => 'Full-time',
            'jurusan' => 'RPL',
            'kuota' => 2,
            'metode_kerja' => 'On-site',
            'deskripsi' => 'Deskripsi singkat.',
            'batas_pendaftaran' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.lowongan.index'));
        $this->assertDatabaseHas('lowongans', [
            'company_name' => 'PT Tanpa Dokumen',
            'title' => 'Posisi Tanpa Dokumen',
        ]);
    }

    public function test_create_form_has_no_durasi_pelaksanaan_field(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->get(route('admin.lowongan.create'));

        $response->assertOk();
        $response->assertDontSee('name="durasi_pelaksanaan"', false);
        $response->assertSee('name="duration"', false);
    }
}
