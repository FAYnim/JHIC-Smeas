<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'kategori' => 'Dokumen',
                'pertanyaan' => 'Berapa ukuran maksimal file dokumen?',
                'jawaban' => 'Maksimal 2MB per berkas. Format yang diterima: PDF, JPG, PNG.',
                'urutan' => 1,
                'is_active' => true,
            ],
            [
                'kategori' => 'Verifikasi',
                'pertanyaan' => 'Bagaimana jika dokumen saya ditolak panitia?',
                'jawaban' => 'Lihat status pada menu Dokumen. Jika ada catatan penolakan, unggah ulang berkas yang sesuai, lalu lanjutkan ke tahap berikutnya.',
                'urutan' => 2,
                'is_active' => true,
            ],
            [
                'kategori' => 'Pengumuman',
                'pertanyaan' => 'Kapan hasil pengumuman dirilis?',
                'jawaban' => 'Timbul setelah verifikasi administrasi selesai. Pantau menu Pengumuman secara berkala.',
                'urutan' => 3,
                'is_active' => true,
            ],
            [
                'kategori' => 'Formulir',
                'pertanyaan' => 'Apakah data bisa direvisi setelah formulir terkirim?',
                'jawaban' => 'Tidak. Setelah formulir terkirim, data terkunci. Jika ada kesalahan, hubungi panitia melalui halaman ini.',
                'urutan' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($faqs as $item) {
            Faq::firstOrCreate(
                ['pertanyaan' => $item['pertanyaan']],
                $item
            );
        }
    }
}
