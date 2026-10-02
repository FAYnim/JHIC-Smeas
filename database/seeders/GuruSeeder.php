<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = [
            ['nama' => 'Yourini Erawati, S.Pd., M.M.', 'jabatan' => 'Ketua Program Akuntansi', 'mapel' => 'Akuntansi', 'warna' => 'from-blue-500 to-blue-700', 'kategori' => 'guru', 'urutan' => 1],
            ['nama' => 'Dra. Hj. Siti Aminah, M.M.', 'jabatan' => 'WKS Kurikulum', 'mapel' => 'Matematika', 'warna' => 'from-emerald-500 to-emerald-700', 'kategori' => 'guru', 'urutan' => 2],
            ['nama' => 'Rudi Hartono, S.Pd.', 'jabatan' => 'Guru Produktif', 'mapel' => 'TIK & Jaringan', 'warna' => 'from-violet-500 to-violet-700', 'kategori' => 'guru', 'urutan' => 3],
            ['nama' => 'Dewi Kartika, S.Pd.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Perhotelan', 'warna' => 'from-rose-500 to-rose-700', 'kategori' => 'guru', 'urutan' => 4],
            ['nama' => 'Ahmad Fauzi, S.Kom.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Pemrograman', 'warna' => 'from-amber-500 to-amber-700', 'kategori' => 'guru', 'urutan' => 5],
            ['nama' => 'Sri Wahyuni, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'Bahasa Indonesia', 'warna' => 'from-cyan-500 to-cyan-700', 'kategori' => 'guru', 'urutan' => 6],
            ['nama' => 'Budi Santoso, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'Bahasa Inggris', 'warna' => 'from-indigo-500 to-indigo-700', 'kategori' => 'guru', 'urutan' => 7],
            ['nama' => 'Rina Marlina, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'PJOK', 'warna' => 'from-teal-500 to-teal-700', 'kategori' => 'guru', 'urutan' => 8],
            ['nama' => 'Hendra Wijaya, S.Pd.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Otomotif', 'warna' => 'from-orange-500 to-orange-700', 'kategori' => 'guru', 'urutan' => 9],
            ['nama' => 'Nina Agustina, S.E.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Bisnis Digital', 'warna' => 'from-pink-500 to-pink-700', 'kategori' => 'guru', 'urutan' => 10],
            ['nama' => 'Dedi Kurniawan, S.Kom.', 'jabatan' => 'Guru Produktif', 'mapel' => 'Jaringan Komputer', 'warna' => 'from-sky-500 to-sky-700', 'kategori' => 'guru', 'urutan' => 11],
            ['nama' => 'Putri Handayani, S.Pd.', 'jabatan' => 'Guru Umum', 'mapel' => 'IPS', 'warna' => 'from-lime-500 to-lime-700', 'kategori' => 'guru', 'urutan' => 12],
        ];

        foreach ($gurus as $guru) {
            Guru::updateOrCreate(
                ['nama' => $guru['nama']],
                array_merge($guru, ['is_active' => true])
            );
        }

        $tendiks = [
            ['nama' => 'Eko Prasetyo', 'jabatan' => 'Kepala Tata Usaha', 'mapel' => 'Tata Usaha', 'warna' => 'from-slate-500 to-slate-700', 'kategori' => 'tendik', 'urutan' => 1],
            ['nama' => 'Mariatul Kiftiah', 'jabatan' => 'Bendahara', 'mapel' => 'Keuangan', 'warna' => 'from-rose-500 to-rose-700', 'kategori' => 'tendik', 'urutan' => 2],
            ['nama' => 'Sugeng Riyadi', 'jabatan' => 'Operator Sekolah', 'mapel' => 'TIK', 'warna' => 'from-violet-500 to-violet-700', 'kategori' => 'tendik', 'urutan' => 3],
            ['nama' => 'Tri Wahyuni', 'jabatan' => 'Staff Kurikulum', 'mapel' => 'Kurikulum', 'warna' => 'from-emerald-500 to-emerald-700', 'kategori' => 'tendik', 'urutan' => 4],
            ['nama' => 'Ari Supriyono', 'jabatan' => 'Kepala Perpustakaan', 'mapel' => 'Perpustakaan', 'warna' => 'from-amber-500 to-amber-700', 'kategori' => 'tendik', 'urutan' => 5],
            ['nama' => 'Dwi Fatimah', 'jabatan' => 'Staff Kesiswaan', 'mapel' => 'Kesiswaan', 'warna' => 'from-cyan-500 to-cyan-700', 'kategori' => 'tendik', 'urutan' => 6],
            ['nama' => 'Bambang Setiawan', 'jabatan' => 'Teknisi', 'mapel' => 'Sarpras', 'warna' => 'from-indigo-500 to-indigo-700', 'kategori' => 'tendik', 'urutan' => 7],
            ['nama' => 'Lestari', 'jabatan' => 'Pustakawan', 'mapel' => 'Perpustakaan', 'warna' => 'from-pink-500 to-pink-700', 'kategori' => 'tendik', 'urutan' => 8],
        ];

        foreach ($tendiks as $tendik) {
            Guru::updateOrCreate(
                ['nama' => $tendik['nama']],
                array_merge($tendik, ['is_active' => true])
            );
        }
    }
}
