<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\Lowongan;
use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowonganApplyValidationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Lamar Uji',
            'asal_sekolah' => 'SMP Uji',
        ]);
    }

    public function test_non_numeric_nisn_is_rejected(): void
    {
        $lowongan = $this->makeLowongan();

        $response = $this->from(route('pusat-karir.lamar', $lowongan->slug))
            ->post(route('pusat-karir.store-lamar', $lowongan->slug), [
                'nisn' => 'ABC123',
                'consent' => 'on',
            ]);

        $response->assertSessionHasErrors('nisn');
        $response->assertRedirect();
    }

    public function test_unregistered_nisn_is_rejected(): void
    {
        $lowongan = $this->makeLowongan();

        $response = $this->from(route('pusat-karir.lamar', $lowongan->slug))
            ->post(route('pusat-karir.store-lamar', $lowongan->slug), [
                'nisn' => '9999999999',
                'consent' => 'on',
            ]);

        $response->assertSessionHasErrors('nisn');
        $this->assertDatabaseCount('magang_applications', 0);
    }

    public function test_regular_post_redirects_to_detail_with_flash(): void
    {
        $lowongan = $this->makeLowongan();

        $response = $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'consent' => 'on',
        ]);

        $response->assertRedirect(route('pusat-karir.detail', $lowongan->slug));
        $response->assertSessionHas('lamaran_success', function (array $data): bool {
            return $data['nisn'] === '1234567890'
                && str_starts_with($data['registration_code'], 'PKL-');
        });
    }

    public function test_json_request_still_receives_json(): void
    {
        $lowongan = $this->makeLowongan();

        $response = $this->postJson(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'consent' => 'on',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Ajuan lamaran magang Anda berhasil dikirim.',
        ]);
    }

    public function test_application_is_saved_with_unique_registration_code(): void
    {
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'consent' => 'on',
        ]);

        $this->assertDatabaseHas('magang_applications', [
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
        ]);

        $code = MagangApplication::query()->value('registration_code');

        $this->assertMatchesRegularExpression('/^PKL-[A-Z0-9-]+$/', $code);
        $this->assertNotSame('', $code);
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
            'dokumen' => [],
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
