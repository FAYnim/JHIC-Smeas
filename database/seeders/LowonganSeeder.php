<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use Illuminate\Database\Seeder;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        Lowongan::create([
            'company_name'  => 'PT Telkom Indonesia (Regional Jawa Timur)',
            'company_short' => 'Telkom Indonesia',
            'is_mitra_dudi' => true,
            'title'         => 'Software Engineer Intern (PKL)',
            'slug'          => 'telkom-software-engineer-intern',
            'location'      => 'Surabaya, Jatim',
            'duration'      => '6 Bulan (Jan - Jun)',
            'jurusan'       => 'Khusus RPL & SIJA',
            'kuota'         => 2,
            'metode_kerja'  => 'On-site (Surabaya)',
            'deskripsi'     => 'Program Praktek Kerja Lapangan (PKL) di PT Telkom Indonesia Regional Jawa Timur dirancang khusus untuk membekali siswa dengan pengalaman kerja nyata pada industri digital nasional. Magang ini bertempat di divisi IT Solution, berfokus pada pengembangan produk web internal, pengujian kualitas fungsional aplikasi enterprise, serta kolaborasi aktif menggunakan standar clean code dan metodologi Agile yang berlaku di industri modern.',
            'tanggung_jawab' => [
                'Slicing desain UI/UX menjadi komponen frontend berbasis React & Tailwind CSS',
                'Melakukan pengujian Manual QA serta menyusun dokumentasi laporan bug',
                'Mengikuti daily stand-up dan koordinasi mingguan bersama tim developer Telkom',
                'Mengisi jurnal harian PKL dan menyusun laporan akhir magang secara berkala',
            ],
            'kualifikasi' => [
                'Siswa aktif kelas XI / XII kompetensi keahlian RPL atau SIJA SMKN 1 Surabaya',
                'Memiliki pemahaman dasar HTML, CSS, JavaScript, serta konsep dasar PHP',
                'Mampu bekerja sama dalam tim dan bersedia mematuhi aturan SOP perusahaan',
            ],
            'dokumen' => [
                ['name' => 'CV_Terbaru_Siswa.pdf', 'desc' => 'Format PDF, Maksimal 5MB', 'type' => 'pdf'],
                ['name' => 'Portfolio_GitHub_Link', 'desc' => 'Tautan URL Repositori / Karya', 'type' => 'link'],
                ['name' => 'Surat_Izin_Ortu_Pengantar_Pokja.pdf', 'desc' => 'Format PDF, Tanda Tangan Basah', 'type' => 'pdf'],
            ],
            'benefits' => [
                'Uang Saku Bulanan',
                'Sertifikat Resmi Industri',
                'Pembimbing Khusus (1-on-1)',
            ],
            'batas_pendaftaran'  => '2026-08-15',
            'durasi_pelaksanaan' => '6 Bulan (1 Semester)',
            'status_kuota'       => 'Tersedia (2 Kursi)',
            'pokja_nama'         => 'Pokja PKL SMKN 1 Surabaya',
            'pokja_koordinator'  => 'Bpk. Aris Santoso, S.Kom',
            'pokja_wa'           => '6281234567890',
        ]);
    }
}
