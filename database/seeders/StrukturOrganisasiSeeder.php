<?php

namespace Database\Seeders;

use App\Models\StrukturOrganisasi;
use Illuminate\Database\Seeder;

class StrukturOrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        $wakils = [
            ['nama' => 'Dra. Hj. Siti Aminah, M.M.', 'jabatan' => 'Wakil Kepala Sekolah', 'bidang' => 'Kurikulum', 'nip' => '19670520 199303 2 003', 'kategori' => 'wakil', 'urutan' => 1],
            ['nama' => 'Drs. H. Agus Supriyadi, M.Pd.', 'jabatan' => 'Wakil Kepala Sekolah', 'bidang' => 'Kesiswaan', 'nip' => '19680115 199303 1 005', 'kategori' => 'wakil', 'urutan' => 2],
            ['nama' => 'Dra. Retnowati, M.M.', 'jabatan' => 'Wakil Kepala Sekolah', 'bidang' => 'Sarana & Prasarana', 'nip' => '19690325 199403 2 002', 'kategori' => 'wakil', 'urutan' => 3],
            ['nama' => 'Drs. H. Moch. Syaifuddin, M.M.', 'jabatan' => 'Wakil Kepala Sekolah', 'bidang' => 'Hubungan Masyarakat', 'nip' => '19700510 199503 1 001', 'kategori' => 'wakil', 'urutan' => 4],
        ];

        foreach ($wakils as $wakil) {
            StrukturOrganisasi::updateOrCreate(
                ['nama' => $wakil['nama'], 'kategori' => 'wakil'],
                $wakil
            );
        }

        $bagians = [
            ['nama' => 'Sekretariat', 'icon' => 'document-text', 'deskripsi' => 'Pengelolaan administrasi umum, surat-menyurat, dan kearsipan sekolah.', 'kategori' => 'bagian', 'urutan' => 1],
            ['nama' => 'Keuangan', 'icon' => 'currency-dollar', 'deskripsi' => 'Pengelolaan anggaran, pembukuan, dan pelaporan keuangan sekolah.', 'kategori' => 'bagian', 'urutan' => 2],
            ['nama' => 'Kepegawaian', 'icon' => 'users', 'deskripsi' => 'Pengelolaan data guru dan tenaga kependidikan, absensi, serta kesejahteraan.', 'kategori' => 'bagian', 'urutan' => 3],
            ['nama' => 'Kurikulum', 'icon' => 'academic-cap', 'deskripsi' => 'Perencanaan, pengembangan, dan evaluasi program pembelajaran.', 'kategori' => 'bagian', 'urutan' => 4],
            ['nama' => 'Kesiswaan', 'icon' => 'user-group', 'deskripsi' => 'Pembinaan karakter, organisasi siswa, dan kegiatan ekstrakurikuler.', 'kategori' => 'bagian', 'urutan' => 5],
            ['nama' => 'Hubungan Industri', 'icon' => 'building-office', 'deskripsi' => 'Kemitraan dengan DUDIKA, magang siswa, dan penyaluran lulusan.', 'kategori' => 'bagian', 'urutan' => 6],
        ];

        foreach ($bagians as $bagian) {
            StrukturOrganisasi::updateOrCreate(
                ['nama' => $bagian['nama'], 'kategori' => 'bagian'],
                $bagian
            );
        }
    }
}
