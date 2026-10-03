<?php

namespace Database\Seeders;

use App\Models\SumberRekomendasi;
use Illuminate\Database\Seeder;

class SumberRekomendasiSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            ['title' => 'LinkedIn Jobs', 'url' => 'https://www.linkedin.com/jobs', 'kategori' => 'Lowongan Kerja', 'urutan' => 1],
            ['title' => 'Glints', 'url' => 'https://glints.com/id', 'kategori' => 'Lowongan Kerja', 'urutan' => 2],
            ['title' => 'Dicoding', 'url' => 'https://www.dicoding.com', 'kategori' => 'Kursus & Sertifikasi', 'urutan' => 3],
            ['title' => 'Dibimbing', 'url' => 'https://www.dibimbing.id', 'kategori' => 'Bimbingan Karir', 'urutan' => 4],
            ['title' => 'JobStreet Indonesia', 'url' => 'https://www.jobstreet.co.id', 'kategori' => 'Lowongan Kerja', 'urutan' => 5],
        ];

        foreach ($sources as $source) {
            SumberRekomendasi::updateOrCreate(['url' => $source['url']], $source + ['is_active' => true]);
        }
    }
}
