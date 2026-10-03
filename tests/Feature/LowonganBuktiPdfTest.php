<?php

namespace Tests\Feature;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowonganBuktiPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_bukti_pdf_can_be_downloaded(): void
    {
        $lowongan = Lowongan::create([
            'company_name' => 'PT Uji',
            'company_short' => 'Uji',
            'is_mitra_dudi' => true,
            'title' => 'Intern',
            'slug' => 'uji-intern',
            'location' => 'Surabaya',
            'duration' => '3 Bulan',
            'jurusan' => 'RPL',
            'kuota' => 1,
            'metode_kerja' => 'On-site',
            'deskripsi' => 'x',
            'tanggung_jawab' => [],
            'kualifikasi' => [],
            'dokumen' => [],
            'benefits' => [],
            'batas_pendaftaran' => '2026-12-01',
            'durasi_pelaksanaan' => '3 Bulan',
            'status_kuota' => 'Tersedia',
            'pokja_nama' => 'P',
            'pokja_koordinator' => 'K',
            'pokja_wa' => '62800000000',
        ]);
        $application = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-UJI-20261003-ABCDEFGH',
            'status' => 'pending',
        ]);

        $response = $this->get(route('pusat-karir.bukti-lamar', $application->registration_code));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_unknown_code_returns_404(): void
    {
        $this->get(route('pusat-karir.bukti-lamar', 'PKL-TIDAK-ADA'))->assertNotFound();
    }
}
