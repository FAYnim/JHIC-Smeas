<?php

namespace Tests\Feature;

use App\Models\Artikel;
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
}
