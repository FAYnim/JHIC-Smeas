<?php

namespace Database\Seeders;

use App\Models\CalonSiswa;
use Illuminate\Database\Seeder;

class CalonSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyData = [
            [
                'nisn' => '0051234567',
                'nama_lengkap' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'Pria',
                'asal_sekolah' => 'SMPN 1 Surabaya',
                'nomor_telepon' => '081234567890',
                'email' => 'ahmad.fauzi@example.com',
                'alamat' => 'Jl. Pemuda No. 12, Surabaya',
                'nama_ayah' => 'Bambang Fauzi',
                'pekerjaan_ayah' => 'Wiraswasta',
                'wa_ayah' => '081299887766',
                'nama_ibu' => 'Siti Aminah',
                'pekerjaan_ibu' => 'Ibu Rumah Tangga',
                'wa_ibu' => '081344556677',
                'jalur_pendaftaran' => 'Prestasi',
                'jurusan_pilihan' => 'Teknik Komputer dan Jaringan',
            ],
            [
                'nisn' => '0069876543',
                'nama_lengkap' => 'Siti Nurhaliza',
                'jenis_kelamin' => 'Wanita',
                'asal_sekolah' => 'SMPN 3 Surabaya',
                'nomor_telepon' => '085712345678',
                'email' => 'siti.nurhaliza@example.com',
                'alamat' => 'Jl. Raya Darmo No. 45, Surabaya',
                'nama_ayah' => 'Hendro Utomo',
                'pekerjaan_ayah' => 'PNS',
                'wa_ayah' => '085799881122',
                'nama_ibu' => 'Dewi Rahmawati',
                'pekerjaan_ibu' => 'Guru',
                'wa_ibu' => '085799881133',
                'jalur_pendaftaran' => 'Zonasi',
                'jurusan_pilihan' => 'Akuntansi dan Keuangan Lembaga',
            ],
            [
                'nisn' => '0071122334',
                'nama_lengkap' => 'Budi Santoso',
                'jenis_kelamin' => 'Pria',
                'asal_sekolah' => 'MTsN 1 Surabaya',
                'nomor_telepon' => '089611223344',
                'email' => 'budi.santoso@example.com',
                'alamat' => 'Jl. Diponegoro No. 88, Surabaya',
                'nama_ayah' => 'Sujatmiko',
                'pekerjaan_ayah' => 'Karyawan Swasta',
                'wa_ayah' => '089677889900',
                'nama_ibu' => 'Rina Astuti',
                'pekerjaan_ibu' => 'Wiraswasta',
                'wa_ibu' => '089677889911',
                'jalur_pendaftaran' => 'Afirmasi',
                'jurusan_pilihan' => 'Desain Komunikasi Visual',
            ],
        ];

        foreach ($dummyData as $data) {
            CalonSiswa::updateOrCreate(['nisn' => $data['nisn']], $data);
        }
    }
}
