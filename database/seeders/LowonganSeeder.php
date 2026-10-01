<?php

namespace Database\Seeders;

use App\Models\Lowongan;
use App\Models\MitraPerusahaan;
use Illuminate\Database\Seeder;

class LowonganSeeder extends Seeder
{
    public function run(): void
    {
        $mitra = fn (string $slug) => MitraPerusahaan::where('slug', $slug)->first();

        Lowongan::updateOrCreate(
            ['slug' => 'telkom-software-engineer-intern'],
            [
                'company_name' => 'PT Telkom Indonesia (Regional Jawa Timur)',
                'company_short' => 'TELKOM',
                'is_mitra_dudi' => true,
                'title' => 'Software Engineer Intern (PKL)',
                'location' => 'Ketintang, Surabaya',
                'duration' => '6 Bulan (Jan - Jun)',
                'jurusan' => 'Khusus RPL & SIJA',
                'kuota' => 2,
                'metode_kerja' => 'On-site (Surabaya)',
                'jenis' => 'magang',
                'deskripsi' => 'Program Praktek Kerja Lapangan (PKL) di PT Telkom Indonesia Regional Jawa Timur dirancang khusus untuk membekali siswa dengan pengalaman kerja nyata pada industri digital nasional. Magang ini bertempat di divisi IT Solution, berfokus pada pengembangan produk web internal, pengujian kualitas fungsional aplikasi enterprise, serta kolaborasi aktif menggunakan standar clean code dan metodologi Agile yang berlaku di industri modern.',
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
                'batas_pendaftaran' => '2026-08-15',
                'durasi_pelaksanaan' => '6 Bulan (1 Semester)',
                'status_kuota' => 'Tersedia (2 Kursi)',
                'pokja_nama' => 'Pokja PKL SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'fresh_graduate_ok' => true,
                'bidang_industri' => 'Software & IT Solusi',
                'logo_color' => '#dc2626',
                'mitra_id' => $mitra('pt-telkom-indonesia')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'astra-frontend-developer-intern'],
            [
                'company_name' => 'PT Astra Graphia Information Tech',
                'company_short' => 'ASTRA',
                'is_mitra_dudi' => true,
                'title' => 'Frontend Developer Intern',
                'location' => 'Jl. Pemuda, Surabaya',
                'duration' => '6 Bulan (Jan - Jun)',
                'jurusan' => 'Khusus RPL',
                'kuota' => 1,
                'metode_kerja' => 'Hybrid (3 Hari WFO)',
                'jenis' => 'magang',
                'deskripsi' => 'Magang frontend developer di PT Astra Graphia memungkinkan siswa terlibat langsung dalam pengembangan antarmuka aplikasi enterprise klien grup Astra, dari persiapan desain hingga integrasi API.',
                'tanggung_jawab' => [
                    'Mengimplementasikan antarmuka web mengikuti design system yang tersedia',
                    'Membuat halaman responsif menggunakan HTML, CSS, dan JavaScript modern',
                    'Melakukan integrasi REST API sederhana untuk kebutuhan fitur internal',
                    'Membantu dokumentasi komponen UI dan menjalankan pengujian browser',
                ],
                'kualifikasi' => [
                    'Siswa kelas XII kompetensi keahlian RPL SMKN 1 Surabaya',
                    'Memahami HTML, CSS, dasar JavaScript, dan React atau Vue',
                    'Mampu bekerja dalam ritme hybrid dan bersedia di WFO minimal 3 hari per minggu',
                ],
                'dokumen' => [
                    ['name' => 'CV_Astra_Graphia.pdf', 'desc' => 'Format PDF, maksimal 3MB', 'type' => 'pdf'],
                    ['name' => 'Link_Portofolio_Design_Code', 'desc' => 'Figma / GitHub / Dribbble', 'type' => 'link'],
                    ['name' => 'Surat_Pengantar_Pokja.pdf', 'desc' => 'Surat pengantar resmi sekolah', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'Uang Saku Bulanan',
                    'Sertifikat Resmi Industri',
                    'Mentoring 1-on-1',
                ],
                'batas_pendaftaran' => '2026-08-20',
                'durasi_pelaksanaan' => '6 Bulan (1 Semester)',
                'status_kuota' => 'Tersedia (1 Kursi)',
                'pokja_nama' => 'Pokja PKL SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'bidang_industri' => 'Software & IT Solusi',
                'logo_color' => '#f97316',
                'mitra_id' => $mitra('pt-astra-graphia-it')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'bjb-network-sysadmin-intern'],
            [
                'company_name' => 'PT Bank Pembangunan Daerah Jatim',
                'company_short' => 'B.JATIM',
                'is_mitra_dudi' => true,
                'title' => 'Network & Sysadmin Intern',
                'location' => 'Basuki Rahmat, Surabaya',
                'duration' => '6 Bulan',
                'jurusan' => 'Khusus SIJA',
                'kuota' => 3,
                'metode_kerja' => 'On-site (Surabaya)',
                'jenis' => 'magang',
                'deskripsi' => 'Program PKL di divisi Teknologi Informasi PT Bank Jatim memberikan pengalaman praktis pengelolaan jaringan kantor cabang, monitoring server, serta dukungan infrastruktur perbankan.',
                'tanggung_jawab' => [
                    'Memantau kesehatan jaringan dan server divisi TI secara berkala',
                    'Mendokumentasikan inventaris perangkat jaringan dan insiden harian',
                    'Membantu konfigurasi switch, router, dan firewall di lingkungan simulasi',
                    'Mendukung tim helpdesk dalam penanganan tiket jaringan internal',
                ],
                'kualifikasi' => [
                    'Siswa aktif kompetensi keahlian SIJA / TKJ SMKN 1 Surabaya',
                    'Memahami konsep jaringan dasar (TCP/IP, routing, switching)',
                    'Bersedia bekerja on-site penuh di kantor pusat Bank Jatim',
                ],
                'dokumen' => [
                    ['name' => 'CV_Terbaru.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                    ['name' => 'Transkrip_Nilai.pdf', 'desc' => 'Format PDF, terakhir semester', 'type' => 'pdf'],
                    ['name' => 'Surat_Izin_Ortu_Pengantar_Pokja.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'Uang Saku Bulanan',
                    'Sertifikat Resmi Industri',
                    'Pembimbing Khusus (1-on-1)',
                ],
                'batas_pendaftaran' => '2026-08-25',
                'durasi_pelaksanaan' => '6 Bulan (1 Semester)',
                'status_kuota' => 'Tersedia (3 Kursi)',
                'pokja_nama' => 'Pokja PKL SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'bidang_industri' => 'Perbankan & Jasa',
                'logo_color' => '#dc2626',
                'mitra_id' => $mitra('pt-bank-jatim-tbk')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'beon-cloud-devops-intern'],
            [
                'company_name' => 'PT Beon Intermedia (Jagoan Hosting)',
                'company_short' => 'JAGOAN',
                'is_mitra_dudi' => true,
                'title' => 'Cloud DevOps Support Intern',
                'location' => 'Malang / Remote',
                'duration' => '6 Bulan',
                'jurusan' => 'Khusus RPL & SIJA',
                'kuota' => 2,
                'metode_kerja' => 'Remote / WFH',
                'jenis' => 'magang',
                'deskripsi' => 'Magang DevOps support di PT Beon Intermedia mengajak siswa memahami operasional cloud hosting, deployment berbasis container, serta monitoring layanan server multi-tenant.',
                'tanggung_jawab' => [
                    'Mendukung tim DevOps dalam tugas operasional harian lingkungan cloud',
                    'Menyusun dokumentasi runbook dan checklist deploy internal',
                    'Membantu monitoring uptime layanan serta pelaporan insiden minor',
                    'Mengerjakan proyek mini deployment container dengan pengawasan mentor',
                ],
                'kualifikasi' => [
                    'Siswa aktif RPL atau SIJA SMKN 1 Surabaya yang siap bekerja remote',
                    'Memahami Linux dasar, networking dasar, atau instalasi aplikasi web',
                    'Mampu bekerja mandiri dan disiplin dalam komunikasi daring',
                ],
                'dokumen' => [
                    ['name' => 'CV_Beon_Hosting.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                    ['name' => 'Bukti_Portofolio_Akun_GitHub', 'desc' => 'Tautan URL', 'type' => 'link'],
                    ['name' => 'Surat_Pengantar_Pokja.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'Uang Saku Bulanan',
                    'Sertifikat & Voucher',
                    'Mentoring 1-on-1',
                ],
                'batas_pendaftaran' => '2026-08-28',
                'durasi_pelaksanaan' => '6 Bulan (1 Semester)',
                'status_kuota' => 'Tersedia (2 Kursi)',
                'pokja_nama' => 'Pokja PKL SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'bidang_industri' => 'Software & IT Solusi',
                'logo_color' => '#f97316',
                'mitra_id' => $mitra('pt-beon-intermedia')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'astra-junior-frontend-developer'],
            [
                'company_name' => 'PT Astra Graphia Information Tech',
                'company_short' => 'ASTRA',
                'is_mitra_dudi' => true,
                'title' => 'Junior Frontend Developer',
                'location' => 'Jl. Pemuda Surabaya',
                'duration' => 'Full-time',
                'jurusan' => 'Khusus RPL',
                'kuota' => 0,
                'metode_kerja' => 'On-site (Surabaya)',
                'jenis' => 'lowongan',
                'tipe_pekerjaan' => 'Full-time (Purnawaktu)',
                'gaji_min' => 4800000,
                'gaji_max' => 6200000,
                'pengalaman' => 'Fresh Graduate Welcome',
                'bidang_industri' => 'Software & IT Solusi',
                'jenjang_pendidikan' => 'SMK / MAK Sederajat',
                'fresh_graduate_ok' => true,
                'deskripsi' => 'PT Astra Graphia membuka posisi Junior Frontend Developer untuk lulusan SMK kompetensi RPL. Anda akan bergabung dengan tim pengembangan produk digital perusahaan dan bertanggung jawab membangun antarmuka aplikasi yang digunakan pelanggan grup Astra.',
                'tanggung_jawab' => [
                    'Mengembangkan dan memelihara komponen frontend aplikasi internal dan eksternal',
                    'Berkolaborasi dengan UI/UX Designer dan Backend Developer dalam sprint Agile',
                    'Melakukan optimasi performa halaman serta perbaikan bug antarmuka',
                    'Menulis kode yang terdokumentasi dan siap diuji secara reguler',
                ],
                'kualifikasi' => [
                    'Lulusan SMK kompetensi RPL / DKV dengan pemahaman JavaScript modern',
                    'Memiliki portofolio proyek frontend (React, Vue, atau HTML/CSS/JS)',
                    'Mampu bekerja full-time di Surabaya dan siap probation 3 bulan',
                ],
                'dokumen' => [
                    ['name' => 'CV_Terbaru.pdf', 'desc' => 'Format PDF, maksimal 3MB', 'type' => 'pdf'],
                    ['name' => 'Portofolio_Link', 'desc' => 'GitHub / website portofolio', 'type' => 'link'],
                    ['name' => 'Ijazah_Dan_Transkrip.pdf', 'desc' => 'Salinan legalisir', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'BPJS Kesehatan & TK',
                    'Tunjangan Hari Raya',
                    'Pengembangan skill & sertifikasi',
                ],
                'batas_pendaftaran' => '2026-08-30',
                'durasi_pelaksanaan' => 'Full-time',
                'status_kuota' => 'Tersedia',
                'pokja_nama' => 'Bursa Kerja Khusus (BKK) SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'logo_color' => '#f97316',
                'mitra_id' => $mitra('pt-astra-graphia-it')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'bjb-it-support-helpdesk'],
            [
                'company_name' => 'PT Bank Pembangunan Daerah Jatim',
                'company_short' => 'B.JATIM',
                'is_mitra_dudi' => true,
                'title' => 'IT Support & Helpdesk',
                'location' => 'Jl. Basuki Rahmat Sby',
                'duration' => 'Kontrak 1 Tahun',
                'jurusan' => 'Khusus SIJA & TKJ',
                'kuota' => 0,
                'metode_kerja' => 'On-site (Surabaya)',
                'jenis' => 'lowongan',
                'tipe_pekerjaan' => 'Kontrak (PKWT)',
                'gaji_min' => 5000000,
                'gaji_max' => 6500000,
                'pengalaman' => 'Fresh Graduate Welcome',
                'bidang_industri' => 'Perbankan & Jasa',
                'jenjang_pendidikan' => 'SMK / MAK Sederajat',
                'fresh_graduate_ok' => true,
                'deskripsi' => 'Posisi IT Support & Helpdesk di PT Bank Jatim bertanggung jawab mendukung operasional teknologi informasi kantor pusat, termasuk penanganan tiket pengguna, pemeliharaan perangkat, dan dokumentasi insiden.',
                'tanggung_jawab' => [
                    'Menangani tiket helpdesk pengguna internal dan penanganan awal insiden',
                    'Melakukan instalasi, konfigurasi, dan pemeliharaan perangkat komputer',
                    'Mendukung proses backup data dan kepatuhan keamanan informasi',
                    'Mendokumentasikan solusi dan menjaga knowledge base tetap mutakhir',
                ],
                'kualifikasi' => [
                    'Lulusan SMK kompetensi SIJA / TKJ / RPL',
                    'Memahami operating system, jaringan dasar, dan troubleshooting perangkat',
                    'Siap bekerja kontrak 1 tahun dengan kemungkinan perpanjangan',
                ],
                'dokumen' => [
                    ['name' => 'CV_Terbaru.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                    ['name' => 'Ijazah_Dan_Transkrip.pdf', 'desc' => 'Salinan legalisir', 'type' => 'pdf'],
                    ['name' => 'Surat_Keterangan_Selesai_PKL.pdf', 'desc' => 'Jika sudah menyelesaikan PKL', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'BPJS Kesehatan & TK',
                    'Gaji ke-13 (sesuai kontrak)',
                    'Pelatihan internal bank',
                ],
                'batas_pendaftaran' => '2026-09-10',
                'durasi_pelaksanaan' => 'Kontrak 1 Tahun',
                'status_kuota' => 'Tersedia',
                'pokja_nama' => 'Bursa Kerja Khusus (BKK) SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'logo_color' => '#dc2626',
                'mitra_id' => $mitra('pt-bank-jatim-tbk')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'beon-technical-support-specialist'],
            [
                'company_name' => 'PT Beon Intermedia',
                'company_short' => 'JAGOAN',
                'is_mitra_dudi' => true,
                'title' => 'Technical Support Specialist',
                'location' => 'Surabaya / Hybrid',
                'duration' => 'Full-time',
                'jurusan' => 'Khusus SIJA & TKJ',
                'kuota' => 0,
                'metode_kerja' => 'Hybrid',
                'jenis' => 'lowongan',
                'tipe_pekerjaan' => 'Full-time (Purnawaktu)',
                'gaji_min' => 4800000,
                'gaji_max' => 5800000,
                'pengalaman' => 'Minimal 1-2 Tahun',
                'bidang_industri' => 'Jaringan & Infrastruktur',
                'jenjang_pendidikan' => 'SMK / MAK Sederajat',
                'deskripsi' => 'Technical Support Specialist di PT Beon Intermedia membantu pelanggan hosting memecahkan kendala teknis layanan cloud, termasuk troubleshooting server, domain, dan konfigurasi website.',
                'tanggung_jawab' => [
                    'Menangani tiket pelanggan hosting terkait server, domain, dan email',
                    'Melakukan analisis awal insiden dan eskalasi ke tim infrastruktur',
                    'Membantu konfigurasi layanan pelanggan sesuai standar operasional',
                    'Menyusun artikel basis pengetahuan untuk tim support',
                ],
                'kualifikasi' => [
                    'Pengalaman minimal 1 tahun di technical support / helpdesk hosting',
                    'Memahami Linux dasar, DNS, cPanel, atau panel cloud',
                    'Mampu bekerja hybrid dan memiliki komunikasi pelanggan yang baik',
                ],
                'dokumen' => [
                    ['name' => 'CV_Terbaru.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                    ['name' => 'Ijazah_Dan_Transkrip.pdf', 'desc' => 'Salinan legalisir', 'type' => 'pdf'],
                    ['name' => 'Sertifikat_Pendukung.pdf', 'desc' => 'Jika ada sertifikasi relevan', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'BPJS Kesehatan & TK',
                    'Bonus kinerja semesteran',
                    'Pengembangan sertifikasi cloud',
                ],
                'batas_pendaftaran' => '2026-09-15',
                'durasi_pelaksanaan' => 'Full-time',
                'status_kuota' => 'Tersedia',
                'pokja_nama' => 'Bursa Kerja Khusus (BKK) SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'logo_color' => '#f97316',
                'mitra_id' => $mitra('pt-beon-intermedia')?->id,
            ]
        );

        Lowongan::updateOrCreate(
            ['slug' => 'maspion-staff-administrasi-operasional'],
            [
                'company_name' => 'PT Maspion Group Surabaya',
                'company_short' => 'MASPION',
                'is_mitra_dudi' => true,
                'title' => 'Staff Administrasi Operasional',
                'location' => 'Runggut Industri Sby',
                'duration' => 'Full-time',
                'jurusan' => 'Khusus AKL & BDP',
                'kuota' => 0,
                'metode_kerja' => 'On-site (Surabaya)',
                'jenis' => 'lowongan',
                'tipe_pekerjaan' => 'Full-time (Purnawaktu)',
                'gaji_min' => 4750000,
                'gaji_max' => 4750000,
                'pengalaman' => 'Fresh Graduate Welcome',
                'bidang_industri' => 'Administrasi & Keuangan',
                'jenjang_pendidikan' => 'SMK / MAK Sederajat',
                'fresh_graduate_ok' => true,
                'deskripsi' => 'PT Maspion Group mencari staff administrasi operasional untuk mendukung proses dokumentasi, inventaris, dan koordinasi harian departemen operasional pabrik di kawasan Rungkut Industri.',
                'tanggung_jawab' => [
                    'Menginput dan memelihara data operasional harian perusahaan',
                    'Menyiapkan laporan inventaris dan dokumen persuratan internal',
                    'Mendukung koordinasi jadwal dan kebutuhan operasional departemen',
                    'Memastikan arsip dokumen rapi dan mudah ditelusuri',
                ],
                'kualifikasi' => [
                    'Lulusan SMK kompetensi AKL / BDP / Administrasi Perkantoran',
                    'Menguasai Microsoft Excel dan aplikasi perkantoran dasar',
                    'Teliti, disiplin, dan mampu bekerja dalam tim produksi',
                ],
                'dokumen' => [
                    ['name' => 'CV_Terbaru.pdf', 'desc' => 'Format PDF', 'type' => 'pdf'],
                    ['name' => 'Ijazah_Dan_Transkrip.pdf', 'desc' => 'Salinan legalisir', 'type' => 'pdf'],
                    ['name' => 'Surat_Keterangan_Selesai_PKL.pdf', 'desc' => 'Jika sudah PKL di Maspion', 'type' => 'pdf'],
                ],
                'benefits' => [
                    'BPJS Kesehatan & TK',
                    'Transport & makan siang',
                    'Jenjang karir jelas',
                ],
                'batas_pendaftaran' => '2026-09-05',
                'durasi_pelaksanaan' => 'Full-time',
                'status_kuota' => 'Tersedia',
                'pokja_nama' => 'Bursa Kerja Khusus (BKK) SMKN 1 Surabaya',
                'pokja_koordinator' => 'Bpk. Aris Santoso, S.Kom',
                'pokja_wa' => '6281234567890',
                'logo_color' => '#2563eb',
                'mitra_id' => $mitra('pt-maspion-group')?->id,
            ]
        );
    }
}
