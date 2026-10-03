# Design Spec: Perbaikan Issue HIGH (Report Audit JHIC-Smeas-v2)

Tanggal: 2026-10-04
Branch: `fix/high-issues` (dari `main`, HEAD `bed76b8`)

## Latar Belakang

`report.md` memuat 7 issue HIGH. Hasil eksplorasi:

- **HIGH-06 sudah fixed di HEAD** (commit `621611a`, route `spmb.logout` + form POST) — diluar scope, tak dikerjakan.
- **HIGH-05 sebagian fixed** (commit `4b4317b` sudah menghubungkan view ke `$produk->wa_number`) — gap pengisian `wa_number` tidak dikerjakan sesuai keputusan user (hanya 5 item inti).
- **HIGH-02 dialihkan**: input search jurusan di beranda ternyata ditujukan untuk fitur **AI Major Finder** (kuesioner → rekomendasi jurusan) yang halaman/sistemnya belum ada. Fitur baru ini akan di-brainstorm sebagai spec terpisah. Dalam spec ini hanya perbaikan kecil: bungkus input jadi `<form GET>` yang valid.

Scope spec ini: **HIGH-01, HIGH-03, HIGH-04, HIGH-07** + perbaikan kecil form GET HIGH-02.

## Keputusan Desain (perolehan dari brainstorming)

| Issue | Keputusan |
|---|---|
| HIGH-01 Beranda | Guru carousel dari DB + statistik parsial (pengajar = count gurus; jurusan/siswa tetap hardcoded) + prakata kepala sekolah via 3 key Setting baru |
| HIGH-02 | Form GET ke route `jurusan` saja; AI Major Finder = spec terpisah |
| HIGH-03 | Tabel baru `sumber_rekomendasis` + model + admin CRUD + seeder 5 entri |
| HIGH-04 | Form GET `q` + backend LIKE search, tanpa pagination; JS filter lama dipertahankan |
| HIGH-07 | Endpoint AJAX `POST pusat-karir.verifikasi-nisn` (lookup `calon_siswas`) + guard `Rule::exists` di `storeApply` |
| Struktur | Ikuti pola rumah: closure route + controller yang sudah ada; tanpa controller baru kecuali admin CRUD HIGH-03 |

## Bagian 1 — HIGH-01: Beranda Dinamis

### Route `/` (`routes/web.php:21-25`)

Closure `beranda` ditambah:

```php
$gurus = Guru::where('kategori', 'guru')->where('is_active', true)
    ->orderBy('urutan')->limit(4)->get();
$gurusCount = Guru::where('is_active', true)->count();
```

Query guru mengikuti pola route guru-tendik (`routes/web.php:38-43`). `$artikels` tetap seperti sekarang.

Prakata dibaca via `Setting::get()` **di route closure** (bukan di blade), lalu di-pass sebagai array `$prakata` — konsisten dengan pola `SpmbController`.

### 3 key Setting baru

Ditambahkan ke `database/seeders/SettingSeeder.php` (group `profil`) dan form `resources/views/admin/settings/edit.blade.php`:

| Key | Default |
|---|---|
| `profil.prakata_nama` | `Dr. Drs. Anton Sujarwo, M.Pd.` |
| `profil.prakata_quote` | Kutipan "Era globalisasi…" (isi dari hardcoded saat ini) |
| `profil.prakata_foto` | `images/Group 198.png` |

### Perubahan `resources/views/index.blade.php`

- **Prakata (baris 647-669)**: kutipan/nama/foto dibaca dari `$prakata`. Foto siswa pendukung & social handles tetap hardcoded.
- **Statistik (baris 714-741)**: kartu "Pengajar" memakai `{{ $gurusCount }}`. Kartu "Jurusan" (9) dan "Siswa/Siswi" (1200+) tetap hardcoded karena tak ada tabel sumbernya — diberi komentar `ponytail:` yang menandai ceiling dan upgrade path (tabel `jurusans` / `siswas`).
- **Carousel guru (baris 918-976)**: 4 kartu statis diganti `@foreach ($gurus as $guru)` — `$guru->nama`, mapel/jabatan (`$guru->mapel ?? $guru->jabatan`), foto `foto_url` dengan fallback gradien + inisial (`initials` accessor sudah ada).
- **Berita (baris 1090-1102)**: sudah dinamis; tambah hanya blok `@empty` "Belum ada berita."

### Test

Tambah pada `tests/Feature/PublicPagesTest.php`:

- Beranda menampilkan judul artikel factory (sudah terbukti di test `/informasi`).
- Beranda menampilkan nama guru yang dibuat via `Guru::create([...])` di test (tanpa factory file).

## Bagian 2 — HIGH-03: Sumber Rekomendasi

### Migrasi `create_sumber_rekomendasis_table`

```
id, title (string), url (string), kategori (string, nullable),
image_path (string, nullable), urutan (unsigned int, default 0),
is_active (bool, default true), timestamps
```

### Model `App\Models\SumberRekomendasi`

- `$fillable`: `title`, `url`, `kategori`, `image_path`, `urutan`, `is_active`.
- `casts(): ['is_active' => 'boolean', 'urutan' => 'integer']`.
- Accessor `image_url` mengikuti pola `Guru::getFotoUrlAttribute` (public disk, null jika tak ada).

### Admin CRUD

`routes/admin.php`:

```php
Route::resource('sumber-rekomendasi', SumberRekomendasiController::class)
    ->only(['index', 'store', 'destroy']);
```

- `index()`: tabel daftar + form tambah (judul, URL, kategori, upload gambar) mengikuti gaya `admin/humas/artikel/index.blade.php`.
- `store()`: validasi `title => required`, `url => required|url`, upload gambar ke `public/sumber/` (pola upload SPMB/magang), set `urutan` otomatis (max+1).
- `destroy()`: hapus record + file gambar terkait.
- Penempatan menu admin: dekat menu artikel/karir BKK/Humas — detail pasti dipastikan saat penulisan plan.

### Data flow publik

`LowonganController::index()` (route `pusat-karir.index`) menambah:

```php
$sumberRekomendasi = SumberRekomendasi::where('is_active', true)
    ->orderBy('urutan')->limit(5)->get();
```

### Blade `resources/views/pusat-karir/pusat-karir.blade.php` (baris 918-1021)

- Hapus blok `@php $sumberRekomendasi = []` dummy (918-922).
- Markup kartu (928-1003) diubah dari akses array ke objek: `$s->url`, `$s->title`, `$s->kategori`, `$s->image_url`; kondisi gambar `$s->image_url !== null` menggantikan `$sumber['has_image']`.
- Empty state (1004-1019) tetap, tampil saat koleksi kosong.

### Seeder `SumberRekomendasiSeeder`

5 entri contoh (URL resmi): LinkedIn, Glints, Dicoding, Dibimbing, JobStreet Indonesia; `urutan` 0-4, `is_active = true`. Didaftarkan di `DatabaseSeeder`.

### Test

- Admin: `store` valid → 302 + record ada; `url` bukan URL → error; `destroy` → record hilang.
- Publik: `GET /pusat-karir` melihat judul entri aktif; entri `is_active = false` tidak tampil.

## Bagian 3 — HIGH-04: Search BLUD Backend

### `BludController::index()` (`app/Http/Controllers/BludController.php:12-20`)

Tambah parameter `Request $request`:

```php
$query = ProdukBlud::where('is_published', true)
    ->with('galeri')->orderByDesc('created_at');
if ($request->filled('q')) {
    $q = $request->string('q')->toString();
    $query->where(fn ($b) => $b->where('title', 'like', "%{$q}%")
        ->orWhere('jurusan_nama', 'like', "%{$q}%")
        ->orWhere('deskripsi', 'like', "%{$q}%"));
}
$produkBluds = $query->get();
```

Bentuk query mengikuti pola `LowonganController::katalogLowongan` (215-221) dan admin `ProdukBludController` (29-38). Tanpa pagination — data produk BLUD berskala puluhan (keputusan user).

### Blade `resources/views/blud/index.blade.php` (279-293)

- Bungkus label + input jadi `<form action="{{ route('blud.index') }}" method="GET">`; input sudah memiliki `name="q"` (kini jadi fungsional), submit lewat Enter dan tombol cari yang ada.
- JS filter (353-390) dipertahankan untuk ketik instan tanpa reload; keduanya kompatibel karena membaca nilai input yang sama.
- Empty state (338-346) berlaku untuk hasil search kosong.

### Test

Tambah pada `tests/Feature/BludProdukTest.php`:

- `?q=` dengan kata yang cocok judul → produk tampil.
- `?q=zonk` → daftar kosong (empty state).

## Bagian 4 — HIGH-07: Verifikasi NISN

### Route baru (`routes/web.php`, dekat route lamar)

```php
Route::post('/pusat-karir/verifikasi-nisn', [LowonganController::class, 'verifikasiNisn'])
    ->middleware('throttle:10,1')
    ->name('pusat-karir.verifikasi-nisn');
```

House pattern: web route + respons `wantsJson`, throttle sama seperti route komentar BLUD.

### `LowonganController::verifikasiNisn(Request)`

```php
$request->validate(['nisn' => ['required', 'digits:10']]);
$siswa = CalonSiswa::where('nisn', $request->string('nisn')->toString())->first();

return response()->json(['valid' => (bool) $siswa, 'nama' => $siswa?->nama_lengkap]);
```

- Sumber data: **`calon_siswas` saja** (keputusan user).
- Format salah → 422 JSON. NISN tidak ditemukan → 200 dengan `valid: false` (hasil wajar, bukan error).

### JS (`resources/views/pusat-karir/lamar-lowongan.blade.php:458-491`)

Blok simulasi diganti fetch nyata ke `{{ route('pusat-karir.verifikasi-nisn') }}`:

- Header: `X-CSRF-TOKEN` dari meta, `Accept: application/json`.
- Valid → tampilkan `#verified-box` berisi nama asli: `Data Siswa: {nama} — NISN Valid`.
- Tak valid → pesan "NISN tidak terdaftar di SMKN 1 Surabaya."
- State loading: tombol disable selama fetch.

### Guard server di `storeApply()` (`LowonganController.php:132`)

```php
'nisn' => ['required', 'numeric', 'digits:10', 'exists:calon_siswas,nisn'],
```

Submit tanpa NISN valid → ditolak validasi.

**Dampak ke test lama**: test yang POST `nisn => '1234567890'` (`LowonganApplyValidationTest`, `LowonganApplyUploadTest`, `LowonganBuktiPdfTest`) wajib membuat `CalonSiswa` dengan NISN tersebut di `setUp`. Semua test terdampak ditinjau saat penulisan plan.

### Test baru

1. `POST pusat-karir.verifikasi-nisn` dengan NISN terdaftar → `valid: true` + nama.
2. NISN tak terdaftar (10 digit) → 200 `valid: false`.
3. Format salah → 422.
4. `storeApply` dengan NISN tak terdaftar → ditolak; dengan yang terdaftar → sukses (redirect flash / JSON 201).

## Error Handling

- Endpoint NISN: selalu 200 untuk hasil "tidak ditemukan"; 422 hanya format salah.
- Guard server memakai pesan validasi Indonesia bawaan Laravel (`exists` → "Data … tidak valid / tidak ditemukan").
- Form GET BLUD & beranda tanpa parameter → perilaku identik dengan sekarang (tanpa `q`, query lurus).
- Admin CRUD SumberRekomendasi: `url` bukan URL → error validasi form; upload bukan gambar → ditolak aturan `mimes`.

## Pengujian

Jalankan berikut setiap perubahan:

```bash
php artisan test
php vendor/bin/pint --dirty
```

Semua test hijau adalah syarat selesai. Fokus test baru tercantum per bagian di atas.

## Di Luar Scope (YAGNI)

- AI Major Finder (spec terpisah, menyusul).
- HIGH-05 gap pengisian `wa_number` (sudah diputuskan tidak dikerjakan).
- HIGH-06 (sudah fixed; verifikasi ulang lewat test tidak diminta).
- Tabel `jurusans` / `siswas` untuk statistik beranda (upgrade path ditandai komentar `ponytail:`).
- Pagination BLUD.
- Refactoring footer/inline CSS (MEDIUM/LOW lain).
