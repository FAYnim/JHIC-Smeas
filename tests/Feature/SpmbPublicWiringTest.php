<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use App\Models\Faq;
use App\Models\Pengumuman;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpmbPublicWiringTest extends TestCase
{
    use RefreshDatabase;

    public function test_spmb_pengumuman_page_displays_announcements_from_database(): void
    {
        $calonSiswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Pratama',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);

        Pengumuman::create([
            'judul' => 'Pengumuman Hasil Verifikasi Berkas 2026',
            'slug' => 'pengumuman-hasil-verifikasi-berkas-2026',
            'konten' => 'Semua berkas telah berhasil diverifikasi oleh panitia.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $response = $this->withSession(['spmb_nisn' => $calonSiswa->nisn])
            ->get(route('spmb.pengumuman'));

        $response->assertOk();
        $response->assertSee('Pengumuman Hasil Verifikasi Berkas 2026');
        $response->assertSee('Semua berkas telah berhasil diverifikasi oleh panitia.');
    }

    public function test_spmb_bantuan_page_displays_faqs_and_settings_from_database(): void
    {
        $calonSiswa = CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Budi Pratama',
            'asal_sekolah' => 'SMPN 1 Surabaya',
        ]);

        Faq::create([
            'kategori' => 'Dokumen',
            'pertanyaan' => 'Bagaimana jika berkas kartu keluarga buram?',
            'jawaban' => 'Silakan unggah ulang scan dokumen asli dengan resolusi jelas.',
            'urutan' => 1,
            'is_active' => true,
        ]);

        Setting::set('spmb_contact_email', 'panitia-spmb@smkn1sby.sch.id', 'spmb');
        Setting::set('spmb_contact_phone', '0812-9999-8888', 'spmb');

        $response = $this->withSession(['spmb_nisn' => $calonSiswa->nisn])
            ->get(route('spmb.bantuan'));

        $response->assertOk();
        $response->assertSee('Bagaimana jika berkas kartu keluarga buram?');
        $response->assertSee('Silakan unggah ulang scan dokumen asli dengan resolusi jelas.');
        $response->assertSee('panitia-spmb@smkn1sby.sch.id');
        $response->assertSee('0812-9999-8888');
    }
}
