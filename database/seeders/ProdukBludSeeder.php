<?php

namespace Database\Seeders;

use App\Models\ProdukBlud;
use App\Models\ProdukBludGaleri;
use App\Models\ProdukBludKomentar;
use Illuminate\Database\Seeder;

class ProdukBludSeeder extends Seeder
{
    public function run(): void
    {
        $produks = [
            [
                'slug' => 'cheeseroll',
                'tipe' => 'showcase',
                'title' => 'Cheeseroll',
                'subtitle' => null,
                'jurusan_nama' => 'Bisnis Digital',
                'jurusan_slug' => 'bisnis-daring-dan-pemasaran',
                'deskripsi' => 'Jajanan enak dari Bisnis Digital dengan tekstur gurih dan lembut',
                'harga_min' => 1500000,
                'harga_max' => 3000000,
                'rating' => 5.00,
                'rating_count' => 1104,
                'terjual' => '2 rb+',
                'pengiriman' => 'Pre-Order (jadi dalam 7 hari)',
                'kategori' => 'Kuliner',
                'stok' => 'Tersedia (Pre-Order)',
                'opsi_custom' => 'Ya',
                'quantity_per_pack' => '10 pcs/pack',
                'jurusan_logo_color' => '#fbbf24',
                'penilaian_count' => '2RB',
                'produk_count' => '20',
                'presentase_chat' => '75%',
                'waktu_chat' => 'Hitungan Jam',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/fbbf24/1c1917?text=Cheeseroll', 'caption' => 'Cheeseroll original'],
                    ['image_url' => 'https://placehold.co/800x600/fcd34d/1c1917?text=Cheeseroll+Porsi', 'caption' => 'Porsi 10 pcs'],
                    ['image_url' => 'https://placehold.co/800x600/f59e0b/1c1917?text=Cheeseroll+Pack', 'caption' => 'Kemasan pack'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Rasanya juara, teksturnya lembut banget. Akan pesan lagi!', 'rating' => 5],
                    ['nama' => 'Dewi Lestari', 'komentar' => 'Pengiriman sesuai jadwal pre-order. Recommended untuk acara sekolah.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'website-sekolah',
                'tipe' => 'kustom',
                'title' => 'Website Sekolah',
                'subtitle' => 'Karya siswa',
                'jurusan_nama' => 'Rekayasa Perangkat Lunak',
                'jurusan_slug' => 'rekayasa-perangkat-lunak',
                'deskripsi' => 'Website profil sekolah responsif yang dikembangkan siswa RPL untuk mendukung digitalisasi SMKN 1 Surabaya.',
                'tanggal_pembuatan' => '2026-09-30',
                'angkatan' => 25,
                'didukung_oleh' => 'Syaiful',
                'ketua_tim' => 'Faris Adillah Y.',
                'anggota_tim' => ['Bima Satria', 'Eddria Ammaliya', 'Revaya', 'Jasmine Olivia P.'],
                'jurusan_logo_color' => '#60a5fa',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/1e3a8a/e2e8f0?text=Website+Sekolah', 'caption' => 'Halaman utama'],
                    ['image_url' => 'https://placehold.co/800x600/2563eb/e2e8f0?text=Profil+Sekolah', 'caption' => 'Halaman profil'],
                    ['image_url' => 'https://placehold.co/800x600/3b82f6/e2e8f0?text=Demo+Aplikasi', 'caption' => 'Demo aplikasi'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Tampilannya modern dan mudah dinavigasi. Kerja bagus tim RPL!', 'rating' => 5],
                    ['nama' => 'Bu Rina', 'komentar' => 'Website ini membantu sekolah tampil lebih profesional secara online.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'nugget-ayam-homemade',
                'tipe' => 'showcase',
                'title' => 'Nugget Ayam Homemade',
                'subtitle' => null,
                'jurusan_nama' => 'Perhotelan',
                'jurusan_slug' => 'perhotelan',
                'deskripsi' => 'Nugget ayam homemade produksi siswa Perhotelan dengan bahan pilihan dan tanpa pengawet.',
                'harga_min' => 45000,
                'harga_max' => 75000,
                'rating' => 4.80,
                'rating_count' => 320,
                'terjual' => '500+',
                'pengiriman' => 'Ready Stock',
                'kategori' => 'Kuliner',
                'stok' => 'Ready Stock',
                'opsi_custom' => 'Tidak',
                'quantity_per_pack' => '250 gram / 500 gram',
                'jurusan_logo_color' => '#34d399',
                'penilaian_count' => '320',
                'produk_count' => '12',
                'presentase_chat' => '80%',
                'waktu_chat' => 'Hitungan Jam',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/34d399/064e3b?text=Nugget+Ayam', 'caption' => 'Nugget ayam homemade'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Enak dan higienis. Anak-anak suka di rumah.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'jasa-desain-logo',
                'tipe' => 'showcase',
                'title' => 'Jasa Desain Logo',
                'subtitle' => null,
                'jurusan_nama' => 'Desain Komunikasi Visual',
                'jurusan_slug' => 'desain-komunikasi-visual',
                'deskripsi' => 'Jasa desain logo profesional oleh siswa DKV, cocok untuk UMKM dan komunitas.',
                'harga_min' => 150000,
                'harga_max' => 500000,
                'rating' => 4.90,
                'rating_count' => 89,
                'terjual' => '100+',
                'pengiriman' => 'Pre-Order (3-5 hari kerja)',
                'kategori' => 'Desain',
                'stok' => 'Open Order',
                'opsi_custom' => 'Ya',
                'quantity_per_pack' => null,
                'jurusan_logo_color' => '#a78bfa',
                'penilaian_count' => '89',
                'produk_count' => '15',
                'presentase_chat' => '90%',
                'waktu_chat' => 'Hitungan Jam',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/a78bfa/3b0764?text=Desain+Logo', 'caption' => 'Portofolio logo'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Desainnya sesuai brief, revisinya juga cepat.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'aplikasi-kasir-warung',
                'tipe' => 'kustom',
                'title' => 'Aplikasi Kasir Warung',
                'subtitle' => 'Karya siswa',
                'jurusan_nama' => 'Teknik Komputer dan Jaringan',
                'jurusan_slug' => 'teknik-komputer-dan-jaringan',
                'deskripsi' => 'Aplikasi kasir sederhana untuk warung kecil, dikembangkan siswa TKJ dengan antarmuka yang mudah digunakan.',
                'tanggal_pembuatan' => '2026-08-15',
                'angkatan' => 24,
                'didukung_oleh' => 'Pak Hendra',
                'ketua_tim' => 'Rizky Maulana',
                'anggota_tim' => ['Siti Aisyah', 'Doni Saputra', 'Nadia Putri'],
                'jurusan_logo_color' => '#f87171',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/991b1b/fecaca?text=Kasir+Warung', 'caption' => 'UI aplikasi kasir'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Sangat membantu warung saya untuk rekap harian.', 'rating' => 4],
                ],
            ],
            [
                'slug' => 'kemasan-umkm-custom',
                'tipe' => 'showcase',
                'title' => 'Kemasan UMKM Custom',
                'subtitle' => null,
                'jurusan_nama' => 'Desain Komunikasi Visual',
                'jurusan_slug' => 'desain-komunikasi-visual',
                'deskripsi' => 'Jasa pembuatan desain kemasan custom untuk produk UMKM, siap cetak.',
                'harga_min' => 25000,
                'harga_max' => 120000,
                'rating' => 4.70,
                'rating_count' => 156,
                'terjual' => '300+',
                'pengiriman' => 'Pre-Order (5 hari kerja)',
                'kategori' => 'Desain',
                'stok' => 'Open Order',
                'opsi_custom' => 'Ya',
                'quantity_per_pack' => null,
                'jurusan_logo_color' => '#fbbf24',
                'penilaian_count' => '156',
                'produk_count' => '18',
                'presentase_chat' => '70%',
                'waktu_chat' => 'Hitungan Jam',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/fcd34d/78350f?text=Kemasan+UMKM', 'caption' => 'Contoh kemasan'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Desain kemasan menarik, pelanggan makin tertarik beli.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'laporan-keuangan-umkm',
                'tipe' => 'showcase',
                'title' => 'Laporan Keuangan UMKM',
                'subtitle' => null,
                'jurusan_nama' => 'Akuntansi',
                'jurusan_slug' => 'akuntansi',
                'deskripsi' => 'Jasa penyusunan laporan keuangan sederhana untuk UMKM oleh siswa Akuntansi.',
                'harga_min' => 200000,
                'harga_max' => 600000,
                'rating' => 4.85,
                'rating_count' => 64,
                'terjual' => '80+',
                'pengiriman' => 'Pre-Order (7 hari kerja)',
                'kategori' => 'Jasa Keuangan',
                'stok' => 'Open Order',
                'opsi_custom' => 'Ya',
                'quantity_per_pack' => null,
                'jurusan_logo_color' => '#38bdf8',
                'penilaian_count' => '64',
                'produk_count' => '10',
                'presentase_chat' => '85%',
                'waktu_chat' => 'Hitungan Jam',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/0ea5e9/ecfeff?text=Laporan+Keuangan', 'caption' => 'Contoh laporan'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Laporan rapi dan mudah dipahami untuk usaha kecil.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'dashboard-logistik-mini',
                'tipe' => 'kustom',
                'title' => 'Dashboard Logistik Mini',
                'subtitle' => 'Karya siswa',
                'jurusan_nama' => 'Manajemen Logistik',
                'jurusan_slug' => 'manajemen-logistik',
                'deskripsi' => 'Dashboard mini untuk memantau stok dan pengiriman, dikembangkan siswa Manajemen Logistik.',
                'tanggal_pembuatan' => '2026-07-20',
                'angkatan' => 25,
                'didukung_oleh' => 'Bu Ani',
                'ketua_tim' => 'Bagas Pratama',
                'anggota_tim' => ['Intan Permata', 'Yoga Prasetyo'],
                'jurusan_logo_color' => '#fb923c',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/c2410c/ffedd5?text=Dashboard+Logistik', 'caption' => 'Dashboard overview'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Keren, cocok untuk simulasi mata pelajaran logistik.', 'rating' => 4],
                ],
            ],
            [
                'slug' => 'kemasan-snack-kreatif',
                'tipe' => 'kustom',
                'title' => 'Kemasan Snack Kreatif',
                'subtitle' => 'Karya siswa',
                'jurusan_nama' => 'Perhotelan',
                'jurusan_slug' => 'perhotelan',
                'deskripsi' => 'Produksi dan kemasan snack kreatif hasil karya siswa Perhotelan untuk berbagai acara.',
                'tanggal_pembuatan' => '2026-06-10',
                'angkatan' => 24,
                'didukung_oleh' => 'Chef Budi',
                'ketua_tim' => 'Larasati Dewi',
                'anggota_tim' => ['Andi Wijaya', 'Mega Lestari'],
                'jurusan_logo_color' => '#fbbf24',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/fde68a/78350f?text=Snack+Kreatif', 'caption' => 'Snack kreatif'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Snack-nya enak, kemasannya unik.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'jasa-instalasi-jaringan',
                'tipe' => 'showcase',
                'title' => 'Jasa Instalasi Jaringan',
                'subtitle' => null,
                'jurusan_nama' => 'Teknik Komputer dan Jaringan',
                'jurusan_slug' => 'teknik-komputer-dan-jaringan',
                'deskripsi' => 'Jasa instalasi dan konfigurasi jaringan komputer oleh siswa TKJ.',
                'harga_min' => 100000,
                'harga_max' => 400000,
                'rating' => 4.75,
                'rating_count' => 45,
                'terjual' => '60+',
                'pengiriman' => 'On-Site (sesuai lokasi)',
                'kategori' => 'Jasa Teknis',
                'stok' => 'Open Order',
                'opsi_custom' => 'Ya',
                'quantity_per_pack' => null,
                'jurusan_logo_color' => '#f87171',
                'penilaian_count' => '45',
                'produk_count' => '8',
                'presentase_chat' => '78%',
                'waktu_chat' => 'Hitungan Jam',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/b91c1c/fecaca?text=Instalasi+Jaringan', 'caption' => 'Instalasi jaringan'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Teknisi ramah dan hasilnya rapi.', 'rating' => 5],
                ],
            ],
            [
                'slug' => 'jasa-buat-aplikasi-absensi',
                'tipe' => 'kustom',
                'title' => 'Aplikasi Absensi Digital',
                'subtitle' => 'Karya siswa',
                'jurusan_nama' => 'Manajemen Perkantoran',
                'jurusan_slug' => 'manajemen-perkantoran',
                'deskripsi' => 'Aplikasi absensi digital sederhana untuk kebutuhan kantor, dirancang siswa Manajemen Perkantoran.',
                'tanggal_pembuatan' => '2026-05-05',
                'angkatan' => 25,
                'didukung_oleh' => 'Pak Sutrisno',
                'ketua_tim' => 'Putri Handayani',
                'anggota_tim' => ['Rian Firmansyah', 'Dewi Anggraini', 'Fajar Nugroho'],
                'jurusan_logo_color' => '#94a3b8',
                'galeri' => [
                    ['image_url' => 'https://placehold.co/800x600/475569/e2e8f0?text=Aplikasi+Absensi', 'caption' => 'Aplikasi absensi'],
                ],
                'komentars' => [
                    ['nama' => 'Anonim', 'komentar' => 'Sangat membantu pencatatan kehadiran di kantor kecil.', 'rating' => 4],
                ],
            ],
        ];

        foreach ($produks as $data) {
            $galeri = $data['galeri'] ?? [];
            $komentars = $data['komentars'] ?? [];
            unset($data['galeri'], $data['komentars']);

            $data['is_published'] = true;
            $produk = ProdukBlud::updateOrCreate(['slug' => $data['slug']], $data);

            foreach ($galeri as $i => $galeriItem) {
                ProdukBludGaleri::updateOrCreate(
                    ['produk_blud_id' => $produk->id, 'urutan' => $i + 1],
                    [
                        'image_url' => $galeriItem['image_url'],
                        'caption' => $galeriItem['caption'] ?? null,
                    ]
                );
            }

            foreach ($komentars as $komentarItem) {
                ProdukBludKomentar::updateOrCreate(
                    [
                        'produk_blud_id' => $produk->id,
                        'nama' => $komentarItem['nama'],
                        'komentar' => $komentarItem['komentar'],
                    ],
                    ['rating' => $komentarItem['rating'] ?? null]
                );
            }
        }
    }
}
