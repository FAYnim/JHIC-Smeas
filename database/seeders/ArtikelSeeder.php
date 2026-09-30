<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        Artikel::create([
            'title' => 'Tips Membuat CV yang Menarik untuk PKL',
            'slug' => 'tips-menarik-cv-pkl',
            'excerpt' => 'Pelajari cara membuat CV yang profesional dan menarik perhatian perusahaan untuk program PKL.',
            'content' => 'Membuat CV yang menarik adalah langkah pertama untuk mendapatkan tempat PKL yang diinginkan.',
            'kategori' => 'Tips CV',
            'published_at' => now()->subDays(1),
        ]);

        Artikel::create([
            'title' => 'Persiapan Interview Magang di Perusahaan Teknologi',
            'slug' => 'persiapan-interview-magang-tech',
            'excerpt' => 'Tips dan trik menghadapi interview magang di perusahaan teknologi ternama.',
            'content' => 'Interview magang adalah tahap penting dalam seleksi program PKL.',
            'kategori' => 'Tips Interview',
            'published_at' => now()->subDays(3),
        ]);

        Artikel::create([
            'title' => 'Roadmap Karir untuk Lulusan SMK Jurusan RPL',
            'slug' => 'roadmap-karir-lulusan-rpl',
            'excerpt' => 'Panduan lengkap roadmap karir untuk lulusan SMK jurusan RPL dari fresh graduate hingga senior.',
            'content' => 'Lulusan SMK jurusan RPL memiliki banyak peluang karir di industri teknologi.',
            'kategori' => 'Roadmap Karir',
            'published_at' => now()->subDays(5),
        ]);

        Artikel::create([
            'title' => 'Sertifikasi Kompetensi yang Wajib Dimiliki Siswa SMK',
            'slug' => 'sertifikasi-kompetensi-siswa-smk',
            'excerpt' => 'Daftar sertifikasi kompetensi yang dapat meningkatkan daya saing siswa SMK di dunia kerja.',
            'content' => 'Sertifikasi kompetensi menjadi nilai tambah yang signifikan di mata perusahaan.',
            'kategori' => 'Sertifikasi',
            'published_at' => now()->subDays(7),
        ]);

        Artikel::create([
            'title' => 'Cara Membangun Portofolio yang Menarik untuk PKL',
            'slug' => 'membangun-portofolio-menarik-pkl',
            'excerpt' => 'Panduan praktis membangun portofolio proyek yang bisa jadi nilai tambah saat mendaftar PKL.',
            'content' => 'Portofolio adalah bukti konkret kemampuan yang bisa Anda tunjukkan ke perusahaan.',
            'kategori' => 'Tips CV',
            'published_at' => now()->subDays(10),
        ]);
    }
}
