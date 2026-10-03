# Laporan Eksplorasi & Audit Mendalam JHIC-Smeas-v2

Dokumen ini berisi hasil audit menyeluruh terhadap arsitektur kode, routing, fungsionalitas formulir, integrasi frontend-backend, dan konsistensi UI/UX pada proyek **JHIC-Smeas-v2** (Laravel 13, Tailwind CSS v4, Blade, PHPUnit).

---

## Ringkasan Prioritas Temuan

```
┌─────────────────────────────────────────────────────────────┐
│ CRITICAL (Mendesak / Fungsionalitas Rusak / Test Gagal)    │ 5 Temuan (1 Fixed)
├─────────────────────────────────────────────────────────────┤
│ HIGH (Fitur Menggantung / Data Mock Padahal Ada DB)         │ 7 Temuan
├─────────────────────────────────────────────────────────────┤
│ MEDIUM (Inkonsistensi UI/UX / Dead Links / Navigasi Lepas)  │ 6 Temuan
├─────────────────────────────────────────────────────────────┤
│ LOW (Penyempurnaan Kosmetik & Standarisasi Layout)          │ 4 Temuan
└─────────────────────────────────────────────────────────────┘
```

---

## 1. Prioritas CRITICAL (Mendesak / Bug Fungsional / Test Gagal)

### [CRITICAL-01] ✅ FIXED — Halaman Informasi Sekarang Menampilkan Artikel Dinamis
* **Status**: **SELESAI (Fixed)** — `test_informasi_page_displays_artikels` hijau.
* **Perbaikan**: `routes/web.php` route `/informasi` kini mengambil `Artikel::where('kategori', 'berita')->latest('published_at')->limit(6)->get()` + `Pengumuman::latest()->limit(5)->get()` (mengikuti pola `informasi.prestasi` / `informasi.akademik`), dan grid "Berita Terbaru" di `informasi.blade.php` diganti dari 3 kartu hardcoded menjadi `@forelse ($artikels as $artikel)` dengan thumbnail `image_path` dan fallback gradient.
* **Lokasi**: [routes/web.php](file:///c:/laragon/www/JHIC-Smeas-v2/routes/web.php#L63-L65), [resources/views/informasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi.blade.php#L280-L335), [tests/Feature/PublicPagesTest.php](file:///c:/laragon/www/JHIC-Smeas-v2/tests/Feature/PublicPagesTest.php#L38-L46)
* **Kondisi Saat Ini**:
  Test `test_informasi_page_displays_artikels` gagal (exit code 1). Di `routes/web.php`, route `/informasi` hanya merender `view('informasi')` kosong tanpa mempassing variabel `$artikels`. Di blade `informasi.blade.php`, section "Berita Terbaru" ditulis **hardcoded statis 3 card** tanpa loop `@forelse($artikels as $artikel)`. Berbeda dengan `informasi-prestasi` dan `informasi-akademik` yang sudah me-loop database.
* **Apa yang Seharusnya Terjadi**:
  Route `/informasi` mengambil data artikel dari model `Artikel::where('is_published', true)->latest('published_at')->paginate(...)` atau `get()`, dan `informasi.blade.php` me-looping koleksi tersebut ke dalam kartu berita lengkap dengan judul, thumbnail, dan link ke detail.
* **Tindakan yang Harus Dikerjakan**:
  1. Perbarui closure route `/informasi` di [routes/web.php](file:///c:/laragon/www/JHIC-Smeas-v2/routes/web.php) agar mengambil data artikel publik.
  2. Ubah grid berita di [resources/views/informasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi.blade.php) agar membaca variabel `$artikels`.
  3. Pastikan test suite `php artisan test` hijau (pass).

---

### [CRITICAL-02] Alur Pengajuan Lamaran Magang Terputus (Form HTML Mengirim POST Biasa, Controller Mengembalikan JSON)
* **Lokasi**: [resources/views/pusat-karir/lamar-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/lamar-lowongan.blade.php#L349-L352), [app/Http/Controllers/LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php#L119-L142), [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1356-L1408)
* **Kondisi Saat Ini**:
  - Pada [lamar-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/lamar-lowongan.blade.php), form tag adalah `<form action="..." method="POST">` standar HTML tanpa intercept JavaScript `fetch()` / AJAX.
  - Namun pada [LowonganController.php:storeApply()](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php#L134-L141), respon yang dikembalikan adalah `response()->json([...], 201)`.
  - Akibatnya, saat siswa menekan tombol "Kirim Lamaran", browser menampilkan layar putih berisi teks JSON mentah (`{"success":true,"message":"...","data":{...}}`), bukan kembali ke halaman detail atau menampilkan popup sukses.
  - Sementara itu, di [detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1356) sudah disiapkan popup `@if (session('lamaran_success'))` yang tidak pernah terpicu karena controller tidak pernah melakukan `redirect()->with('lamaran_success', ...)`.
* **Apa yang Seharusnya Terjadi**:
  Setelah form dikirim, pengguna diarahkan kembali ke detail lowongan dengan flash session `lamaran_success` sehingga modal popup "Pengajuan magang terkirim" beserta nomor registrasi PKL muncul, atau form ditangani via `fetch()` dan merender modal konfirmasi langsung.
* **Tindakan yang Harus Dikerjakan**:
  - Sesuaikan `storeApply()` di [LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php) agar jika request adalah HTTP reguler (`!$request->wantsJson()`), lakukan `return redirect()->route('pusat-karir.detail', $slug)->with('lamaran_success', [...])`.

---

### [CRITICAL-03] File Upload Dokumen Lamaran Magang Diabaikan & Tidak Disimpan
* **Lokasi**: [resources/views/pusat-karir/lamar-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/lamar-lowongan.blade.php#L390-L423), [app/Http/Controllers/LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php#L123-L132), [app/Models/MagangApplication.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Models/MagangApplication.php)
* **Kondisi Saat Ini**:
  Form `lamar-lowongan.blade.php` memiliki input unggah berkas PDF persyaratan magang (`name="{{ $inputName }}"`). Namun di [LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php), validasi hanya memeriksa `nisn`, berkas upload sama sekali tidak divalidasi maupun disimpan ke disk storage, dan tabel `magang_applications` tidak memiliki kolom/relasi penyimpanan file berkas pendaftar.
* **Apa yang Seharusnya Terjadi**:
  Berkas pendaftaran magang (CV/Portofolio/Surat Pengantar) divalidasi format dan ukurannya, disimpan ke storage (`storage/app/public/magang/...`), dan path file dicatat di database sehingga admin BKK di halaman `admin/lamaran` dapat mengunduh dan memverifikasinya.
* **Tindakan yang Harus Dikerjakan**:
  1. Tambahkan migration kolom file attachment atau relasi dokumen pada `magang_applications`.
  2. Implementasikan upload handling di `storeApply()` dan tampilkan berkas tersebut di panel admin [LamaranController](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/Admin/Bkk/LamaranController.php).

---

### [CRITICAL-04] Upload Dokumen SPMB Menggunakan Overwrite File Path Tanpa Pencatatan Database
* **Lokasi**: [app/Http/Controllers/SpmbController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/SpmbController.php#L227-L248), [app/Http/Controllers/Admin/Spmb/CalonSiswaController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/Admin/Spmb/CalonSiswaController.php#L66-L81), [resources/views/spmb/dashboard/verifikasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/spmb/dashboard/verifikasi.blade.php#L118-L153)
* **Kondisi Saat Ini**:
  Pada [SpmbController.php:saveDokumen()](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/SpmbController.php#L241-L243):
  ```php
  foreach ($request->file('docs') as $key => $file) {
      $path = $file->store("spmb/{$nisn}", 'public');
  }
  ```
  Path file hasil upload tidak disimpan ke model `CalonSiswa` ataupun tabel dokumen. Controller admin [CalonSiswaController::show](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/Admin/Spmb/CalonSiswaController.php#L68-L80) hanya menebak dengan membaca isi folder filesystem `Storage::disk('public')->files("spmb/{$nisn}")`.
  Dampaknya:
  - Di halaman calon siswa [verifikasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/spmb/dashboard/verifikasi.blade.php#L125-L151), bagian "Dokumen" selalu bertuliskan statis "Wajib diunggah", siswa tidak bisa melihat file apa yang sudah terunggah, nama file, maupun status kelengkapan per jenis dokumen (Akta, KK, Ijazah).
* **Apa yang Seharusnya Terjadi**:
  Status atau path dokumen spesifik (akta, kk, ijazah) dicatat di database atau dicek keberadaannya di folder berdasarkan nama jenis dokumen, sehingga siswa dan panitia SPMB tahu persis dokumen mana yang sudah atau belum diunggah.
* **Tindakan yang Harus Dikerjakan**:
  - Simpan mapping jenis dokumen ke database atau susun penamaan file terstruktur (`akta.pdf`, `kk.pdf`, `ijazah.pdf`) dan oper statusnya ke view siswa.

---

### [CRITICAL-05] Fitur "Unduh Bukti Pengajuan (PDF)" Magang & Unduh Dokumen Silabus Mengarah ke URL Kosong/Buntutu
* **Lokasi**: [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1403-L1405), [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1716-L1747)
* **Kondisi Saat Ini**:
  - Tombol `<button type="button" class="success-download-btn">Unduh Bukti Pengajuan (PDF)</button>` tidak memiliki event listener JavaScript maupun link route download PDF.
  - Link download "Dokumen & Silabus Kemitraan" di sidebar detail lowongan memiliki `href="#"`.
* **Apa yang Seharusnya Terjadi**:
  Jika siswa ingin mengunduh bukti pendaftaran PKL, sistem men-generate kartu registrasi PDF (seperti halnya di modul SPMB dengan Dompdf). Link silabus seharusnya mengarah ke URL download dokumen atau asset storage yang valid.
* **Tindakan yang Harus Dikerjakan**:
  - Buat route & method controller `unduhBuktiMagang($registration_code)` dengan PDF view, atau sembunyikan tombol jika PDF generator bukti magang belum masuk cakupan fase rilis saat ini.

---

## 2. Prioritas HIGH (Fitur Menggantung & Data Mock Padahal Database Tersedia)

### [HIGH-01] Beranda (Landing Page) Sepenuhnya Menggunakan Data Statis / Hardcoded
* **Lokasi**: [routes/web.php](file:///c:/laragon/www/JHIC-Smeas-v2/routes/web.php#L22-L24), [resources/views/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/index.blade.php)
* **Kondisi Saat Ini**:
  - Route `/` di `routes/web.php` hanya `return view('index');` tanpa memanggil data model apapun.
  - Di `index.blade.php`:
    - Bagian **Prakata Kepala Sekolah** memuat kutipan hardcoded dan foto statis, padahal sudah ada [admin.settings.edit](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/admin/settings/edit.blade.php).
    - Bagian **Statistik** (9 Jurusan, 120+ Pengajar, 1200+ Siswa) hardcoded di HTML baris 716-740.
    - Bagian **Guru dan Tenaga Kependidikan Carousel** (baris 919-978) memuat 4 guru statis ("Sari Okta", "Sidik Dwi Widodo", "Pak Adi", "Anton Sujarwo"), padahal tabel `gurus` sudah ada dan dikelola lewat admin panel Humas.
    - Bagian **Berita SMKN 1 Surabaya** (baris 1089-1150) memuat 3 berita statis hardcoded ("VBG — Web Dev Competition 2026", dll), mengabaikan tabel `artikels`.
* **Apa yang Seharusnya Terjadi**:
  Beranda memuat data dinamis: guru teratas dari tabel `Guru`, berita terbaru dari tabel `Artikel`, serta data kontak/visi dari model `Setting`.
* **Tindakan yang Harus Dikerjakan**:
  - Ubah handler route `/` di `web.php` atau buat `HomeController@index` untuk memasok `$gurus`, `$artikels`, dan `$settings`.
  - Ganti markup hardcoded di `index.blade.php` dengan looping Blade.

---

### [HIGH-02] Input Search Jurusan di Beranda Tidak Terkoneksi & Bersifat Hiasan
* **Lokasi**: [resources/views/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/index.blade.php#L1016-L1038)
* **Kondisi Saat Ini**:
  Di section "Temukan Jurusanmu, Buka Peluang Karirmu", terdapat `<input type="text" placeholder="...">` tanpa tag `<form>`, tanpa atribut `name`, dan tombol di bawahnya hanyalah `<a href="{{ route('jurusan') }}">Mulai Cari →</a>`. Apapun yang diketik pengguna tidak diproses atau diteruskan ke katalog jurusan.
* **Apa yang Seharusnya Terjadi**:
  Input search dibungkus tag form `<form action="{{ route('jurusan') }}" method="GET">` dengan `name="q"`, dan halaman jurusan dapat memfilter daftar jurusan berdasarkan keyword pencarian tersebut.
* **Tindakan yang Harus Dikerjakan**:
  - Bungkus input dalam form GET ke route jurusan dan tangkap query string di halaman jurusan.

---

### [HIGH-03] Bagian "Sumber Rekomendasi" di Pusat Karir Masih Berupa Array Kosong / Mockup Desain
* **Lokasi**: [resources/views/pusat-karir/pusat-karir.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/pusat-karir.blade.php#L904-L960)
* **Kondisi Saat Ini**:
  Terdapat blok kode PHP:
  ```php
  // Data dummy — diset kosong [] sampai backend & dashboard admin selesai
  $sumberRekomendasi = $sumberRekomendasi ?? [];
  ```
  Di bawahnya terdapat markup panjang untuk menampilkan rekomendasi kartu karir lengkap dengan komentar placeholder `Asset Image Placeholder`, namun karena array dikosongkan, section ini tidak pernah tampil ke pengguna publik atau tidak memiliki model Eloquent/Admin CRUD.
* **Apa yang Seharusnya Terjadi**:
  Jika section "Sumber Rekomendasi" diperlukan, buat tabel/model `SumberRekomendasi` atau integrasikan dengan kategori `Artikel` kategori rekomendasi. Jika belum masuk lingkup, bersihkan dari kode agar tidak membingungkan.
* **Tindakan yang Harus Dikerjakan**:
  - Tentukan apakah sumber rekomendasi dialihkan ke model `Artikel` (kategori: rekomendasi/tips) atau dibuatkan tabel tersendiri.

---

### [HIGH-04] Filter Pencarian di BLUD & Katalog Magang Belum Sepenuhnya Terintegrasi Backend
* **Lokasi**: [app/Http/Controllers/BludController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/BludController.php#L12-L20), [resources/views/blud/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/blud/index.blade.php#L280-L293)
* **Kondisi Saat Ini**:
  - Di `BludController::index()`, controller mengambil seluruh data produk tanpa parameter search query backend (`$request->query('q')`).
  - Pencarian di `blud/index.blade.php` dilakukan murni menggunakan JavaScript DOM manipulation di browser (`data-search`). Jika produk berjumlah puluhan/ratusan dan dipaginasi, pencarian JS ini hanya menyaring item di halaman aktif (bukan seluruh database).
* **Apa yang Seharusnya Terjadi**:
  Pencarian BLUD didukung query backend (`where('title', 'like', ...)`) atau form submit GET yang mempertahankan query string.
* **Tindakan yang Harus Dikerjakan**:
  - Tambahkan parameter `Request $request` di `BludController::index()` dan filter query jika `q` terisi.

---

### [HIGH-05] Tombol "Chat Sekarang" & "Konsultasi WA" Menggunakan Link WhatsApp Kosong (`https://wa.me/`)
* **Lokasi**: [resources/views/blud/detail-showcase.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/blud/detail-showcase.blade.php#L121), [resources/views/blud/detail-showcase.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/blud/detail-showcase.blade.php#L139), [resources/views/blud/detail-kustom.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/blud/detail-kustom.blade.php#L129)
* **Kondisi Saat Ini**:
  Tombol CTA pembelian produk BLUD dan tanya seputar karya mengarah ke tautan `href="https://wa.me/"` tanpa nomor telepon tujuan. Ketika pengunjung mengklik tombol tersebut, mereka diarahkan ke halaman error WhatsApp.
* **Apa yang Seharusnya Terjadi**:
  Link WhatsApp mengambil nomor admin BLUD / PIC jurusan dari tabel `Settings` (misal setting `school_whatsapp` atau nomor telepon jurusan) serta menyertakan teks pesan prefilled (contoh: `https://wa.me/62812xxx?text=Halo%20saya%20tertarik%20dengan%20produk%20...`).
* **Tindakan yang Harus Dikerjakan**:
  - Ambil nomor WA dari Setting/Jurusan dan bentuk URL WhatsApp dengan query teks produk.

---

### [HIGH-06] Menu "Keluar" di Sidebar SPMB Mengarah ke Route Pusat Karir
* **Lokasi**: [resources/views/spmb/dashboard/layout.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/spmb/dashboard/layout.blade.php#L503-L507)
* **Kondisi Saat Ini**:
  Terdapat komentar kode:
  ```html
  {{-- ponytail: beranda belum ada — arahkan ke pusat karir; swap href ke route beranda saat tersedia --}}
  <a href="{{ route('pusat-karir.index') }}" class="dash-nav-item">
      <x-lucide-log-out />
      Keluar
  </a>
  ```
  Tombol "Keluar" di dashboard calon siswa SPMB tidak melakukan logout session siswa (`session()->forget('spmb_nisn')`), melainkan hanya berupa link biasa ke halaman Pusat Karir. Akibatnya, sesi calon siswa tetap tertinggal di browser.
* **Apa yang Seharusnya Terjadi**:
  Menyediakan mekanisme logout khusus SPMB (misal route POST atau GET `spmb.logout`) yang menghapus session `spmb_nisn` dan mengarahkan kembali ke landing SPMB atau Beranda.
* **Tindakan yang Harus Dikerjakan**:
  - Buat route `spmb.logout` di `routes/web.php` dan panggil `session()->forget('spmb_nisn')`.
  - Perbarui link di sidebar SPMB.

---

### [HIGH-07] Verifikasi Data Siswa di Form Lamar Magang Murni Client-side Mockup
* **Lokasi**: [resources/views/pusat-karir/lamar-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/lamar-lowongan.blade.php#L458-L482)
* **Kondisi Saat Ini**:
  Tombol "Verifikasi NISN" hanya menjalankan regex JavaScript sederhana `if (/^\d{10}$/.test(val))` lalu menampilkan teks mockup statis: `"Data Siswa NISN 1234567890 (NISN Valid)"`. Tidak ada pengecekan ke database siswa/alumni apakah NISN tersebut benar-benar milik siswa SMKN 1 Surabaya.
* **Apa yang Seharusnya Terjadi**:
  Melakukan endpoint fetch/AJAX ke endpoint pengecekan NISN siswa aktif atau integrasikan dengan database master siswa untuk menampilkan nama siswa yang sesungguhnya.
* **Tindakan yang Harus Dikerjakan**:
  - Hubungkan verifikasi NISN ke endpoint backend API internal.

---

## 3. Prioritas MEDIUM (Inkonsistensi Navigasi, Dead Links, & Alur)

### [MEDIUM-01] Inkonsistensi Footer Antar Halaman Publik
* **Lokasi**:
  - [resources/views/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/index.blade.php#L1190) (Footer lengkap 3 kolom: Map, Profil, Jelajahi)
  - [resources/views/blud/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/blud/index.blade.php#L349-L351) (Footer 1 baris teks: "Dibuat dengan ❤️ oleh Chicken Noodles Team")
  - [resources/views/pusat-karir/study-tracer.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/study-tracer.blade.php#L235-L237) (Footer 1 baris teks sederhana)
  - [resources/views/informasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi.blade.php#L340) (Footer mandiri duplikat kode)
* **Kondisi Saat Ini**:
  Halaman tidak menggunakan satu partial footer bersama. Footer di-hardcode berulang kali di masing-masing file view Blade, sehingga terjadi inkonsistensi desain dan link.
* **Apa yang Seharusnya Terjadi**:
  Dibuat partial `resources/views/partials/footer.blade.php` seperti halnya `navbar.blade.php`, lalu di-include secara konsisten di semua halaman publik.

---

### [MEDIUM-02] Dead Link di Detail Lowongan ("Lihat Detail Loker →" & Tag Filter)
* **Lokasi**: [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1617-L1620), [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1350)
* **Kondisi Saat Ini**:
  - Di section "Loker BKK Alumni (hardcoded demo)", tombol aksi menggunakan `href="#"`.
  - Breadcrumb `Mitra Industri (DUDI)` mengarah ke `href="#"`.
  - Tombol simpan bookmark (`bookmark-btn`) hanya icon SVG tanpa action JavaScript atau backend endpoint bookmark.
* **Apa yang Seharusnya Terjadi**:
  Breadcrumb diarahkan ke `route('pusat-karir.katalog-mitra')`, link loker diarahkan ke detail loker terkait jika dinamis, dan tombol interaktif yang belum siap diberi handling yang jelas atau disembunyikan.

---

### [MEDIUM-03] Filter Prestasi Tingkat Kota/Provinsi/Nasional Tidak Menyaring Berita Terkait
* **Lokasi**: [resources/views/informasi-prestasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi-prestasi.blade.php#L240-L315)
* **Kondisi Saat Ini**:
  Halaman "Prestasi" memiliki tab filter tingkat ("Semua", "Nasional", "Provinsi", "Kota"). Kartu-kartu prestasi di atasnya adalah daftar hardcoded HTML (`data-level="nasional"`, dll), sedangkan daftar berita di bawahnya diisi dari model `Artikel`. Namun filter pill tersebut hanya memanipulasi kartu hardcoded di atas dan tidak memfilter koleksi berita artikel prestasi di database.
* **Apa yang Seharusnya Terjadi**:
  Data prestasi bersumber dari database (misal model `Prestasi` atau `Artikel` dengan metadata tingkat prestasi) sehingga filter berfungsi secara terpadu.

---

### [MEDIUM-04] Link BLUD di Footer Masih Mengarah ke `href="#"` pada Beberapa View
* **Lokasi**: [resources/views/informasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi.blade.php#L427), [resources/views/informasi-prestasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi-prestasi.blade.php#L427), [resources/views/informasi-akademik.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi-akademik.blade.php#L380)
* **Kondisi Saat Ini**:
  Pada menu navigasi footer "Jelajahi Smeas", link BLUD ditulis `<a href="#">BLUD</a>`, padahal route `blud.index` sudah tersedia dan aktif.
* **Apa yang Seharusnya Terjadi**:
  Semua link BLUD di footer menggunakan `route('blud.index')`.

---

### [MEDIUM-05] Status Kuesioner Tracer Study Alumni: Toggle Confirm Admin Belum Ada Feedback di Frontend
* **Lokasi**: [app/Http/Controllers/Admin/Bkk/TracerController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/Admin/Bkk/TracerController.php), [resources/views/pusat-karir/kuesioner-tracer.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/kuesioner-tracer.blade.php)
* **Kondisi Saat Ini**:
  Admin memiliki fitur `toggleConfirmKuesioner`, namun di sisi alumni tidak ada halaman status atau pelacakan kuesioner yang telah diisi. Setelah form kuesioner disubmit, hanya muncul notifikasi flash success dan kembali ke form awal.
* **Apa yang Seharusnya Terjadi**:
  Alumni mendapatkan halaman ringkasan tanda terima kuesioner bahwa data telah terkirim dan tersimpan.

---

### [MEDIUM-06] Input File Upload pada Dokumen SPMB Menggunakan Nama Dokumen Kebab-case yang Berbeda dengan Key Validasi
* **Lokasi**: [resources/views/spmb/dashboard/dokumen.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/spmb/dashboard/dokumen.blade.php#L29-L34), [app/Http/Controllers/SpmbController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/SpmbController.php#L231)
* **Kondisi Saat Ini**:
  Key array adalah `docs[kartu-keluarga]` dan `docs[ijazah-smp]`. Validasi di controller menggunakan `'docs.kartu-keluarga'`. Meskipun berjalan, validasi pesan error Laravel untuk nested array dengan tanda minus sering kali memicu kendala display error pada beberapa driver session jika terjadi penolakan validasi.
* **Apa yang Seharusnya Terjadi**:
  Gunakan naming convention snake_case standar (`docs[kartu_keluarga]`, `docs[ijazah_smp]`) di view maupun controller validation rule.

---

## 4. Prioritas LOW (Penyempurnaan Kosmetik, Refactoring, & Polish)

### [LOW-01] Pola Inline CSS yang Sangat Masif di `index.blade.php` dan `pusat-karir.blade.php`
* **Lokasi**: [resources/views/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/index.blade.php), [resources/views/pusat-karir/pusat-karir.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/pusat-karir.blade.php)
* **Kondisi Saat Ini**:
  Terdapat ribuan baris inline CSS tag `<style>` dan inline attribute `style="..."` manual di samping Tailwind CSS. Sebagian besar deklarasi style mengabaikan utility classes Tailwind yang sudah terpasang di proyek (Tailwind v4).
* **Rekomendasi**:
  Lakukan refactoring bertahap untuk memindahkan styling ke class utility Tailwind CSS agar lebih mudah di-maintain dan ukuran file HTML menjadi jauh lebih ringkas.

---

### [LOW-02] Placeholder Domain / Dummy Social Media di Berbagai Footer
* **Lokasi**: Hampir seluruh Blade view footer
* **Kondisi Saat Ini**:
  Ikon sosial media (Instagram, YouTube) mengarah ke `https://instagram.com` dan `https://youtube.com` generik tanpa username akun sekolah. Padahal di database tabel `settings` sudah disediakan key `social_instagram`, `social_youtube`, dan `social_facebook`.
* **Rekomendasi**:
  Kaitkan link sosial media dengan `\App\Models\Setting::get('social_instagram', 'https://instagram.com/smkn1surabaya')`.

---

### [LOW-03] Gambar Placeholder Eksternal Unsplash & Placehold.co
* **Lokasi**: [resources/views/blud/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/blud/index.blade.php#L273), [resources/views/pusat-karir/study-tracer.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/study-tracer.blade.php#L78), [resources/views/informasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/informasi.blade.php#L296)
* **Kondisi Saat Ini**:
  Masih menggunakan tautan URL eksternal `https://placehold.co/...` dan `https://images.unsplash.com/...`. Jika server offline atau koneksi internet terputus, gambar placeholder akan rusak (broken image).
* **Rekomendasi**:
  Ganti dengan SVG asset lokal atau gambar representatif di folder `public/images/`.

---

### [LOW-04] Duplikasi View Jurusan yang Belum Menggunakan Database
* **Lokasi**: [resources/views/jurusan/](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/jurusan) (9 file blade individual)
* **Kondisi Saat Ini**:
  Terdapat 9 file template individual untuk tiap jurusan (`akuntansi.blade.php`, `rekayasa-perangkat-lunak.blade.php`, dst). Masing-masing file hanya mengisi section statis tanpa tabel `jurusans` di database.
* **Rekomendasi**:
  Meskipun saat ini berjalan dengan baik melalui layout inheritance, ke depannya akan jauh lebih mudah dikelola bila dibuat tabel `jurusans` lengkap dengan kolom kompetensi dan prospek karir sehingga admin Humas atau Kurikulum dapat memperbarui informasi jurusan langsung dari admin panel.

---

## Checklist Rencana Kerja Perbaikan

| No | Kategori | Item Pekerjaan | Status |
|:--:|:---|:---|:---:|
| 1 | **Critical** | Hubungkan data `Artikel` ke route `/informasi` & Blade template (Fix Test Suite) | ✅ **Fixed** (CRITICAL-01) |
| 2 | **Critical** | Perbaiki respon `storeApply` di `LowonganController` dari JSON ke Redirect dengan Session Flash | ⏳ Siap dikerjakan |
| 3 | **Critical** | Tambahkan mekanisme penyimpanan berkas pendaftaran magang di `storeApply` | ⏳ Siap dikerjakan |
| 4 | **Critical** | Catat mapping dokumen SPMB calon siswa ke database dan tampilkan status riil di halaman verifikasi | ⏳ Siap dikerjakan |
| 5 | **Critical** | Berikan route download atau sembunyikan tombol PDF bukti magang & silabus yang kosong | ⏳ Siap dikerjakan |
| 6 | **High** | Dinamisasi Beranda (`index.blade.php`) dengan data Guru, Artikel, dan Pengaturan dari DB | ⏳ Siap dikerjakan |
| 7 | **High** | Fungsikan search bar jurusan di beranda menuju form GET `/jurusan` | ⏳ Siap dikerjakan |
| 8 | **High** | Hubungkan nomor WhatsApp konsultasi BLUD dengan setting nomor telepon resmi | ⏳ Siap dikerjakan |
| 9 | **High** | Buat route & method logout sesi SPMB pada sidebar dashboard calon siswa | ⏳ Siap dikerjakan |
| 10 | **Medium** | Satukan footer seluruh halaman publik ke dalam `resources/views/partials/footer.blade.php` | ⏳ Siap dikerjakan |
| 11 | **Medium** | Perbaiki dead links (`#`) pada footer BLUD dan breadcrumb detail lowongan | ⏳ Siap dikerjakan |
| 12 | **Low** | Ganti placeholder eksternal (`placehold.co`) dengan asset lokal | ⏳ Siap dikerjakan |
