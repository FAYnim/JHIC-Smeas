<?php

namespace Tests\Feature;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LowonganApplyUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_required_pdf_is_validated(): void
    {
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
        ])->assertSessionHasErrors('cvpdf');

        $this->assertDatabaseCount('magang_applications', 0);
    }

    public function test_non_pdf_is_rejected(): void
    {
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'cvpdf' => UploadedFile::fake()->create('cv.png', 10, 'image/png'),
        ])->assertSessionHasErrors('cvpdf');
    }

    public function test_uploaded_files_are_stored_and_recorded(): void
    {
        Storage::fake('public');
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'cvpdf' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            'portofolio' => 'https://example.com/porto',
        ])->assertSessionHasNoErrors();

        $application = MagangApplication::firstOrFail();
        $documents = collect($application->documents)->keyBy('key');

        $this->assertSame('file', $documents['cvpdf']['type']);
        Storage::disk('public')->assertExists($documents['cvpdf']['value']);
        $this->assertSame('https://example.com/porto', $documents['portofolio']['value']);
    }

    protected function makeLowongan(): Lowongan
    {
        return Lowongan::create([
            'company_name' => 'PT Telkom Indonesia',
            'company_short' => 'Telkom Indonesia',
            'is_mitra_dudi' => true,
            'title' => 'Software Engineer Intern (PKL)',
            'slug' => 'telkom-software-engineer-intern',
            'location' => 'Surabaya, Jatim',
            'duration' => '6 Bulan (Jan - Jun)',
            'jurusan' => 'Khusus RPL & SIJA',
            'kuota' => 2,
            'metode_kerja' => 'On-site (Surabaya)',
            'deskripsi' => 'Deskripsi contoh untuk testing.',
            'tanggung_jawab' => ['Mengerjakan tugas harian'],
            'kualifikasi' => ['Siswa aktif'],
            'dokumen' => [
                ['name' => 'CV.pdf', 'desc' => 'CV', 'type' => 'pdf'],
                ['name' => 'Portofolio', 'desc' => 'Link', 'type' => 'link'],
            ],
            'benefits' => ['Uang saku'],
            'batas_pendaftaran' => '2026-08-15',
            'durasi_pelaksanaan' => '6 Bulan',
            'status_kuota' => 'Tersedia',
            'pokja_nama' => 'Pokja PKL',
            'pokja_koordinator' => 'Bpk. Test',
            'pokja_wa' => '6281234567890',
        ]);
    }
}
