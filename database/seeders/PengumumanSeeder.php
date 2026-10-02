<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $pengumumans = [
            [
                'judul' => 'Jadwal Tes Minat Bakat dan Wawancara Gelombang 1',
                'slug' => 'jadwal-tes-minat-bakat-dan-wawancara-gelombang-1',
                'konten' => 'Pelaksanaan tes minat bakat dan wawancara untuk pendaftar gelombang pertama akan dilaksanakan secara luring di Gedung Sasana Bhakti SMKN 1 Surabaya. Harap membawa bukti pendaftaran dan kartu identitas.',
                'is_published' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Pengumuman Hasil Verifikasi Berkas Administrasi',
                'slug' => 'pengumuman-hasil-verifikasi-berkas-administrasi',
                'konten' => 'Hasil verifikasi administrasi dokumen Akta, Kartu Keluarga, dan Rapor/Ijazah dapat dipantau langsung pada menu dashboard calon siswa masing-masing. Bagi yang berstatus revisi, harap segera melengkapi dokumen.',
                'is_published' => true,
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($pengumumans as $item) {
            Pengumuman::firstOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }
    }
}
