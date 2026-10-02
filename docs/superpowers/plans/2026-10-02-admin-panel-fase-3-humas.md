# Admin Panel Multi-Role — Fase 3 (Humas) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun modul back-office untuk peran Humas (Profil Sekolah & Konten Publikasi): Manajemen Guru & Tendik (CRUD + foto + kategori + active toggle), Struktur Organisasi (CRUD + foto + kategori), Sarana Prasarana / Fasilitas (CRUD + foto/ikon + kategori), Artikel (CRUD + image upload + reading time), dan Webinar (CRUD + toggle publish), serta menggantikan seluruh inline array data pada halaman publik dengan query database Eloquent.

**Architecture:** Modul admin Humas ditempatkan pada namespace `App\Http\Controllers\Admin\Humas\` dengan views di `resources/views/admin/humas/`. Hak akses diamankan via middleware `auth` dan `role:humas` (Super Admin otomatis memiliki akses penuh). Upload berkas menggunakan shared trait `HandlesUploads` ke storage `public`. Data input divalidasi dengan FormRequest terisolasi. Menu navigasi sidebar diperbarui di `AdminMenu` dan ikon di `resources/views/admin/layout.blade.php`.

**Tech Stack:** Laravel 13, PHP 8.3+, Blade, Tailwind CSS v4, Lucide Icons (`mallardduck/blade-lucide-icons`), PHPUnit 12, Laravel Pint.

---

## File Structure Plan

| File | Tanggung Jawab / Peran |
|---|---|
| `database/migrations/2026_10_02_100001_create_gurus_table.php` | Tabel `gurus` (`nama, jabatan, mapel, kategori[guru|tendik], foto_path, urutan, warna, is_active`) |
| `database/migrations/2026_10_02_100002_create_struktur_organisasis_table.php` | Tabel `struktur_organisasis` (`nama, jabatan, nip, bidang, deskripsi, kategori[wakil|bagian], icon, foto_path, urutan`) |
| `database/migrations/2026_10_02_100003_create_fasilitas_table.php` | Tabel `fasilitas` (`nama, kategori[pembelajaran|pendukung], deskripsi, jumlah, icon, image_path, urutan`) |
| `database/migrations/2026_10_02_100004_add_image_path_to_artikels_table.php` | Tambah kolom `image_path` pada tabel `artikels` |
| `app/Models/Guru.php` | Model Guru & Tendik dengan helper foto fallback inisial |
| `app/Models/StrukturOrganisasi.php` | Model Struktur Organisasi dengan scopes per kategori |
| `app/Models/Fasilitas.php` | Model Sarana Prasarana / Fasilitas sekolah |
| `app/Models/Artikel.php` | Update model `Artikel` dengan fillable `image_path` dan accessor `featured_image` |
| `app/Models/Webinar.php` | Model Webinar dengan scope published |
| `database/seeders/GuruSeeder.php` | Seeder data awal guru dan tendik dari inline array sebelumnya |
| `database/seeders/StrukturOrganisasiSeeder.php` | Seeder wakil kepala sekolah dan bagian & unit kerja |
| `database/seeders/FasilitasSeeder.php` | Seeder fasilitas pembelajaran & fasilitas pendukung |
| `database/seeders/DatabaseSeeder.php` | Mendaftarkan ketiga seeder baru ke seeder utama |
| `app/Support/AdminMenu.php` | Menambah menu Humas: Guru & Tendik, Struktur Organisasi, Sarana Prasarana, Artikel, Webinar |
| `resources/views/admin/layout.blade.php` | Pastikan icon Lucide untuk menu humas terpetakan (`users`, `network`/`sitemap`, `building`, `newspaper`, `video`) |
| `app/Http/Requests/Admin/Humas/StoreGuruRequest.php` | Validasi create guru / tendik |
| `app/Http/Requests/Admin/Humas/UpdateGuruRequest.php` | Validasi edit guru / tendik |
| `app/Http/Controllers/Admin/Humas/GuruController.php` | Controller CRUD Guru & Tendik, toggle aktif |
| `resources/views/admin/humas/guru/index.blade.php` | List guru & tendik, filter kategori, search, status badge |
| `resources/views/admin/humas/guru/create.blade.php` | Form tambah guru / tendik |
| `resources/views/admin/humas/guru/edit.blade.php` | Form edit guru / tendik |
| `app/Http/Requests/Admin/Humas/StoreStrukturOrganisasiRequest.php` | Validasi create struktur organisasi |
| `app/Http/Requests/Admin/Humas/UpdateStrukturOrganisasiRequest.php` | Validasi edit struktur organisasi |
| `app/Http/Controllers/Admin/Humas/StrukturOrganisasiController.php` | Controller CRUD pimpinan wakil & unit kerja |
| `resources/views/admin/humas/struktur/index.blade.php` | List struktur organisasi per kategori, urutan |
| `resources/views/admin/humas/struktur/create.blade.php` | Form tambah entri struktur |
| `resources/views/admin/humas/struktur/edit.blade.php` | Form edit entri struktur |
| `app/Http/Requests/Admin/Humas/StoreFasilitasRequest.php` | Validasi create fasilitas |
| `app/Http/Requests/Admin/Humas/UpdateFasilitasRequest.php` | Validasi edit fasilitas |
| `app/Http/Controllers/Admin/Humas/FasilitasController.php` | Controller CRUD Sarana Prasarana |
| `resources/views/admin/humas/fasilitas/index.blade.php` | List sarana prasarana, filter kategori, search |
| `resources/views/admin/humas/fasilitas/create.blade.php` | Form tambah fasilitas |
| `resources/views/admin/humas/fasilitas/edit.blade.php` | Form edit fasilitas |
| `app/Http/Requests/Admin/Humas/StoreArtikelRequest.php` | Validasi create artikel |
| `app/Http/Requests/Admin/Humas/UpdateArtikelRequest.php` | Validasi edit artikel |
| `app/Http/Controllers/Admin/Humas/ArtikelController.php` | Controller CRUD Artikel + upload gambar utama |
| `resources/views/admin/humas/artikel/index.blade.php` | List artikel sekolah, kategori, search, pagination |
| `resources/views/admin/humas/artikel/create.blade.php` | Form buat artikel baru |
| `resources/views/admin/humas/artikel/edit.blade.php` | Form edit artikel |
| `app/Http/Requests/Admin/Humas/StoreWebinarRequest.php` | Validasi create webinar |
| `app/Http/Requests/Admin/Humas/UpdateWebinarRequest.php` | Validasi edit webinar |
| `app/Http/Controllers/Admin/Humas/WebinarController.php` | Controller CRUD Webinar + toggle publish |
| `resources/views/admin/humas/webinar/index.blade.php` | List webinar, status publish, search |
| `resources/views/admin/humas/webinar/create.blade.php` | Form tambah webinar baru |
| `resources/views/admin/humas/webinar/edit.blade.php` | Form edit webinar |
| `routes/admin.php` | Route resources untuk modul Humas (`role:humas`) |
| `routes/web.php` | Wiring route publik (`/guru-dan-tenaga-kependidikan`, `/struktur-organisasi`, `/sarana-dan-prasarana`) mengirim query Eloquent ke view |
| `resources/views/guru-dan-tenaga-kependidikan.blade.php` | Menghapus hardcoded array, render loop `$gurus` dan `$tendiks` |
| `resources/views/struktur-organisasi.blade.php` | Menghapus hardcoded array, render loop `$wakil` dan `$bagian` |
| `resources/views/sarana-dan-prasarana.blade.php` | Menghapus hardcoded array, render loop `$fasilitasPembelajaran` dan `$fasilitasPendukung` |
| `resources/views/pusat-karir/artikel.blade.php` & `detail-artikel.blade.php` | Support render `image_path` (storage public) selain `image_url` |
| `tests/Feature/Admin/Humas/GuruCrudTest.php` | Feature test CRUD Guru & Tendik |
| `tests/Feature/Admin/Humas/StrukturOrganisasiCrudTest.php` | Feature test CRUD Struktur Organisasi |
| `tests/Feature/Admin/Humas/FasilitasCrudTest.php` | Feature test CRUD Sarana & Prasarana |
| `tests/Feature/Admin/Humas/ArtikelCrudTest.php` | Feature test CRUD Artikel & file upload |
| `tests/Feature/Admin/Humas/WebinarCrudTest.php` | Feature test CRUD Webinar & toggle publish |
| `tests/Feature/PublicPagesWiringTest.php` | Feature test verifikasi integrasi DB ke 3 halaman profil publik |

---

## Task 1: Migrations & Models untuk Modul Humas

**Files:**
- Create: `database/migrations/2026_10_02_100001_create_gurus_table.php`
- Create: `database/migrations/2026_10_02_100002_create_struktur_organisasis_table.php`
- Create: `database/migrations/2026_10_02_100003_create_fasilitas_table.php`
- Create: `database/migrations/2026_10_02_100004_add_image_path_to_artikels_table.php`
- Create: `app/Models/Guru.php`
- Create: `app/Models/StrukturOrganisasi.php`
- Create: `app/Models/Fasilitas.php`
- Modify: `app/Models/Artikel.php`
- Test: `tests/Feature/Admin/Humas/HumasModelMigrationTest.php`

- [ ] **Step 1: Write test for Humas migrations and models**
Buat `tests/Feature/Admin/Humas/HumasModelMigrationTest.php` yang menguji pembuatan record `Guru`, `StrukturOrganisasi`, `Fasilitas`, dan penambahan `image_path` pada `Artikel`.

- [ ] **Step 2: Run test to confirm failure**
Jalankan `php artisan test tests/Feature/Admin/Humas/HumasModelMigrationTest.php` (harus fail karena tabel/model belum ada).

- [ ] **Step 3: Implement migrations**
  - Migration `create_gurus_table`: `id`, `nama`, `jabatan`, `mapel` (nullable), `kategori` (enum: 'guru', 'tendik'), `foto_path` (nullable), `warna` (nullable, e.g. 'from-blue-500 to-blue-700'), `urutan` (integer default 0), `is_active` (boolean default true), `timestamps`.
  - Migration `create_struktur_organisasis_table`: `id`, `nama`, `jabatan` (nullable), `nip` (nullable), `bidang` (nullable), `deskripsi` (text nullable), `kategori` (enum: 'wakil', 'bagian'), `icon` (string nullable), `foto_path` (nullable), `urutan` (integer default 0), `timestamps`.
  - Migration `create_fasilitas_table`: `id`, `nama`, `kategori` (enum: 'pembelajaran', 'pendukung'), `deskripsi` (text), `jumlah` (string nullable), `icon` (string nullable), `image_path` (nullable), `urutan` (integer default 0), `timestamps`.
  - Migration `add_image_path_to_artikels_table`: menambah `image_path` (string nullable) setelah `image_url`.

- [ ] **Step 4: Implement Eloquent Models**
  - `Guru`: `$fillable = ['nama', 'jabatan', 'mapel', 'kategori', 'foto_path', 'warna', 'urutan', 'is_active']`, `casts()`: `'is_active' => 'boolean', 'urutan' => 'integer'`. Tambahkan helper accessor `foto_url`.
  - `StrukturOrganisasi`: `$fillable = ['nama', 'jabatan', 'nip', 'bidang', 'deskripsi', 'kategori', 'icon', 'foto_path', 'urutan']`, `casts()`: `'urutan' => 'integer'`.
  - `Fasilitas`: `$fillable = ['nama', 'kategori', 'deskripsi', 'jumlah', 'icon', 'image_path', 'urutan']`, `casts()`: `'urutan' => 'integer'`.
  - `Artikel`: tambahkan `'image_path'` pada `$fillable`. Tambahkan accessor helper `getDisplayImageAttribute()` yang mengembalikan `image_path ? Storage::disk('public')->url($image_path) : $image_url`.

- [ ] **Step 5: Run migration & verify test passes**
Jalankan `php artisan migrate` dan `php artisan test tests/Feature/Admin/Humas/HumasModelMigrationTest.php`.

---

## Task 2: Seeders & Public Pages Wiring (Guru, Struktur, Sarana Prasarana)

**Files:**
- Create: `database/seeders/GuruSeeder.php`
- Create: `database/seeders/StrukturOrganisasiSeeder.php`
- Create: `database/seeders/FasilitasSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`
- Modify: `routes/web.php`
- Modify: `resources/views/guru-dan-tenaga-kependidikan.blade.php`
- Modify: `resources/views/struktur-organisasi.blade.php`
- Modify: `resources/views/sarana-dan-prasarana.blade.php`
- Test: `tests/Feature/PublicPagesWiringTest.php`

- [ ] **Step 1: Write test for public pages wiring**
Buat `tests/Feature/PublicPagesWiringTest.php` yang memverifikasi bahwa:
  - `GET /guru-dan-tenaga-kependidikan` merender guru dan tendik dari database.
  - `GET /struktur-organisasi` merender pimpinan wakil kepala dan bagian/unit dari database.
  - `GET /sarana-dan-prasarana` merender fasilitas pembelajaran dan pendukung dari database.

- [ ] **Step 2: Create Seeders matching existing site data**
  - `GuruSeeder`: Memasukkan 12 guru dan 8 tendik yang sebelumnya ada di array Blade `guru-dan-tenaga-kependidikan.blade.php`.
  - `StrukturOrganisasiSeeder`: Memasukkan 4 wakil kepala sekolah dan 6 unit bagian yang sebelumnya di array `struktur-organisasi.blade.php`.
  - `FasilitasSeeder`: Memasukkan 6 fasilitas pembelajaran dan fasilitas pendukung yang sebelumnya di array `sarana-dan-prasarana.blade.php`.
  - Daftarkan di `DatabaseSeeder.php`.

- [ ] **Step 3: Update `routes/web.php`**
Kirimkan query Eloquent terurut ke view:
  ```php
  Route::get('/guru-dan-tenaga-kependidikan', function () {
      $guru = \App\Models\Guru::where('kategori', 'guru')->where('is_active', true)->orderBy('urutan')->get();
      $tendik = \App\Models\Guru::where('kategori', 'tendik')->where('is_active', true)->orderBy('urutan')->get();
      return view('guru-dan-tenaga-kependidikan', compact('guru', 'tendik'));
  })->name('guru-dan-tenaga-kependidikan');

  Route::get('/struktur-organisasi', function () {
      $wakil = \App\Models\StrukturOrganisasi::where('kategori', 'wakil')->orderBy('urutan')->get();
      $bagian = \App\Models\StrukturOrganisasi::where('kategori', 'bagian')->orderBy('urutan')->get();
      return view('struktur-organisasi', compact('wakil', 'bagian'));
  })->name('struktur-organisasi');

  Route::get('/sarana-dan-prasarana', function () {
      $fasilitasPembelajaran = \App\Models\Fasilitas::where('kategori', 'pembelajaran')->orderBy('urutan')->get();
      $fasilitasPendukung = \App\Models\Fasilitas::where('kategori', 'pendukung')->orderBy('urutan')->get();
      return view('sarana-dan-prasarana', compact('fasilitasPembelajaran', 'fasilitasPendukung'));
  })->name('sarana-dan-prasarana');
  ```

- [ ] **Step 4: Update Blade Views to remove hardcoded arrays**
  - `guru-dan-tenaga-kependidikan.blade.php`: Hapus `@php $guru = [...]; @endphp` dan `@php $tendik = [...]; @endphp`. Loop `$guru` dan `$tendik` dari controller. Dukung tampilan foto dari upload jika ada (`$item->foto_url ?? avatar inisial`).
  - `struktur-organisasi.blade.php`: Hapus hardcoded `$wakil` dan `$bagian`. Render objek dari DB.
  - `sarana-dan-prasarana.blade.php`: Hapus hardcoded `$fasilitasPembelajaran` dan `$fasilitasPendukung`. Render objek dari DB.

- [ ] **Step 5: Run tests & seeder**
Jalankan `php artisan db:seed --class=GuruSeeder`, dst. dan pastikan `PublicPagesWiringTest` lulus 100%.

---

## Task 3: Modul Guru & Tendik Admin (CRUD + Upload Foto)

**Files:**
- Create: `app/Http/Requests/Admin/Humas/StoreGuruRequest.php`
- Create: `app/Http/Requests/Admin/Humas/UpdateGuruRequest.php`
- Create: `app/Http/Controllers/Admin/Humas/GuruController.php`
- Create: `resources/views/admin/humas/guru/index.blade.php`
- Create: `resources/views/admin/humas/guru/create.blade.php`
- Create: `resources/views/admin/humas/guru/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Humas/GuruCrudTest.php`

- [ ] **Step 1: Write failing feature test `GuruCrudTest`**
Uji otentikasi role Humas & Admin (role BKK/SPMB dilarang 403), listing dengan filter kategori & search, form store dengan file upload foto, update, toggle active, dan destroy.

- [ ] **Step 2: Create FormRequests**
  - `StoreGuruRequest`: `nama` (required, max 255), `jabatan` (required, max 255), `mapel` (nullable, max 255), `kategori` (required, in:guru,tendik), `urutan` (nullable, integer), `is_active` (boolean), `foto` (nullable, image, mimes:jpeg,png,webp, max:2048).
  - `UpdateGuruRequest`: aturan serupa dengan `StoreGuruRequest`.

- [ ] **Step 3: Implement `GuruController`**
Gunakan `HandlesUploads` trait untuk mengunggah `foto` ke direktori `guru/`. Implementasikan:
  - `index(Request $request)`: paginate dengan pencarian nama/jabatan dan filter `kategori`.
  - `create()`, `store(StoreGuruRequest $request)`
  - `edit(Guru $guru)`, `update(UpdateGuruRequest $request, Guru $guru)`
  - `destroy(Guru $guru)`: hapus file foto dari disk jika ada, lalu hapus record.
  - `toggleActive(Guru $guru)`: toggle status `is_active`.

- [ ] **Step 4: Create Admin Views (index, create, edit)**
Gunakan konsistensi tema Navy/Slate:
  - `index.blade.php`: Header breadcrumb, tombol tambah, filter tab/dropdown (Semua, Guru, Tendik), search input, tabel rapi dengan avatar/foto, badge aktif/non-aktif, action edit/delete/toggle.
  - `create.blade.php` & `edit.blade.php`: Form layout clean, input foto dengan preview/info, select kategori, input urutan, checkbox aktif.

- [ ] **Step 5: Register routes & run tests**
Daftarkan `Route::resource('guru', GuruController::class);` dan `Route::patch('guru/{guru}/toggle-active', [GuruController::class, 'toggleActive'])->name('guru.toggle-active');` di dalam grup `role:humas` di `routes/admin.php`. Jalankan test dan pastikan hijau.

---

## Task 4: Modul Struktur Organisasi Admin (CRUD)

**Files:**
- Create: `app/Http/Requests/Admin/Humas/StoreStrukturOrganisasiRequest.php`
- Create: `app/Http/Requests/Admin/Humas/UpdateStrukturOrganisasiRequest.php`
- Create: `app/Http/Controllers/Admin/Humas/StrukturOrganisasiController.php`
- Create: `resources/views/admin/humas/struktur/index.blade.php`
- Create: `resources/views/admin/humas/struktur/create.blade.php`
- Create: `resources/views/admin/humas/struktur/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Humas/StrukturOrganisasiCrudTest.php`

- [ ] **Step 1: Write failing feature test `StrukturOrganisasiCrudTest`**
Uji otentikasi role, store pimpinan wakil (dengan nip & bidang) serta bagian/unit (dengan deskripsi & icon), edit, dan delete.

- [ ] **Step 2: Create FormRequests**
Validasi field: `nama`, `kategori` (in:wakil,bagian), `jabatan` (nullable), `nip` (nullable), `bidang` (nullable), `deskripsi` (nullable), `icon` (nullable), `urutan` (integer), `foto` (image, max 2MB).

- [ ] **Step 3: Implement `StrukturOrganisasiController`**
CRUD controller dengan integrasi upload foto (folder `struktur/`).

- [ ] **Step 4: Create Views**
  - `index.blade.php`: Menampilkan tabel pimpinan dan bagian unit dengan toggle tab atau grup jelas.
  - `create.blade.php` & `edit.blade.php`: Form adaptif (menyesuaikan bidang input berdasarkan pilihan kategori wakil vs bagian).

- [ ] **Step 5: Register routes & run tests**
Tambahkan `Route::resource('struktur-organisasi', StrukturOrganisasiController::class);` di `routes/admin.php`. Jalankan test sampai lolos.

---

## Task 5: Modul Sarana Prasarana / Fasilitas Admin (CRUD)

**Files:**
- Create: `app/Http/Requests/Admin/Humas/StoreFasilitasRequest.php`
- Create: `app/Http/Requests/Admin/Humas/UpdateFasilitasRequest.php`
- Create: `app/Http/Controllers/Admin/Humas/FasilitasController.php`
- Create: `resources/views/admin/humas/fasilitas/index.blade.php`
- Create: `resources/views/admin/humas/fasilitas/create.blade.php`
- Create: `resources/views/admin/humas/fasilitas/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Humas/FasilitasCrudTest.php`

- [ ] **Step 1: Write failing feature test `FasilitasCrudTest`**
Verifikasi role Humas dapat mengelola data fasilitas pembelajaran & pendukung, validasi form, dan upload gambar/icon fasilitas.

- [ ] **Step 2: Create FormRequests**
Validasi: `nama` (required), `kategori` (in:pembelajaran,pendukung), `deskripsi` (required), `jumlah` (nullable), `icon` (nullable), `urutan` (integer), `image` (nullable, image, max:2048).

- [ ] **Step 3: Implement `FasilitasController`**
Controller menangani index (pencarian & filter kategori), create, store (upload image ke `fasilitas/`), edit, update, dan destroy.

- [ ] **Step 4: Create Views**
  - `index.blade.php`: Tabel fasilitas dengan badge kategori (Pembelajaran / Pendukung), jumlah ruangan/unit, dan opsi aksi.
  - `create.blade.php` & `edit.blade.php`: Form input sarana prasarana sekolah.

- [ ] **Step 5: Register routes & run tests**
Tambahkan `Route::resource('fasilitas', FasilitasController::class);` di `routes/admin.php`. Pastikan test hijau.

---

## Task 6: Modul Artikel Admin (CRUD + Image Upload) & Publik Image Fallback

**Files:**
- Create: `app/Http/Requests/Admin/Humas/StoreArtikelRequest.php`
- Create: `app/Http/Requests/Admin/Humas/UpdateArtikelRequest.php`
- Create: `app/Http/Controllers/Admin/Humas/ArtikelController.php`
- Create: `resources/views/admin/humas/artikel/index.blade.php`
- Create: `resources/views/admin/humas/artikel/create.blade.php`
- Create: `resources/views/admin/humas/artikel/edit.blade.php`
- Modify: `resources/views/pusat-karir/artikel.blade.php`
- Modify: `resources/views/pusat-karir/detail-artikel.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Humas/ArtikelCrudTest.php`

- [ ] **Step 1: Write failing feature test `ArtikelCrudTest`**
Uji otentikasi role Humas, auto-generation slug atau custom slug, upload berkas cover artikel ke disk public, update data & ganti cover, estimasi waktu baca auto-calculate jika kosong, dan hapus artikel beserta gambarnya.

- [ ] **Step 2: Create FormRequests**
  - `StoreArtikelRequest`: `title` (required, max 255), `slug` (nullable, unique:artikels,slug), `excerpt` (required, max 500), `content` (required), `kategori` (required, max 100), `published_at` (nullable, date), `image` (nullable, image, max:2048), `image_url` (nullable, url, max:500).
  - `UpdateArtikelRequest`: aturan serupa dengan ignore unique id slug.

- [ ] **Step 3: Implement `ArtikelController`**
  - Menyimpan cover via `HandlesUploads` ke direktori `artikels/`.
  - Auto-generate slug jika user tidak mengisi via `Str::slug($request->title)`.
  - Hitung perkiraan `reading_time` otomatis jika kosong: `ceil(str_word_count(strip_tags($content)) / 200) . ' menit'`.

- [ ] **Step 4: Create Admin Views (index, create, edit)**
  - `index.blade.php`: Tabel artikel, filter kategori, cover thumbnail, status publikasi, tanggal rilis.
  - `create.blade.php` & `edit.blade.php`: Editor konten dengan textarea lapang, unggah gambar cover, kategori pill selector/input.

- [ ] **Step 5: Update Public Artikel Views to support `image_path`**
Perbarui `resources/views/pusat-karir/artikel.blade.php` dan `detail-artikel.blade.php` agar memeriksa `$artikel->image_path ? Storage::disk('public')->url($artikel->image_path) : $artikel->image_url`.

- [ ] **Step 6: Register route & run tests**
Tambahkan `Route::resource('artikel', ArtikelController::class);` di `routes/admin.php`. Pastikan test lulus.

---

## Task 7: Modul Webinar Admin (CRUD + Toggle Publish)

**Files:**
- Create: `app/Http/Requests/Admin/Humas/StoreWebinarRequest.php`
- Create: `app/Http/Requests/Admin/Humas/UpdateWebinarRequest.php`
- Create: `app/Http/Controllers/Admin/Humas/WebinarController.php`
- Create: `resources/views/admin/humas/webinar/index.blade.php`
- Create: `resources/views/admin/humas/webinar/create.blade.php`
- Create: `resources/views/admin/humas/webinar/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Humas/WebinarCrudTest.php`

- [ ] **Step 1: Write failing feature test `WebinarCrudTest`**
Uji otentikasi role Humas, CRUD webinar (pemateri, tanggal, platform/lokasi, URL registrasi), dan endpoint `togglePublish`.

- [ ] **Step 2: Create FormRequests**
Validasi input: `title`, `description`, `speaker`, `platform`, `location`, `start_date`, `start_time`, `registration_url`, `is_published`.

- [ ] **Step 3: Implement `WebinarController`**
CRUD controller lengkap dengan method `togglePublish(Webinar $webinar)`.

- [ ] **Step 4: Create Views**
  - `index.blade.php`: Daftar webinar terdaftar, waktu pelaksanaan, status publish badge + switch toggle, aksi edit/hapus.
  - `create.blade.php` & `edit.blade.php`: Form informasi webinar dan pendaftaran.

- [ ] **Step 5: Register routes & run tests**
Tambahkan `Route::patch('webinar/{webinar}/toggle-publish', [WebinarController::class, 'togglePublish'])->name('webinar.toggle-publish');` dan `Route::resource('webinar', WebinarController::class);` pada `routes/admin.php`.

---

## Task 8: Update Admin Sidebar Navigation & Icons

**Files:**
- Modify: `app/Support/AdminMenu.php`
- Modify: `resources/views/admin/layout.blade.php`
- Test: `tests/Feature/Admin/AdminMenuTest.php`

- [ ] **Step 1: Update `AdminMenu.php`**
Pastikan grup menu Humas telah lengkap dan mengarah ke route admin yang valid:
  - Guru & Tendik (`admin.guru.index`) - role `admin`, `humas`
  - Struktur Organisasi (`admin.struktur-organisasi.index`) - role `admin`, `humas`
  - Sarana Prasarana (`admin.fasilitas.index`) - role `admin`, `humas`
  - Artikel (`admin.artikel.index`) - role `admin`, `humas`
  - Webinar (`admin.webinar.index`) - role `admin`, `humas`

- [ ] **Step 2: Update Lucide Icon Switch in `layout.blade.php`**
Tambahkan case icon untuk `network` (struktur organisasi), `building` (fasilitas), dan `video` (webinar) agar dirender dengan benar.

- [ ] **Step 3: Test menu visibility per role**
Pastikan user dengan role `humas` hanya melihat menu Humas + Dashboard umum, dan Super Admin melihat semuanya.

---

## Task 9: Formatting & End-to-End Regression Test

- [ ] **Step 1: Run Pint code style fixer**
Jalankan `php vendor/bin/pint` untuk memastikan seluruh file baru mematuhi standar PSR-12 dan konvensi JHIC.

- [ ] **Step 2: Run full test suite**
Jalankan `php artisan test` untuk memastikan semua test (Fase 1 Fondasi, Fase 2 BKK, dan Fase 3 Humas) lulus 100% tanpa regresi.
