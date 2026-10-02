<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Lowongan;
use App\Models\MitraPerusahaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BkkFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_lowongan_supports_is_published_and_logo_path(): void
    {
        $lowongan = Lowongan::create([
            'company_name' => 'PT Solusi Teknologi',
            'title' => 'Web Developer',
            'slug' => 'web-developer-solusi',
            'location' => 'Surabaya',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'deskripsi' => 'Deskripsi pekerjaan',
            'batas_pendaftaran' => now()->addMonth(),
            'durasi_pelaksanaan' => '6 Bulan',
            'is_published' => true,
            'logo_path' => 'logos/pt-solusi.png',
        ]);

        $this->assertDatabaseHas('lowongans', [
            'id' => $lowongan->id,
            'is_published' => 1,
            'logo_path' => 'logos/pt-solusi.png',
        ]);
    }

    public function test_mitra_supports_logo_path(): void
    {
        $mitra = MitraPerusahaan::create([
            'name' => 'PT Mitra Digital',
            'slug' => 'pt-mitra-digital',
            'short_name' => 'MitraDigi',
            'sector' => 'IT',
            'city' => 'Surabaya',
            'logo_path' => 'mitra/mitra-digi.png',
        ]);

        $this->assertDatabaseHas('mitra_perusahaans', [
            'id' => $mitra->id,
            'logo_path' => 'mitra/mitra-digi.png',
        ]);
    }
}
