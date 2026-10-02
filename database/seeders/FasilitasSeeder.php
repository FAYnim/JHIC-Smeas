<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $pembelajaran = [
            ['nama' => 'Ruang Kelas', 'icon' => 'building', 'deskripsi' => 'Ruang kelas ber AC dengan kapasitas 32 siswa per kelas, dilengkapi proyektor dan papan tulis digital.', 'jumlah' => '72 Ruang', 'kategori' => 'pembelajaran', 'urutan' => 1],
            ['nama' => 'Lab Komputer', 'icon' => 'computer', 'deskripsi' => 'Laboratorium komputer dengan perangkat terbaru untuk pembelajaran TIK, pemrograman, dan jaringan.', 'jumlah' => '6 Lab', 'kategori' => 'pembelajaran', 'urutan' => 2],
            ['nama' => 'Lab Akuntansi', 'icon' => 'calculator', 'deskripsi' => 'Laboratorium khusus akuntansi dengan software MYOB dan Accurate untuk praktik pembukuan.', 'jumlah' => '2 Lab', 'kategori' => 'pembelajaran', 'urutan' => 3],
            ['nama' => 'Perpustakaan', 'icon' => 'book', 'deskripsi' => 'Perpustakaan modern dengan koleksi buku, jurnal, dan akses e-learning untuk seluruh siswa.', 'jumlah' => '1 Gedung', 'kategori' => 'pembelajaran', 'urutan' => 4],
            ['nama' => 'Ruang Multimedia', 'icon' => 'film', 'deskripsi' => 'Studio multimedia untuk pembelajaran desain, video editing, dan produksi konten digital.', 'jumlah' => '2 Ruang', 'kategori' => 'pembelajaran', 'urutan' => 5],
            ['nama' => 'Lab Bahasa', 'icon' => 'language', 'deskripsi' => 'Laboratorium bahasa dengan sistem audio digital untuk pelatihan listening dan speaking.', 'jumlah' => '1 Lab', 'kategori' => 'pembelajaran', 'urutan' => 6],
        ];

        foreach ($pembelajaran as $f) {
            Fasilitas::updateOrCreate(
                ['nama' => $f['nama'], 'kategori' => 'pembelajaran'],
                $f
            );
        }

        $pendukung = [
            ['nama' => 'Masjid Al-Ikhlas', 'icon' => 'mosque', 'deskripsi' => 'Masjid sekolah untuk kegiatan ibadah dan pembinaan karakter religius siswa.', 'jumlah' => '1 Gedung', 'kategori' => 'pendukung', 'urutan' => 1],
            ['nama' => 'Aula Serbaguna', 'icon' => 'stage', 'deskripsi' => 'Aula besar untuk upacara, seminar, pameran, dan kegiatan kemasyarakatan lainnya.', 'jumlah' => '1 Aula', 'kategori' => 'pendukung', 'urutan' => 2],
            ['nama' => 'Lapangan Olahraga', 'icon' => 'sport', 'deskripsi' => 'Lapangan basket, voli, dan futsal untuk kegiatan olahraga dan ekstrakurikuler.', 'jumlah' => '3 Lapangan', 'kategori' => 'pendukung', 'urutan' => 3],
            ['nama' => 'Kantin Sekolah', 'icon' => 'food', 'deskripsi' => 'Area makan yang bersih dan hygienis dengan berbagai pilihan makanan bergizi.', 'jumlah' => '1 Pujasera', 'kategori' => 'pendukung', 'urutan' => 4],
            ['nama' => 'Ruang UKS', 'icon' => 'medical', 'deskripsi' => 'Unit kesehatan sekolah dengan peralatan dasar untuk penanganan siswa yang sakit.', 'jumlah' => '2 Ruang', 'kategori' => 'pendukung', 'urutan' => 5],
            ['nama' => 'Parkir & Area Hijau', 'icon' => 'park', 'deskripsi' => 'Area parkir yang luas dan taman hijau yang asri untuk kenyamanan lingkungan sekolah.', 'jumlah' => 'Area Luas', 'kategori' => 'pendukung', 'urutan' => 6],
        ];

        foreach ($pendukung as $f) {
            Fasilitas::updateOrCreate(
                ['nama' => $f['nama'], 'kategori' => 'pendukung'],
                $f
            );
        }
    }
}
