<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\BimbinganKarir;
use App\Models\BimbinganKategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BimbinganCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_bimbingan_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        $kat = BimbinganKategori::create(['nama' => 'Tips CV', 'slug' => 'tips-cv']);
        BimbinganKarir::create([
            'bimbingan_kategori_id' => $kat->id,
            'title' => 'Panduan CV ATS Friendly',
            'slug' => 'panduan-cv-ats-friendly',
            'description' => 'Langkah membuat CV ramah ATS',
            'is_published' => true,
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.bimbingan.index'));
        $response->assertOk();
        $response->assertSee('Panduan CV ATS Friendly');
    }

    public function test_bkk_user_can_create_bimbingan(): void
    {
        $bkk = User::factory()->bkk()->create();
        $kat = BimbinganKategori::create(['nama' => 'Tips Interview', 'slug' => 'tips-interview']);

        $response = $this->actingAs($bkk)->post(route('admin.bimbingan.store'), [
            'bimbingan_kategori_id' => $kat->id,
            'title' => 'Menghadapi User Interview',
            'description' => 'Tips saat wawancara dengan calon atasan',
            'external_url' => 'https://example.com/tips',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.bimbingan.index'));
        $this->assertDatabaseHas('bimbingan_karirs', [
            'title' => 'Menghadapi User Interview',
            'slug' => 'menghadapi-user-interview',
            'bimbingan_kategori_id' => $kat->id,
            'is_published' => 1,
        ]);
    }

    public function test_public_pusat_karir_displays_bimbingan_from_database(): void
    {
        $kat = BimbinganKategori::create(['nama' => 'Tips CV', 'slug' => 'tips-cv']);
        BimbinganKarir::create([
            'bimbingan_kategori_id' => $kat->id,
            'title' => 'Judul Bimbingan Dinamis DB',
            'slug' => 'judul-bimbingan-dinamis-db',
            'description' => 'Deskripsi dinamis',
            'external_url' => '#',
            'is_published' => true,
        ]);

        $response = $this->get(route('pusat-karir.index'));
        $response->assertOk();
        $response->assertSee('Judul Bimbingan Dinamis DB');
    }
}
