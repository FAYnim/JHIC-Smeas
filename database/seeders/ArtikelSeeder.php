<?php

namespace Database\Seeders;

use App\Models\Artikel;
use Illuminate\Database\Seeder;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Tips Membuat CV yang Menarik untuk PKL',
                'slug' => 'tips-menarik-cv-pkl',
                'excerpt' => 'Pelajari cara membuat CV yang profesional dan menarik perhatian perusahaan untuk program PKL.',
                'content' => 'Membuat CV yang menarik adalah langkah pertama untuk mendapatkan tempat PKL yang diinginkan. Pastikan struktur rapi, informasi kontak lengkap, dan pengalaman relevan yang disorot.',
                'kategori' => 'Tips CV',
                'published_at' => now()->subDays(1),
                'reading_time' => '3 menit baca',
            ],
            [
                'title' => 'Persiapan Interview Magang di Perusahaan Teknologi',
                'slug' => 'persiapan-interview-magang-tech',
                'excerpt' => 'Tips dan trik menghadapi interview magang di perusahaan teknologi ternama.',
                'content' => 'Interview magang adalah tahap penting dalam seleksi program PKL. Kuasai profil perusahaan, siapkan contoh proyek, dan latih penampilan profesional.',
                'kategori' => 'Tips Interview',
                'published_at' => now()->subDays(3),
                'reading_time' => '4 menit baca',
            ],
            [
                'title' => 'Roadmap Karir untuk Lulusan SMK Jurusan RPL',
                'slug' => 'roadmap-karir-lulusan-rpl',
                'excerpt' => 'Panduan lengkap roadmap karir untuk lulusan SMK jurusan RPL dari fresh graduate hingga senior.',
                'content' => 'Lulusan SMK jurusan RPL memiliki banyak peluang karir di industri teknologi. Mulai dari junior developer, QA, hingga DevOps dengan jalur sertifikasi yang tepat.',
                'kategori' => 'Roadmap Karir',
                'published_at' => now()->subDays(5),
                'reading_time' => '5 menit baca',
            ],
            [
                'title' => 'Sertifikasi Kompetensi yang Wajib Dimiliki Siswa SMK',
                'slug' => 'sertifikasi-kompetensi-siswa-smk',
                'excerpt' => 'Daftar sertifikasi kompetensi yang dapat meningkatkan daya saing siswa SMK di dunia kerja.',
                'content' => 'Sertifikasi kompetensi menjadi nilai tambah yang signifikan di mata perusahaan. Kenali skema sertifikasi sesuai keahlianmu dan rencanakan jadwal uji sejak kelas XII.',
                'kategori' => 'Sertifikasi',
                'published_at' => now()->subDays(7),
                'reading_time' => '4 menit baca',
            ],
            [
                'title' => 'Cara Membangun Portofolio yang Menarik untuk PKL',
                'slug' => 'membangun-portofolio-menarik-pkl',
                'excerpt' => 'Panduan praktis membangun portofolio proyek yang bisa jadi nilai tambah saat mendaftar PKL.',
                'content' => 'Portofolio adalah bukti konkret kemampuan yang bisa Anda tunjukkan ke perusahaan. Kumpulkan proyek sekolah, dokumentasikan proses, dan unggah ke GitHub atau Figma.',
                'kategori' => 'Tips CV',
                'published_at' => now()->subDays(10),
                'reading_time' => '3 menit baca',
            ],
            [
                'title' => '5 Tips Membuat CV yang Menarik Perhatian HRD di Tahun 2026',
                'slug' => '5-tips-cv-menarik-hrd-2026',
                'excerpt' => 'Pahami format struktur ATS-friendly, pemilihan kata kerja aksi, serta penyesuaian CV terhadap setiap iklan lowongan.',
                'content' => 'Tahun 2026, proses seleksi HRD makin bergantung pada sistem ATS. Pastikan CV menggunakan format yang mudah dipindai, bahasa yang ringkas, dan poin pengalaman yang terukur. Cantumkan sertifikat relevan, proyek nyata, serta tautan portofolio yang masih aktif. Setiap lamaran sebaiknya disesuaikan dengan kualifikasi di iklan lowongan agar tidak hilang di filter awal.',
                'kategori' => 'Tips CV',
                'published_at' => now()->subDays(2),
                'reading_time' => '4 menit baca',
            ],
            [
                'title' => 'Persiapan Interview Kerja untuk Fresh Graduate',
                'slug' => 'persiapan-interview-kerja-fresh-graduate',
                'excerpt' => 'Langkah praktis menghadapi wawancara kerja pertama: riset perusahaan, latihan jawaban, dan penampilan profesional.',
                'content' => 'Interview kerja pertama bisa menegangkan, namun dengan persiapan yang tepat Anda bisa tampil percaya diri. Pelajari latar belakang perusahaan, siapkan jawaban STAR untuk pertanyaan perilaku, dan kenali keunggulan diri Anda. Datang lebih awal, gunakan bahasa tubuh yang sopan, dan siapkan pertanyaan cerdas mengenai posisi serta budaya kerja perusahaan.',
                'kategori' => 'Tips Interview',
                'published_at' => now()->subDays(4),
                'reading_time' => '6 menit baca',
            ],
            [
                'title' => 'Meniti Karir di Perusahaan Teknologi: Panduan untuk Lulusan SMK',
                'slug' => 'meniti-karir-perusahaan-teknologi-smk',
                'excerpt' => 'Jalur karir di industri IT untuk lulusan SMK: dari magang, sertifikasi, hingga posisi full-time.',
                'content' => 'Industri teknologi membuka banyak jalur karir untuk lulusan SMK. Anda bisa memulai dari magang atau PKL di mitra industri, memperkuat portofolio, lalu melamar posisi junior. Sertifikasi seperti BNSP atau vendor-specific akan mempercepat proses rekrutmen. Jaga konsistensi belajar, bangun jaringan dengan alumni, dan pantau lowongan kerja melalui Bursa Kerja Khusus sekolah.',
                'kategori' => 'Roadmap Karir',
                'published_at' => now()->subDays(6),
                'reading_time' => '7 menit baca',
            ],
            [
                'title' => 'Panduan Lengkap Tembus Magang PKL di BUMN & Mitra Industri 2026',
                'slug' => 'panduan-lengkap-tembus-magang-pkl-bumn-mitra-industri-2026',
                'excerpt' => 'Pelajari alur seleksi berkas, verifikasi rombel NISN sekolah, etika wawancara user DUDI, serta standar penyusunan portofolio proyek rili untuk siswa tingkat akhir SMKN 1 Surabaya.',
                'content' => 'Panduan Lengkap Tembus Magang PKL di BUMN & Mitra Industri 2026\n\nMagang PKL di BUMN dan mitra industri adalah salah satu jalan tercepat membangun pengalaman kerja nyata bagi siswa SMK. Seleksi BUMN umumnya lebih ketat dibanding perusahaan swasta, sehingga persiapan berkas dan wawancara harus matang.\n\nLangkah pertama adalah memahami alur seleksi. Biasanya ada pengumuman lowongan, pendaftaran daring, seleksi administrasi, tes tertulis atau online, wawancara user DUDI, hingga pengumuman hasil akhir. Catat setiap tenggat dan jangan menunggu menit terakhir.\n\nBerkas yang sering disiapkan antara lain CV terbaru, surat pengantar dari sekolah, transkrip nilai, sertifikat sertifikasi kompetensi bila ada, portofolio proyek, serta surat izin orang tua. Pastikan nama, NISN, dan data rombel konsisten di semua dokumen karena verifikasi sekolah akan mencocokkan data tersebut.\n\nUntuk portofolio, pilih 2-3 proyek terbaik yang paling relevan dengan posisi yang dilamar. Dokumentasikan peran Anda, teknologi yang digunakan, dan hasil yang dicapai. Untuk siswa RPL, proyek web, mobile, atau jaringan akan sangat relevan; untuk DKV, lampirkan karya visual beserta proses desainnya.\n\nEtika wawancara sama pentingnya dengan kompetensi. Jawab dengan struktur STAR (Situation, Task, Action, Result), tunjukkan minat belajar, dan siapkan pertanyaan cerdas tentang program magang. Penampilan rapi, tepat waktu, serta komunikasi yang sopan akan meninggalkan kesan positif pada user DUDI.\n\nSetelah diterima, manfaatkan setiap hari magang untuk belajar, membangun jaringan, dan menyelesaikan proyek dengan baik. Pengalaman magang yang sukses sering berujung pada penawaran kerja setelah kelulusan. Pantau terus lowongan terbaru melalui Bursa Kerja Khusus (BKK) dan Pusat Karir SMKN 1 Surabaya untuk peluang berikutnya.',
                'kategori' => 'Tips CV',
                'published_at' => now()->subDay(),
                'reading_time' => '8 menit baca',
            ],
        ];

        foreach ($items as $item) {
            Artikel::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
