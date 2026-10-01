<?php

namespace Database\Seeders;

use App\Models\BimbinganKarir;
use App\Models\BimbinganKategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BimbinganKarirSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            ['nama' => 'Tips CV', 'slug' => 'tips-cv', 'icon' => 'document-text'],
            ['nama' => 'Tips Interview', 'slug' => 'tips-interview', 'icon' => 'chat'],
            ['nama' => 'Roadmap Karir', 'slug' => 'roadmap-karir', 'icon' => 'map'],
            ['nama' => 'Webinar', 'slug' => 'webinar', 'icon' => 'video'],
            ['nama' => 'Sertifikasi', 'slug' => 'sertifikasi', 'icon' => 'badge'],
        ];

        $katMap = [];
        foreach ($kategori as $item) {
            $katMap[$item['slug']] = BimbinganKategori::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $items = [
            [
                'kategori' => 'tips-cv',
                'title' => 'Cara Membuat CV Menarik untuk Fresh Graduate',
                'description' => 'Panduan menyusun CV ringkas yang mudah dibaca HRD dan lolos screening awal.',
            ],
            [
                'kategori' => 'tips-cv',
                'title' => 'Contoh CV Kreatif untuk Jurusan DKV',
                'description' => 'Inspirasi layout dan gaya CV untuk siswa desain komunikasi visual.',
            ],
            [
                'kategori' => 'tips-interview',
                'title' => 'Pertanyaan Wajib Interview & Cara Menjawabnya',
                'description' => 'Kumpulan pertanyaan umum interview magang dan lowongan beserta strategi jawaban.',
            ],
            [
                'kategori' => 'tips-interview',
                'title' => 'Simulasi Interview Bersama HRD Mitra',
                'description' => 'Materi simulasi wawancara bersama rekruter dari perusahaan mitra SMKN 1 Surabaya.',
            ],
            [
                'kategori' => 'roadmap-karir',
                'title' => 'Roadmap Karir Teknik Komputer & Informatika',
                'description' => 'Peta jalan karir dari fresh graduate hingga level menengah di industri IT.',
            ],
            [
                'kategori' => 'roadmap-karir',
                'title' => 'Menjelajah Karir di Dunia Otomotif',
                'description' => 'Peluang kerja dan jalur pengembangan untuk lulusan yang tertarik industri otomotif.',
            ],
            [
                'kategori' => 'sertifikasi',
                'title' => 'Sertifikasi BNSP: Apa yang Perlu Disiapkan?',
                'description' => 'Persiapan dokumen, materi uji, dan strategi lolos sertifikasi kompetensi BNSP.',
            ],
            [
                'kategori' => 'sertifikasi',
                'title' => 'Daftar Skema Sertifikasi untuk Lulusan SMK',
                'description' => 'Referensi skema sertifikasi yang relevan dengan kompetensi keahlian SMK.',
            ],
        ];

        foreach ($items as $item) {
            BimbinganKarir::updateOrCreate(
                ['slug' => Str::slug($item['title'])],
                [
                    'bimbingan_kategori_id' => $katMap[$item['kategori']]->id,
                    'title' => $item['title'],
                    'description' => $item['description'],
                    'external_url' => '#',
                    'is_published' => true,
                ]
            );
        }
    }
}
