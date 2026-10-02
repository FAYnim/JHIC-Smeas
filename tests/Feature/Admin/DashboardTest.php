<?php

namespace Tests\Feature\Admin;

use App\Models\Artikel;
use App\Models\CalonSiswa;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\MitraPerusahaan;
use App\Models\User;
use App\Models\Webinar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_sees_pusat_karir_statistics(): void
    {
        Lowongan::factory()->create();
        MitraPerusahaan::create($this->mitraPayload());

        $response = $this->actingAs(User::factory()->bkk()->create())
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Total Lowongan');
        $response->assertSee('Mitra DUDI');
        $response->assertSee('Lamaran Menunggu');
        $response->assertDontSee('Total Artikel');
        $response->assertDontSee('Total Calon Siswa');
    }

    public function test_bkk_pending_application_count_is_shown(): void
    {
        $lowongan = Lowongan::factory()->create();

        MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-TEST-1',
            'status' => 'pending',
        ]);

        $response = $this->actingAs(User::factory()->bkk()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Lamaran Menunggu');
        $response->assertSee('1', false);
    }

    public function test_humas_sees_content_statistics_only(): void
    {
        Artikel::create([
            'title' => 'Judul Artikel Uji',
            'slug' => 'judul-artikel-uji',
            'excerpt' => 'Ringkasan.',
            'content' => 'Isi artikel.',
            'kategori' => 'Berita',
            'published_at' => now(),
        ]);

        Webinar::create([
            'title' => 'Webinar Uji',
            'slug' => 'webinar-uji',
            'description' => 'Deskripsi.',
            'speaker' => 'Narasumber',
            'platform' => 'Zoom',
            'location' => 'Online',
            'start_date' => '2026-11-01',
            'start_time' => '09:00',
            'registration_url' => 'https://example.com',
            'is_published' => true,
        ]);

        $response = $this->actingAs(User::factory()->humas()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Total Artikel');
        $response->assertSee('Total Webinar');
        $response->assertDontSee('Total Lowongan');
        $response->assertDontSee('Mitra DUDI');
    }

    public function test_spmb_sees_calon_siswa_statistics_only(): void
    {
        CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Uji',
            'asal_sekolah' => 'SD Uji',
            'jurusan_pilihan' => 'RPL',
        ]);

        $response = $this->actingAs(User::factory()->spmb()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Total Calon Siswa');
        $response->assertDontSee('Total Lowongan');
        $response->assertDontSee('Total Artikel');
    }

    public function test_admin_sees_all_domains(): void
    {
        Lowongan::factory()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Total Lowongan');
        $response->assertSee('Mitra DUDI');
        $response->assertSee('Total Artikel');
        $response->assertSee('Total Calon Siswa');
    }

    public function test_dashboard_lists_recent_items_for_role_domain(): void
    {
        Lowongan::factory()->create([
            'title' => 'Lowongan Terbaru Uji',
            'company_name' => 'PT Uji Sentosa',
        ]);

        $response = $this->actingAs(User::factory()->bkk()->create())
            ->get(route('admin.dashboard'));

        $response->assertSee('Lowongan Terbaru Uji');
    }

    /**
     * @return array<string, mixed>
     */
    protected function mitraPayload(): array
    {
        return [
            'name' => 'PT Contoh Mitra',
            'slug' => 'pt-contoh-mitra',
            'short_name' => 'Contoh Mitra',
            'sector' => 'Teknologi',
            'city' => 'Surabaya',
            'description' => 'Deskripsi mitra.',
            'logo_color' => '#123456',
            'logo_text' => 'CM',
            'is_mou_active' => true,
        ];
    }
}
