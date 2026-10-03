# Laporan Eksplorasi & Audit Mendalam JHIC-Smeas-v2

Dokumen ini berisi hasil audit menyeluruh terhadap arsitektur kode, routing, fungsionalitas formulir, integrasi frontend-backend, dan konsistensi UI/UX pada proyek **JHIC-Smeas-v2** (Laravel 13, Tailwind CSS v4, Blade, PHPUnit).

---

## Ringkasan Prioritas Temuan

```
┌─────────────────────────────────────────────────────────────┐
│ CRITICAL (Mendesak / Fungsionalitas Rusak / Test Gagal)    │ 5 Temuan (5 Fixed)
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

### [CRITICAL-02] ✅ FIXED — Alur Pengajuan Lamaran Magang Redirect dengan Flash Session
* **Status**: **SELESAI (Fixed)** — `test_regular_post_redirects_to_detail_with_flash` & `test_json_request_still_receives_json` hijau.
* **Perbaikan**: `LowonganController::storeApply()` kini mengecek `$request->wantsJson()`. Jika request adalah form submit HTML reguler, controller me-redirect kembali ke route `pusat-karir.detail` dengan flash session `lamaran_success` sehingga modal popup "Pengajuan magang terkirim" beserta nomor registrasi PKL tampil interaktif.
* **Lokasi**: [app/Http/Controllers/LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php), [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php#L1356), [tests/Feature/LowonganApplyValidationTest.php](file:///c:/laragon/www/JHIC-Smeas-v2/tests/Feature/LowonganApplyValidationTest.php)

---

### [CRITICAL-03] ✅ FIXED — File Upload Dokumen Lamaran Magang Divalidasi & Disimpan
* **Status**: **SELESAI (Fixed)** — `test_uploaded_files_are_stored_and_recorded` & `test_required_pdf_is_validated` hijau.
* **Perbaikan**: Menambahkan migrasi kolom JSON `documents` pada tabel `magang_applications` dan casting array pada model `MagangApplication`. `storeApply()` memvalidasi input dokumen secara dinamis berdasarkan definisi lowongan, menyimpan file ke storage `public/magang/{registration_code}/`, serta menampilkannya di tabel admin panel BKK [LamaranController](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/Admin/Bkk/LamaranController.php) dan view `admin/bkk/lamaran/index.blade.php`.
* **Lokasi**: [app/Http/Controllers/LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php), [app/Models/MagangApplication.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Models/MagangApplication.php), [database/migrations/2026_10_03_100000_add_documents_to_magang_applications_table.php](file:///c:/laragon/www/JHIC-Smeas-v2/database/migrations/2026_10_03_100000_add_documents_to_magang_applications_table.php), [resources/views/admin/bkk/lamaran/index.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/admin/bkk/lamaran/index.blade.php)

---

### [CRITICAL-04] ✅ FIXED — Dokumen SPMB Disimpan Terstruktur & Status Ditampilkan Riil
* **Status**: **SELESAI (Fixed)** — `test_documents_are_saved_with_structured_names_and_reported` hijau.
* **Perbaikan**: Menggunakan penamaan terstruktur (`akta.ext`, `kartu_keluarga.ext`, `ijazah_smp.ext`) pada folder `spmb/{nisn}/` dengan penghapusan otomatis file lama saat ekstensi berbeda diunggah ulang. Model `CalonSiswa` memiliki helper `dokumenStatus()` yang menyediakan informasi status keberadaan, nama file, URL, dan ukuran dokumen. Status ini diintegrasikan ke halaman `dokumen.blade.php`, ringkasan `verifikasi.blade.php`, dan panel admin `CalonSiswaController::show`.
* **Lokasi**: [app/Models/CalonSiswa.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Models/CalonSiswa.php), [app/Http/Controllers/SpmbController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/SpmbController.php), [resources/views/spmb/dashboard/verifikasi.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/spmb/dashboard/verifikasi.blade.php), [resources/views/admin/spmb/calon-siswa/show.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/admin/spmb/calon-siswa/show.blade.php)

---

### [CRITICAL-05] ✅ FIXED — Unduh Bukti Pengajuan (PDF) Magang Tersedia & Link Silabus Dinonaktifkan
* **Status**: **SELESAI (Fixed)** — `test_bukti_pdf_can_be_downloaded` hijau.
* **Perbaikan**: Membuat route `pusat-karir.bukti-lamar` dan method `LowonganController::unduhBukti()` dengan template PDF `resources/views/pusat-karir/bukti-lamaran-pdf.blade.php` berbasis Dompdf. Tombol popup sukses kini langsung mengunduh PDF kartu registrasi resmi. Link silabus demo yang belum memiliki dokumen fisik dinonaktifkan dengan `aria-disabled="true"` dan styling cursor `not-allowed`.
* **Lokasi**: [routes/web.php](file:///c:/laragon/www/JHIC-Smeas-v2/routes/web.php), [app/Http/Controllers/LowonganController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/LowonganController.php), [resources/views/pusat-karir/bukti-lamaran-pdf.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/bukti-lamaran-pdf.blade.php), [resources/views/pusat-karir/detail-lowongan.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/pusat-karir/detail-lowongan.blade.php)

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

### [MEDIUM-06] ✅ FIXED — Input File Upload pada Dokumen SPMB Menggunakan Nama Dokumen Kebab-case yang Berbeda dengan Key Validasi
* **Status**: **SELESAI (Fixed)**
* **Perbaikan**: Key form upload di view `resources/views/spmb/dashboard/dokumen.blade.php` serta validation rules di `SpmbController::saveDokumen()` diselaraskan menjadi snake_case standar (`docs.kartu_keluarga`, `docs.ijazah_smp`).
* **Lokasi**: [resources/views/spmb/dashboard/dokumen.blade.php](file:///c:/laragon/www/JHIC-Smeas-v2/resources/views/spmb/dashboard/dokumen.blade.php), [app/Http/Controllers/SpmbController.php](file:///c:/laragon/www/JHIC-Smeas-v2/app/Http/Controllers/SpmbController.php)

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
| 2 | **Critical** | Perbaiki respon `storeApply` di `LowonganController` dari JSON ke Redirect dengan Session Flash | ✅ **Fixed** (CRITICAL-02) |
| 3 | **Critical** | Tambahkan mekanisme penyimpanan berkas pendaftaran magang di `storeApply` | ✅ **Fixed** (CRITICAL-03) |
| 4 | **Critical** | Catat mapping dokumen SPMB calon siswa ke database dan tampilkan status riil di halaman verifikasi | ✅ **Fixed** (CRITICAL-04) |
| 5 | **Critical** | Berikan route download atau sembunyikan tombol PDF bukti magang & silabus yang kosong | ✅ **Fixed** (CRITICAL-05) |
| 6 | **High** | Dinamisasi Beranda (`index.blade.php`) dengan data Guru, Artikel, dan Pengaturan dari DB | ⏳ Siap dikerjakan |
| 7 | **High** | Fungsikan search bar jurusan di beranda menuju form GET `/jurusan` | ⏳ Siap dikerjakan |
| 8 | **High** | Hubungkan nomor WhatsApp konsultasi BLUD dengan setting nomor telepon resmi | ⏳ Siap dikerjakan |
| 9 | **High** | Buat route & method logout sesi SPMB pada sidebar dashboard calon siswa | ⏳ Siap dikerjakan |
| 10 | **Medium** | Satukan footer seluruh halaman publik ke dalam `resources/views/partials/footer.blade.php` | ⏳ Siap dikerjakan |
| 11 | **Medium** | Perbaiki dead links (`#`) pada footer BLUD dan breadcrumb detail lowongan | ⏳ Siap dikerjakan |
| 12 | **Low** | Ganti placeholder eksternal (`placehold.co`) dengan asset lokal | ⏳ Siap dikerjakan |
