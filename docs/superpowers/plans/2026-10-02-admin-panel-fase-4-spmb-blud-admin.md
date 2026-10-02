# Admin Panel Multi-Role — Fase 4 (SPMB, BLUD, Admin & Settings) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun modul back-office Fase 4 yang mencakup:
1. **Modul SPMB (Panitia SPMB & Super Admin):** Review & verifikasi pendaftar Calon Siswa (status pendaftaran/verifikasi, filter jurusan/jalur/status, detail berkas storage `spmb/{nisn}/`), serta CRUD Pengumuman & FAQ SPMB yang di-wire ke halaman publik SPMB (`/spmb/pengumuman` & `/spmb/bantuan`).
2. **Modul BLUD (Super Admin):** Manajemen Produk BLUD (katalog list, toggle `is_published`, status filter) dan Moderasi BLUD (review & delete Komentar, Penawaran, Laporan per produk).
3. **Modul Pengguna (Super Admin Only):** Manajemen User (list, create user baru, edit nama/email/role/password opsional, delete dengan guard tidak bisa menghapus diri sendiri).
4. **Modul Pengaturan / Settings (Super Admin Only):** Pengaturan global (nama situs, kontak, alamat, email, telepon, WhatsApp, sosmed, deskripsi) menggunakan tabel key-value `settings` dan helper model `Setting::get('key', $default)` / `Setting::set('key', $value)`.

**Architecture:** 
- Controller SPMB ditempatkan pada `App\Http\Controllers\Admin\Spmb\` (`CalonSiswaController`, `PengumumanController`, `FaqController`).
- Controller BLUD ditempatkan pada `App\Http\Controllers\Admin\Blud\` (`ProdukBludController`, `ModerasiController`).
- Controller Admin/Sistem ditempatkan pada `App\Http\Controllers\Admin\` (`UserController`, `SettingController`).
- Route admin diamankan middleware `auth` dan role middleware:
  - SPMB: `role:spmb` (Super Admin auto-pass).
  - BLUD: `role:admin`.
  - User & Settings: `role:admin`.
- Menu navigasi sidebar diperbarui pada `App\Support\AdminMenu` dan ikon Lucide di `resources/views/admin/layout.blade.php`.

**Tech Stack:** Laravel 13, PHP 8.3+, Blade, Tailwind CSS v4, Lucide Icons (`mallardduck/blade-lucide-icons`), PHPUnit 12, Laravel Pint.

---

## File Structure Plan

| File | Tanggung Jawab / Peran |
|---|---|
| `database/migrations/2026_10_02_200001_add_status_verifikasi_to_calon_siswas_table.php` | Tambah kolom `status_verifikasi` (`enum('menunggu', 'terverifikasi', 'ditolak')` default `'menunggu'`) dan `catatan_verifikasi` (text nullable) |
| `database/migrations/2026_10_02_200002_create_pengumumans_table.php` | Tabel `pengumumans` (`id, judul, slug, konten, is_published, published_at, timestamps`) |
| `database/migrations/2026_10_02_200003_create_faqs_table.php` | Tabel `faqs` (`id, kategori, pertanyaan, jawaban, urutan, is_active, timestamps`) |
| `database/migrations/2026_10_02_200004_create_settings_table.php` | Tabel `settings` (`id, key, value, group, timestamps`) |
| `app/Models/CalonSiswa.php` | Update model `CalonSiswa` dengan casts & constants status verifikasi |
| `app/Models/Pengumuman.php` | Model `Pengumuman` dengan scope `published` |
| `app/Models/Faq.php` | Model `Faq` dengan scope `active` dan urutan |
| `app/Models/Setting.php` | Model `Setting` dengan method statis `get($key, $default = null)` dan `set($key, $value, $group = 'general')` |
| `database/seeders/PengumumanSeeder.php` | Seeder contoh pengumuman hasil seleksi / informasi SPMB |
| `database/seeders/FaqSeeder.php` | Seeder memindahkan data array statis `spmb/dashboard/bantuan.blade.php` ke DB |
| `database/seeders/SettingSeeder.php` | Seeder konfigurasi default sekolah (nama, alamat, telepon, medsos) |
| `database/seeders/DatabaseSeeder.php` | Registrasi seeder baru |
| `app/Support/AdminMenu.php` | Menambah menu item SPMB (Pengumuman, FAQ), BLUD (Produk, Moderasi), Sistem (Pengguna, Pengaturan) |
| `resources/views/admin/layout.blade.php` | Mapping ikon Lucide yang diperlukan (`megaphone`, `help-circle`, `shopping-bag`, `flag`, dll.) |
| `app/Http/Controllers/Admin/Spmb/CalonSiswaController.php` | Controller Index, Show, Review Dokumen, dan Verifikasi Status Calon Siswa |
| `resources/views/admin/spmb/calon-siswa/index.blade.php` | List pendaftar SPMB, filter status/jurusan/jalur, search NISN/nama, pagination |
| `resources/views/admin/spmb/calon-siswa/show.blade.php` | Detail profil siswa, berkas lampiran storage, form ubah status verifikasi |
| `app/Http/Requests/Admin/Spmb/StorePengumumanRequest.php` | Validasi create pengumuman |
| `app/Http/Requests/Admin/Spmb/UpdatePengumumanRequest.php` | Validasi edit pengumuman |
| `app/Http/Controllers/Admin/Spmb/PengumumanController.php` | Controller CRUD Pengumuman + toggle publish |
| `resources/views/admin/spmb/pengumuman/index.blade.php` | List pengumuman SPMB |
| `resources/views/admin/spmb/pengumuman/create.blade.php` | Form tambah pengumuman |
| `resources/views/admin/spmb/pengumuman/edit.blade.php` | Form edit pengumuman |
| `app/Http/Requests/Admin/Spmb/StoreFaqRequest.php` | Validasi create FAQ |
| `app/Http/Requests/Admin/Spmb/UpdateFaqRequest.php` | Validasi edit FAQ |
| `app/Http/Controllers/Admin/Spmb/FaqController.php` | Controller CRUD FAQ SPMB |
| `resources/views/admin/spmb/faq/index.blade.php` | List FAQ SPMB |
| `resources/views/admin/spmb/faq/create.blade.php` | Form tambah FAQ |
| `resources/views/admin/spmb/faq/edit.blade.php` | Form edit FAQ |
| `app/Http/Controllers/Admin/Blud/ProdukBludController.php` | Controller List produk BLUD, toggle is_published |
| `resources/views/admin/blud/produk/index.blade.php` | List produk BLUD + thumbnail + toggle publish status |
| `app/Http/Controllers/Admin/Blud/ModerasiController.php` | Controller review & delete komentar, penawaran, laporan |
| `resources/views/admin/blud/moderasi/index.blade.php` | Halaman tab moderasi: Komentar, Penawaran, Laporan |
| `app/Http/Requests/Admin/StoreUserRequest.php` | Validasi create user |
| `app/Http/Requests/Admin/UpdateUserRequest.php` | Validasi edit user |
| `app/Http/Controllers/Admin/UserController.php` | Controller CRUD Pengguna Admin & Staff |
| `resources/views/admin/users/index.blade.php` | List user & role badge |
| `resources/views/admin/users/create.blade.php` | Form buat user |
| `resources/views/admin/users/edit.blade.php` | Form edit user |
| `app/Http/Controllers/Admin/SettingController.php` | Controller Single Form edit & save site settings |
| `resources/views/admin/settings/edit.blade.php` | Form tabbed/grouped settings: Umum, Kontak, Medsos |
| `routes/admin.php` | Mendaftarkan routes SPMB, BLUD, User, dan Setting |
| `app/Http/Controllers/SpmbController.php` | Wire method `pengumuman()` dan `bantuan()` membaca dari DB |
| `resources/views/spmb/dashboard/pengumuman.blade.php` | Render daftar pengumuman published dari DB |
| `resources/views/spmb/dashboard/bantuan.blade.php` | Render FAQ dari DB |
| `tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php` | Test index, filter, show detail, update verifikasi calon siswa |
| `tests/Feature/Admin/Spmb/PengumumanCrudTest.php` | Test CRUD Pengumuman & toggle publish |
| `tests/Feature/Admin/Spmb/FaqCrudTest.php` | Test CRUD FAQ SPMB |
| `tests/Feature/Admin/Blud/ProdukBludAdminTest.php` | Test toggle publish produk BLUD & filter |
| `tests/Feature/Admin/Blud/ModerasiAdminTest.php` | Test list & delete komentar/penawaran/laporan BLUD |
| `tests/Feature/Admin/UserCrudTest.php` | Test CRUD User & self-delete guard |
| `tests/Feature/Admin/SettingTest.php` | Test update settings & helper Setting::get() |
| `tests/Feature/SpmbPublicWiringTest.php` | Test halaman publik SPMB pengumuman & bantuan membaca data DB |

---

## Task 1: Migrations & Models untuk Modul SPMB, BLUD, Settings

**Files:**
- Create: `database/migrations/2026_10_02_200001_add_status_verifikasi_to_calon_siswas_table.php`
- Create: `database/migrations/2026_10_02_200002_create_pengumumans_table.php`
- Create: `database/migrations/2026_10_02_200003_create_faqs_table.php`
- Create: `database/migrations/2026_10_02_200004_create_settings_table.php`
- Modify: `app/Models/CalonSiswa.php`
- Create: `app/Models/Pengumuman.php`
- Create: `app/Models/Faq.php`
- Create: `app/Models/Setting.php`
- Test: `tests/Feature/Admin/Fase4ModelMigrationTest.php`

- [x] **Step 1: Write test for Fase 4 migrations & models**
Buat test `tests/Feature/Admin/Fase4ModelMigrationTest.php` yang menguji pembuatan record `Pengumuman`, `Faq`, `Setting` (beserta method `Setting::get()` dan `Setting::set()`), serta kolom `status_verifikasi` pada `CalonSiswa`.

- [x] **Step 2: Run test to confirm failure**
Jalankan:
`php artisan test tests/Feature/Admin/Fase4ModelMigrationTest.php`
Verifikasi kegagalan karena tabel dan model belum tersedia.

- [x] **Step 3: Implement migrations**
  - `add_status_verifikasi_to_calon_siswas_table`: tambah `status_verifikasi` (enum: `'menunggu'`, `'terverifikasi'`, `'ditolak'`, default `'menunggu'`) dan `catatan_verifikasi` (text nullable).
  - `create_pengumumans_table`: `id`, `judul` (string), `slug` (string unique), `konten` (text), `is_published` (boolean default true), `published_at` (timestamp nullable), `timestamps`.
  - `create_faqs_table`: `id`, `kategori` (string default `'umum'`), `pertanyaan` (string), `jawaban` (text), `urutan` (integer default 0), `is_active` (boolean default true), `timestamps`.
  - `create_settings_table`: `id`, `key` (string unique), `value` (text nullable), `group` (string default `'general'`), `timestamps`.

- [x] **Step 4: Implement & update models**
  - Update `CalonSiswa`: tambahkan `status_verifikasi` dan `catatan_verifikasi` ke `$fillable`.
  - Buat `Pengumuman`: `$fillable = ['judul', 'slug', 'konten', 'is_published', 'published_at']`, casts `is_published => boolean`, `published_at => datetime`. Tambah scope `published()`.
  - Buat `Faq`: `$fillable = ['kategori', 'pertanyaan', 'jawaban', 'urutan', 'is_active']`, casts `is_active => boolean`, `urutan => integer`. Scope `active()`.
  - Buat `Setting`: `$fillable = ['key', 'value', 'group']`. Buat method statis `Setting::get(string $key, $default = null)` (dengan in-memory caching atau query langsung) dan `Setting::set(string $key, $value, string $group = 'general')`.

- [x] **Step 5: Run migration test and verify passing**
Jalankan:
`php artisan test tests/Feature/Admin/Fase4ModelMigrationTest.php`
Pastikan 100% test lulus.

---

## Task 2: Seeders & Wiring Data Publik SPMB

**Files:**
- Create: `database/seeders/PengumumanSeeder.php`
- Create: `database/seeders/FaqSeeder.php`
- Create: `database/seeders/SettingSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Modify: `app/Http/Controllers/SpmbController.php`
- Modify: `resources/views/spmb/dashboard/pengumuman.blade.php`
- Modify: `resources/views/spmb/dashboard/bantuan.blade.php`
- Test: `tests/Feature/SpmbPublicWiringTest.php`

- [x] **Step 1: Write test for SPMB public wiring**
Buat test `tests/Feature/SpmbPublicWiringTest.php` yang menguji route `/spmb/pengumuman` menampilkan pengumuman dari database, dan `/spmb/bantuan` menampilkan list FAQ dari database (bukan array hardcoded).

- [x] **Step 2: Run test to confirm failure**
Jalankan:
`php artisan test tests/Feature/SpmbPublicWiringTest.php`

- [x] **Step 3: Implement seeders**
  - `PengumumanSeeder`: buat minimal 2 pengumuman awal SPMB.
  - `FaqSeeder`: migrasikan 4 pertanyaan FAQ dari `spmb/dashboard/bantuan.blade.php` ke database.
  - `SettingSeeder`: seed default keys: `site_name`, `site_tagline`, `school_address`, `school_phone`, `school_email`, `school_whatsapp`, `social_instagram`, `social_youtube`, `social_facebook`, `spmb_contact_email`, `spmb_contact_phone`, `spmb_service_hours`.
  - Daftarkan ke `DatabaseSeeder.php`.

- [x] **Step 4: Update SpmbController & views**
  - Di `SpmbController@pengumuman`: query `Pengumuman::published()->latest()->get()`, kirim ke view `spmb.dashboard.pengumuman`.
  - Di `spmb/dashboard/pengumuman.blade.php`: jika ada pengumuman, render daftar card pengumuman dengan tanggal dan konten; jika kosong, fallback ke state kosong yang sudah ada.
  - Di `SpmbController@bantuan`: query `Faq::active()->orderBy('urutan')->get()`, serta ambil kontak bantuan dari `Setting::get(...)` (dengan fallback default).
  - Di `spmb/dashboard/bantuan.blade.php`: looping `$faq` dari controller, hapus array inline PHP.

- [x] **Step 5: Run test and verify passing**
Jalankan:
`php artisan test tests/Feature/SpmbPublicWiringTest.php`
Pastikan lulus.

---

## Task 3: Modul Admin SPMB (Calon Siswa, Pengumuman, FAQ)

**Files:**
- Create: `app/Http/Controllers/Admin/Spmb/CalonSiswaController.php`
- Create: `resources/views/admin/spmb/calon-siswa/index.blade.php`
- Create: `resources/views/admin/spmb/calon-siswa/show.blade.php`
- Create: `app/Http/Requests/Admin/Spmb/StorePengumumanRequest.php`
- Create: `app/Http/Requests/Admin/Spmb/UpdatePengumumanRequest.php`
- Create: `app/Http/Controllers/Admin/Spmb/PengumumanController.php`
- Create: `resources/views/admin/spmb/pengumuman/index.blade.php`
- Create: `resources/views/admin/spmb/pengumuman/create.blade.php`
- Create: `resources/views/admin/spmb/pengumuman/edit.blade.php`
- Create: `app/Http/Requests/Admin/Spmb/StoreFaqRequest.php`
- Create: `app/Http/Requests/Admin/Spmb/UpdateFaqRequest.php`
- Create: `app/Http/Controllers/Admin/Spmb/FaqController.php`
- Create: `resources/views/admin/spmb/faq/index.blade.php`
- Create: `resources/views/admin/spmb/faq/create.blade.php`
- Create: `resources/views/admin/spmb/faq/edit.blade.php`
- Modify: `app/Support/AdminMenu.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php`
- Test: `tests/Feature/Admin/Spmb/PengumumanCrudTest.php`
- Test: `tests/Feature/Admin/Spmb/FaqCrudTest.php`

- [x] **Step 1: Write feature tests for SPMB admin modules**
  - `CalonSiswaAdminTest`: login sebagai panitia SPMB & admin, index dengan filter jalur/jurusan/status & search NISN, show detail siswa + cek berkas file di `storage/app/public/spmb/{nisn}/`, update status verifikasi (`menunggu` -> `terverifikasi`/`ditolak` + catatan). Pastikan role lain (BKK/Humas) diblokir 403.
  - `PengumumanCrudTest`: test create, edit, update, delete, dan toggle publish pengumuman SPMB.
  - `FaqCrudTest`: test CRUD FAQ SPMB.

- [x] **Step 2: Run test to confirm failure**
Jalankan:
`php artisan test tests/Feature/Admin/Spmb/`

- [x] **Step 3: Implement CalonSiswaController & Views**
  - `index`: paginate(15), filter `status_verifikasi`, `jurusan_pilihan`, `jalur_pendaftaran`, dan search query (`nama_lengkap` atau `nisn`).
  - `show`: detail biodata, data orang tua, pilihan jurusan, serta inspeksi berkas yang tersimpan di disk `public` pada folder `spmb/{nisn}/` (misal Akta, KK, Ijazah).
  - `updateVerifikasi`: validasi `status_verifikasi` in: `menunggu,terverifikasi,ditolak` dan `catatan_verifikasi` string nullable.
  - Buat view `index.blade.php` dan `show.blade.php` dengan UI table, badge status, modal/box catatan verifikasi, dan link preview berkas dokumen jika ada.

- [x] **Step 4: Implement PengumumanController & Views**
  - FormRequest: `judul` (required, max 255), `konten` (required), `is_published` (boolean). Auto generate slug dari judul (handle collision).
  - Controller standard CRUD + action `togglePublish`.
  - Views create, edit, index.

- [x] **Step 5: Implement FaqController & Views**
  - FormRequest: `pertanyaan` (required), `jawaban` (required), `kategori` (nullable), `urutan` (integer), `is_active` (boolean).
  - Controller standard CRUD.
  - Views create, edit, index.

- [x] **Step 6: Register SPMB routes & menu**
  - Di `routes/admin.php`, tambahkan group `middleware('role:spmb')`:
    - `calon-siswa`: index, show, patch `calon-siswa/{calonSiswa}/verifikasi`.
    - `pengumuman`: resource + patch toggle-publish.
    - `faq`: resource.
  - Di `AdminMenu.php`: sesuaikan menu SPMB agar mencakup Calon Siswa, Pengumuman SPMB, FAQ SPMB untuk role `admin` dan `spmb`.

- [x] **Step 7: Run SPMB tests & verify passing**
Jalankan:
`php artisan test tests/Feature/Admin/Spmb/`

---

## Task 4: Modul Admin BLUD (Produk & Moderasi)

**Files:**
- Create: `app/Http/Controllers/Admin/Blud/ProdukBludController.php`
- Create: `resources/views/admin/blud/produk/index.blade.php`
- Create: `app/Http/Controllers/Admin/Blud/ModerasiController.php`
- Create: `resources/views/admin/blud/moderasi/index.blade.php`
- Modify: `app/Support/AdminMenu.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Blud/ProdukBludAdminTest.php`
- Test: `tests/Feature/Admin/Blud/ModerasiAdminTest.php`

- [x] **Step 1: Write feature tests for BLUD admin modules**
  - `ProdukBludAdminTest`: Super Admin can access index, search produk by title/jurusan, toggle `is_published`. Non-admin role blocked (403).
  - `ModerasiAdminTest`: Super Admin can view list komentar, list penawaran, list laporan, and delete each item by ID. Non-admin blocked.

- [x] **Step 2: Run test to confirm failure**
Jalankan:
`php artisan test tests/Feature/Admin/Blud/`

- [x] **Step 3: Implement ProdukBludController & Views**
  - `index`: filter tipe (`showcase` / `kustom`), jurusan, status publish, search nama produk. Paginate 15.
  - `togglePublish`: toggle field `is_published` pada model `ProdukBlud`.
  - View `admin/blud/produk/index.blade.php`: list card/tabel lengkap dengan badge harga, jurusan, foto galeri utama, dan tombol aksi toggle publish.

- [x] **Step 4: Implement ModerasiController & Views**
  - Method `index(Request $request)`: tab filter (`tab=komentar|penawaran|laporan`). Query data terkait beserta relasi `produk`.
  - Method `destroyKomentar($id)`: hapus `ProdukBludKomentar`.
  - Method `destroyPenawaran($id)`: hapus `ProdukBludPenawaran`.
  - Method `destroyLaporan($id)`: hapus `ProdukBludLaporkan`.
  - View `admin/blud/moderasi/index.blade.php`: tab bar navigasi (Komentar, Penawaran, Laporan Pelanggaran), tabel interaktif dengan konfirmasi hapus native `confirm()`.

- [x] **Step 5: Register BLUD routes & menu**
  - Di `routes/admin.php`, daftarkan di group `middleware('role:admin')`:
    - `produk-blud`: index, patch `toggle-publish`.
    - `moderasi-blud`: index, delete komentar, penawaran, laporan.
  - Daftarkan menu "Produk BLUD" & "Moderasi BLUD" di `AdminMenu.php` dalam grup "BLUD" untuk role `admin`.

- [x] **Step 6: Run BLUD tests & verify passing**
Jalankan:
`php artisan test tests/Feature/Admin/Blud/`

---

## Task 5: Modul Manajemen Pengguna (Users)

**Files:**
- Create: `app/Http/Requests/Admin/StoreUserRequest.php`
- Create: `app/Http/Requests/Admin/UpdateUserRequest.php`
- Create: `app/Http/Controllers/Admin/UserController.php`
- Create: `resources/views/admin/users/index.blade.php`
- Create: `resources/views/admin/users/create.blade.php`
- Create: `resources/views/admin/users/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/UserCrudTest.php`

- [x] **Step 1: Write feature tests for User management**
  - Test `tests/Feature/Admin/UserCrudTest.php`:
    - Admin can view user list, search by name/email, filter by role.
    - Admin can create new user with role select (`admin, bkk, humas, spmb`).
    - Admin can update existing user (name, email, role, optional new password).
    - Admin can delete other user.
    - **Self-delete guard**: Admin cannot delete their own account (returns 403 or redirect back with error message).
    - Non-admin (BKK, Humas, SPMB) cannot access `/admin/users` (403 Forbidden).

- [x] **Step 2: Run test to confirm failure**
Jalankan:
`php artisan test tests/Feature/Admin/UserCrudTest.php`

- [x] **Step 3: Implement Form Requests & Controller**
  - `StoreUserRequest`: `name` (required, max 255), `email` (required, email, unique:users), `password` (required, min 8), `role` (required, in:admin,bkk,humas,spmb).
  - `UpdateUserRequest`: `name` (required), `email` (required, unique:users,email,{id}), `password` (nullable, min 8), `role` (required, in:admin,bkk,humas,spmb).
  - `UserController`:
    - `index`: filter role, search name/email, paginate(15).
    - `create` & `store`: create user dengan `Hash::make($password)`.
    - `edit` & `update`: update info user, hash password baru jika diisi.
    - `destroy`: abort 403 jika `$user->id === auth()->id()`. Hapus record dan redirect dengan notice flash.

- [x] **Step 4: Implement Views**
  - `index.blade.php`: table user, badge warna per role (misal: Super Admin red/navy, BKK blue, Humas purple, SPMB green), tombol edit & hapus (disable/hide pada baris akun yang sedang login).
  - `create.blade.php`: form tambah user lengkap dengan input nama, email, password, dan dropdown pilihan peran.
  - `edit.blade.php`: form edit user dengan info bantuan "Kosongkan kata sandi jika tidak ingin mengubah".

- [x] **Step 5: Register User routes in admin.php**
  - Pastikan route `resource('users', UserController::class)` terpasang di dalam group `middleware('role:admin')`.

- [x] **Step 6: Run User CRUD test and verify passing**
Jalankan:
`php artisan test tests/Feature/Admin/UserCrudTest.php`

---

## Task 6: Modul Pengaturan Situs (Settings) & Dashboard Stats Enrichment

**Files:**
- Create: `app/Http/Controllers/Admin/SettingController.php`
- Create: `resources/views/admin/settings/edit.blade.php`
- Modify: `app/Http/Controllers/Admin/DashboardController.php`
- Modify: `resources/views/admin/dashboard.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/SettingTest.php`
- Test: `tests/Feature/Admin/DashboardTest.php`

- [x] **Step 1: Write feature tests for Setting & enriched Dashboard**
  - `SettingTest`: Admin can load `/admin/settings`, submit updated setting values (kontak, alamat, sosmed), verify database updated, verify `Setting::get('school_phone')` returns new value. Non-admin blocked (403).
  - `DashboardTest`: Verifikasi card statistik SPMB (total pendaftar, pendaftar menunggu verifikasi), BLUD (total produk, komentar belum ditinjau), dan User (total admin & staff).

- [x] **Step 2: Run test to confirm failure**
Jalankan:
`php artisan test tests/Feature/Admin/SettingTest.php`

- [x] **Step 3: Implement SettingController & View**
  - `SettingController@edit`: ambil semua key-value settings, kelompokkan per grup (`umum`, `kontak`, `sosmed`, `spmb`).
  - `SettingController@update`: loop request validated fields, simpan via `Setting::set($key, $value)`. Flash success message.
  - View `resources/views/admin/settings/edit.blade.php`: form bersih terbagi dalam tabs/section:
    - Informasi Sekolah: Nama situs, slogan/tagline, alamat lengkap.
    - Kontak & Jam Layanan: Email umum, No. Telepon, WhatsApp, Jam operasional.
    - Media Sosial: Instagram, YouTube, Facebook, TikTok.
    - Kontak Khusus SPMB: Email & No. HP panitia.

- [x] **Step 4: Update Dashboard stats**
  - Di `DashboardController`:
    - Tambah card untuk role SPMB: "Menunggu Verifikasi" (`CalonSiswa::where('status_verifikasi', 'menunggu')->count()`).
    - Tambah card untuk role Admin: "Total Pengguna" (`User::count()`), "Produk BLUD" (`ProdukBlud::count()`), "Laporan BLUD" (`ProdukBludLaporkan::count()`).
  - Di `resources/views/admin/dashboard.blade.php`: dukung icon baru dan pastikan render card dinamis sesuai scope user.

- [x] **Step 5: Run tests & verify passing**
Jalankan:
`php artisan test tests/Feature/Admin/SettingTest.php`
`php artisan test tests/Feature/Admin/DashboardTest.php`

---

## Task 7: Layout Polish, Sidebar Icons, & Code Quality (Pint)

**Files:**
- Modify: `app/Support/AdminMenu.php`
- Modify: `resources/views/admin/layout.blade.php`
- Run: `php vendor/bin/pint`
- Run: `php artisan test`

- [x] **Step 1: Verify all sidebar items and icons**
  - Periksa `AdminMenu.php` memastikan setiap item (Calon Siswa, Pengumuman, FAQ, Produk BLUD, Moderasi BLUD, Pengguna, Pengaturan) memiliki route dan icon terdaftar.
  - Periksa `resources/views/admin/layout.blade.php` agar switch icon mencakup semua icon yang digunakan (`megaphone`, `help-circle`, `shopping-bag`, `flag`, `shield`, `settings`, dll.).

- [x] **Step 2: Run code styling linter (Pint)**
Jalankan:
`php vendor/bin/pint --dirty`
atau:
`php vendor/bin/pint`
Pastikan PSR-12 dan aturan Laravel Pint 100% clean tanpa error formatting.

- [x] **Step 3: Run full test suite regression**
Jalankan:
`php artisan test`
Pastikan seluruh test (Fase 1, Fase 2, Fase 3, dan Fase 4) berstatus PASS (hijau).

---

## Execution Checklist & Boundaries

- **No Spatie / No Heavy Packages**: Gunakan controller native Blade, FormRequest, dan role enum yang sudah ada.
- **Self-contained Auth & Roles**: `admin` dapat mengakses semua modul; `spmb` hanya dapat mengakses modul SPMB dan dashboard terkait.
- **Responsive & Consistent UI**: Warna navbar, sidebar `#1e3a5f`, card putih `slate-50`, konfirmasi hapus via native browser `confirm()`.
- **Zero Raw Error Leakage**: Gunakan validasi FormRequest terstruktur dengan pesan Bahasa Indonesia yang informatif.
