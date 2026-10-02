<?php

namespace Tests\Feature\Admin\Humas;

use App\Models\Artikel;
use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\StrukturOrganisasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HumasModelMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_model_and_migration(): void
    {
        $guru = Guru::create([
            'nama' => 'Budi Santoso, S.Pd.',
            'jabatan' => 'Guru Umum',
            'mapel' => 'Bahasa Inggris',
            'kategori' => 'guru',
            'foto_path' => 'guru/budi.jpg',
            'warna' => 'from-indigo-500 to-indigo-700',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('gurus', [
            'id' => $guru->id,
            'nama' => 'Budi Santoso, S.Pd.',
            'kategori' => 'guru',
            'is_active' => 1,
        ]);
        $this->assertTrue($guru->is_active);
    }

    public function test_struktur_organisasi_model_and_migration(): void
    {
        $struktur = StrukturOrganisasi::create([
            'nama' => 'Dra. Hj. Siti Aminah, M.M.',
            'jabatan' => 'Wakil Kepala Sekolah',
            'nip' => '19670520 199303 2 003',
            'bidang' => 'Kurikulum',
            'deskripsi' => 'Pengelolaan kurikulum sekolah',
            'kategori' => 'wakil',
            'icon' => null,
            'foto_path' => 'struktur/siti.jpg',
            'urutan' => 1,
        ]);

        $this->assertDatabaseHas('struktur_organisasis', [
            'id' => $struktur->id,
            'bidang' => 'Kurikulum',
            'kategori' => 'wakil',
        ]);
    }

    public function test_fasilitas_model_and_migration(): void
    {
        $fasilitas = Fasilitas::create([
            'nama' => 'Lab Komputer',
            'kategori' => 'pembelajaran',
            'deskripsi' => 'Laboratorium komputer dengan perangkat terbaru',
            'jumlah' => '6 Lab',
            'icon' => 'computer',
            'image_path' => 'fasilitas/lab-komputer.jpg',
            'urutan' => 2,
        ]);

        $this->assertDatabaseHas('fasilitas', [
            'id' => $fasilitas->id,
            'nama' => 'Lab Komputer',
            'kategori' => 'pembelajaran',
        ]);
    }

    public function test_artikel_supports_image_path(): void
    {
        $artikel = Artikel::create([
            'title' => 'Judul Artikel Humas',
            'slug' => 'judul-artikel-humas',
            'excerpt' => 'Ringkasan artikel',
            'content' => 'Konten lengkap artikel humas',
            'kategori' => 'Prestasi',
            'published_at' => now(),
            'image_path' => 'artikels/humas.jpg',
        ]);

        $this->assertDatabaseHas('artikels', [
            'id' => $artikel->id,
            'image_path' => 'artikels/humas.jpg',
        ]);
    }
}
