<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $alumnis = [
            [
                'nisn' => '0067182910',
                'nama' => 'John Doe',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'tahun_lulus' => 2025,
                'angkatan' => 25,
            ],
            [
                'nisn' => '0058291823',
                'nama' => 'Budi Santoso',
                'jurusan' => 'Sistem Informasi Jaringan & Aplikasi',
                'tahun_lulus' => 2024,
                'angkatan' => 24,
            ],
            [
                'nisn' => '0049382716',
                'nama' => 'Siti Aminah',
                'jurusan' => 'Akuntansi & Keuangan Lembaga',
                'tahun_lulus' => 2023,
                'angkatan' => 23,
            ],
            [
                'nisn' => '0061234567',
                'nama' => 'Andi Wijaya',
                'jurusan' => 'Desain Komunikasi Visual',
                'tahun_lulus' => 2025,
                'angkatan' => 25,
            ],
            [
                'nisn' => '0039876543',
                'nama' => 'Rina Marlina',
                'jurusan' => 'Bisnis Daring & Pemasaran',
                'tahun_lulus' => 2022,
                'angkatan' => 22,
            ],
            [
                'nisn' => '0055443322',
                'nama' => 'Dedi Kurniawan',
                'jurusan' => 'Teknik Kendaraan Ringan',
                'tahun_lulus' => 2024,
                'angkatan' => 24,
            ],
            [
                'nisn' => '0047766554',
                'nama' => 'Maya Putri',
                'jurusan' => 'Animasi & 3D',
                'tahun_lulus' => 2023,
                'angkatan' => 23,
            ],
            [
                'nisn' => '0023344556',
                'nama' => 'Rizky Pratama',
                'jurusan' => 'Teknik Jaringan Kabel & Telekomunikasi',
                'tahun_lulus' => 2021,
                'angkatan' => 21,
            ],
        ];

        foreach ($alumnis as $alumni) {
            Alumni::updateOrCreate(['nisn' => $alumni['nisn']], $alumni);
        }
    }
}
