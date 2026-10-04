# Desain Panel Manajemen BLUD

Tanggal: 2026-10-04

## Latar Belakang
Sistem BLUD saat ini hanya menerima penawaran (pemesanan) dari publik. Panel admin hanya punya CRUD Produk dan Moderasi (lihat/hapus) dan hanya bisa diakses admin. Tidak ada status, tindak lanjut, catatan, atau role khusus.

## Tujuan
Staf BLUD dapat mengelola pesanan dan moderasi dengan alur status dan riwayat, lewat dashboard sendiri.

## 1. Role dan Akses
- Tambah `User::ROLE_BLUD`. Admin tetap bisa mengakses semua.
- Grup menu "BLUD" (Dashboard BLUD, Pesanan, Produk, Moderasi) dapat diakses `ROLE_ADMIN` dan `ROLE_BLUD`.
- `DashboardController` menambah `canSeeBlud()` mengikuti pola `canSeeX` yang ada. Role BLUD hanya melihat statistik BLUD.

## 2. Data (satu migrasi tambahan)
- `produk_blud_penawarans` (disebut "Pesanan"):
  - `status` string, default `baru`. Nilai: `baru|dihubungi|diproses|selesai|batal`.
  - `catatan_internal` text nullable.
  - `ditangani_oleh` foreign key ke users, nullable.
- `produk_blud_laporans` dan `produk_blud_komentars`:
  - `status` string, default `baru`. Nilai: `baru|ditindaklanjuti`.
  - `catatan_internal` text nullable.
  - `ditangani_oleh` foreign key ke users, nullable.
  - `ditangani_at` timestamp nullable.
- Kolom JSON tidak diberi default, karena MySQL menolaknya.
- Hapus tetap tersedia sebagai aksi sekunder.

## 3. Tampilan
- **Dashboard BLUD:**
  - Kartu: pesanan baru, laporan belum ditangani, komentar baru, total produk.
  - Daftar 5 pesanan terbaru dan laporan yang belum ditangani.
- **Pesanan:**
  - Tabel dengan filter status dan pencarian.
  - Halaman detail dengan tombol WA (`wa.me`), dropdown status, dan catatan internal.
- **Moderasi:**
  - Tab komentar, penawaran, dan laporan yang ada tetap dipakai.
  - Badge status dan tombol "Tandai ditindaklanjuti" per baris.
  - Urutan: yang `baru` lebih dulu.
  - Tab penawaran menjadi tautan ke halaman Pesanan.

## 4. Kode
- `Admin\Blud\PesananController` baru (index, show, update).
- `ModerasiController` ditambah aksi tindak lanjut untuk laporan dan komentar. Logika penawaran dipindah ke `PesananController`.
- `BludDashboardController` baru, atau memakai `DashboardController` yang diperluas.
- Validasi lewat FormRequest. Route di `routes/admin.php`. Menu di `AdminMenu`. Jalankan Pint di akhir.

## Di Luar Cakupan
Harga, jumlah, pembayaran, pengiriman, dan laporan keuangan.
