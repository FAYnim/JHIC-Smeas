<?php

namespace Tests\Feature;

use App\Models\Fasilitas;
use App\Models\Guru;
use App\Models\StrukturOrganisasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesWiringTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_and_tendik_page_renders_database_records(): void
    {
        Guru::create([
            'nama' => 'Prof. Testing Guru, M.Pd.',
            'jabatan' => 'Guru Kejuruan Khusus',
            'mapel' => 'Rekayasa Perangkat Lunak',
            'kategori' => 'guru',
            'warna' => 'from-blue-500 to-blue-700',
            'urutan' => 1,
            'is_active' => true,
        ]);

        Guru::create([
            'nama' => 'Staff Tendik Khusus, S.Kom.',
            'jabatan' => 'Kepala Laboratorium',
            'mapel' => 'Laboratorium Komputer',
            'kategori' => 'tendik',
            'warna' => 'from-slate-500 to-slate-700',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $response = $this->get(route('guru-dan-tenaga-kependidikan'));

        $response->assertOk();
        $response->assertSee('Prof. Testing Guru, M.Pd.');
        $response->assertSee('Guru Kejuruan Khusus');
        $response->assertSee('Staff Tendik Khusus, S.Kom.');
        $response->assertSee('Kepala Laboratorium');
    }

    public function test_struktur_organisasi_page_renders_database_records(): void
    {
        StrukturOrganisasi::create([
            'nama' => 'Drs. Pimpinan Wakil Khusus, M.M.',
            'bidang' => 'Kurikulum Unggulan',
            'nip' => '19750101 200001 1 001',
            'kategori' => 'wakil',
            'urutan' => 1,
        ]);

        StrukturOrganisasi::create([
            'nama' => 'Unit Pelayanan Mutu',
            'deskripsi' => 'Pengelolaan standar penjaminan mutu sekolah.',
            'kategori' => 'bagian',
            'icon' => 'document-text',
            'urutan' => 1,
        ]);

        $response = $this->get(route('struktur-organisasi'));

        $response->assertOk();
        $response->assertSee('Drs. Pimpinan Wakil Khusus, M.M.');
        $response->assertSee('Kurikulum Unggulan');
        $response->assertSee('Unit Pelayanan Mutu');
        $response->assertSee('Pengelolaan standar penjaminan mutu sekolah.');
    }

    public function test_sarana_dan_prasarana_page_renders_database_records(): void
    {
        Fasilitas::create([
            'nama' => 'Laboratorium VR Studio',
            'kategori' => 'pembelajaran',
            'desc' => null,
            'deskripsi' => 'Fasilitas mutakhir untuk simulasi virtual reality.',
            'jumlah' => '2 Ruang',
            'icon' => 'computer',
            'urutan' => 1,
        ]);

        Fasilitas::create([
            'nama' => 'Pusat Meditasi Siswa',
            'kategori' => 'pendukung',
            'deskripsi' => 'Sarana bimbingan konseling dan relaksasi.',
            'jumlah' => '1 Gedung',
            'icon' => 'building',
            'urutan' => 1,
        ]);

        $response = $this->get(route('sarana-dan-prasarana'));

        $response->assertOk();
        $response->assertSee('Laboratorium VR Studio');
        $response->assertSee('Fasilitas mutakhir untuk simulasi virtual reality.');
        $response->assertSee('Pusat Meditasi Siswa');
        $response->assertSee('Sarana bimbingan konseling dan relaksasi.');
    }
}
