<?php

namespace Tests\Feature;

use App\Models\Artikel;
use App\Models\Guru;
use App\Models\Lowongan;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_visi_misi_page_displays_dynamic_content(): void
    {
        Setting::set('profil.visi', 'Visi Test Unik', 'profil');
        Setting::set('profil.misi', 'Misi Test Unik', 'profil');

        $response = $this->get(route('visi-misi'));

        $response->assertStatus(200);
        $response->assertSee('Visi Test Unik');
        $response->assertSee('Misi Test Unik');
    }

    public function test_beranda_displays_prakata_from_settings(): void
    {
        Setting::set('profil.prakata_nama', 'Kepala Sekolah Test Unik', 'profil');

        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee('Kepala Sekolah Test Unik');
    }

    public function test_beranda_displays_gurus_from_database(): void
    {
        Guru::create([
            'nama' => 'Guru Carousel Khusus, S.Pd.',
            'jabatan' => 'Guru Bahasa Indonesia',
            'mapel' => 'Bahasa Indonesia',
            'kategori' => 'guru',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee('Guru Carousel Khusus, S.Pd.');
    }

    public function test_beranda_shows_empty_state_when_no_artikels(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee('Belum ada berita.');
    }

    public function test_jurusan_page_displays_stats(): void
    {
        Lowongan::factory()->create(['is_published' => true]);
        Lowongan::factory()->create(['is_published' => true]);

        $response = $this->get(route('jurusan'));

        $response->assertStatus(200);
        $response->assertSee('2');
    }

    public function test_informasi_page_displays_artikels(): void
    {
        Artikel::factory()->create(['kategori' => 'berita', 'title' => 'Berita Test Unik']);

        $response = $this->get(route('informasi'));

        $response->assertStatus(200);
        $response->assertSee('Berita Test Unik');
    }

    public function test_informasi_prestasi_page_filters_by_kategori(): void
    {
        Artikel::factory()->create(['kategori' => 'prestasi', 'title' => 'Prestasi Test Unik']);

        $response = $this->get(route('informasi.prestasi'));

        $response->assertStatus(200);
        $response->assertSee('Prestasi Test Unik');
    }

    public function test_informasi_akademik_page_filters_by_kategori(): void
    {
        Artikel::factory()->create(['kategori' => 'akademik', 'title' => 'Akademik Test Unik']);

        $response = $this->get(route('informasi.akademik'));

        $response->assertStatus(200);
        $response->assertSee('Akademik Test Unik');
    }

    public function test_beranda_major_finder_section_links_to_temukan_jurusan(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertOk();
        $response->assertSee(route('temukan-jurusan'));
        $response->assertSee('AI-Powered Recommendation');
    }
}
