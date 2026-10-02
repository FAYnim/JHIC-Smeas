<?php

namespace Tests\Feature\Admin;

use App\Models\CalonSiswa;
use App\Models\Faq;
use App\Models\Pengumuman;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Fase4ModelMigrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_calon_siswa_has_status_verifikasi_columns(): void
    {
        $calonSiswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Ahmad Santoso',
            'asal_sekolah' => 'SMPN 1 Surabaya',
            'status_verifikasi' => 'terverifikasi',
            'catatan_verifikasi' => 'Dokumen lengkap dan valid',
        ]);

        $this->assertDatabaseHas('calon_siswas', [
            'nisn' => '1234567890',
            'status_verifikasi' => 'terverifikasi',
            'catatan_verifikasi' => 'Dokumen lengkap dan valid',
        ]);

        $this->assertEquals('terverifikasi', $calonSiswa->status_verifikasi);
    }

    public function test_pengumuman_can_be_created_and_queried(): void
    {
        $pengumuman = Pengumuman::create([
            'judul' => 'Hasil Seleksi Gelombang 1',
            'slug' => 'hasil-seleksi-gelombang-1',
            'konten' => 'Selamat bagi calon siswa yang telah diterima.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->assertDatabaseHas('pengumumans', [
            'slug' => 'hasil-seleksi-gelombang-1',
            'is_published' => true,
        ]);

        $this->assertTrue(Pengumuman::published()->where('id', $pengumuman->id)->exists());
    }

    public function test_faq_can_be_created_and_queried(): void
    {
        $faq = Faq::create([
            'kategori' => 'Dokumen',
            'pertanyaan' => 'Berapa batas ukuran dokumen?',
            'jawaban' => 'Maksimal 2MB per file.',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('faqs', [
            'pertanyaan' => 'Berapa batas ukuran dokumen?',
            'is_active' => true,
        ]);

        $this->assertTrue(Faq::active()->where('id', $faq->id)->exists());
    }

    public function test_setting_get_and_set_methods_work_properly(): void
    {
        Setting::set('site_name', 'SMKN 1 Surabaya', 'general');
        Setting::set('school_phone', '031-123456', 'contact');

        $this->assertEquals('SMKN 1 Surabaya', Setting::get('site_name'));
        $this->assertEquals('031-123456', Setting::get('school_phone'));
        $this->assertEquals('Default Value', Setting::get('non_existent_key', 'Default Value'));

        Setting::set('site_name', 'SMK Negeri 1 Surabaya Updated');
        $this->assertEquals('SMK Negeri 1 Surabaya Updated', Setting::get('site_name'));
    }
}
