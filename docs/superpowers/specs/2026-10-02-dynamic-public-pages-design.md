# Design: Integrasi Data Dinamis ke Halaman Publik

**Date:** 2026-10-02
**Status:** Approved

## Tujuan

Mengintegrasikan data dari database yang diupdate dari dashboard admin ke semua halaman publik yang masih statis, agar konten dapat dikelola tanpa mengubah kode.

## Scope

Halaman yang diubah:
- `/visi-misi` — konten visi & misi dari settings
- `/jurusan` — statistik dari DB, deskripsi tetap hardcoded
- `/informasi`, `/informasi/prestasi`, `/informasi/akademik` — artikel + pengumuman dari DB

Tidak diubah:
- Homepage (sedang didevelop terpisah)
- Pusat-karir, BLUD, SPMB (sudah dinamis)

## Arsitektur

Pola: closure route + inline query (sama seperti halaman struktur-organisasi/guru/fasilitas yang sudah ada).

```
Admin CRUD → DB tables → Closure route query → view
```

## Schema & Migration

### Settings (visi-misi)

Tabel `settings` sudah ada (key/value/group). Tambah via seeder atau admin UI:

```
group: profil
keys: visi (text), misi (text)
```

Tidak perlu migration baru.

### Artikel (informasi)

Tambah kolom `kategori` untuk filter berita/prestasi/akademik:

```php
Schema::table('artikels', function (Blueprint $table) {
    $table->string('kategori')->default('berita')->after('slug');
});
```

Migration: `add_kategori_to_artikels_table.php`

### Jurusan

Tidak perlu schema change. Stats di-query dari tabel yang sudah ada:
- `lowongans` → count per jurusan
- `alumnis` → count per jurusan
- `mitra_perusahaans` → count per jurusan

## Perubahan File

### Visi-misi

- `routes/web.php` — closure `/visi-misi` query `Setting::get('profil.visi')` + `Setting::get('profil.misi')`
- `resources/views/visi-misi.blade.php` — replace hardcoded text dengan `{{ $visi }}`, `{{ $misi }}`

### Jurusan

- `routes/web.php` — closure `/jurusan` query stats: `Lowongan::selectRaw('jurusan, count(*) as total')->groupBy('jurusan')`, sama untuk `Alumni`, `MitraPerusahaan`
- `resources/views/jurusan/index.blade.php` — tampilkan stats dari DB
- `resources/views/jurusan/layout.blade.php` — opsional: tampilkan stats di detail page

### Informasi

- `routes/web.php` — 3 closure (`/informasi`, `/informasi/prestasi`, `/informasi/akademik`) query `Artikel::where('kategori', ...)` + `Pengumuman::latest()`
- `resources/views/informasi/*.blade.php` — loop `$artikels` + `$pengumumans`
- `resources/views/admin/humas/artikel/create.blade.php` + `edit.blade.php` — tambah field `kategori` (select: berita/prestasi/akademik)
- `app/Http/Requests/Admin/Humas/StoreArtikelRequest.php` + `UpdateArtikelRequest.php` — tambah rule `kategori`

### Settings admin

- `resources/views/admin/settings/index.blade.php` — tambah form section "Profil Sekolah" dengan textarea visi + misi

## Error Handling

- `Setting::get('profil.visi')` → fallback ke default text kosong jika belum diset admin
- `Artikel::where('kategori', ...)` → empty collection OK, view handle dengan `@forelse`
- Stats jurusan → `?? 0` fallback jika tidak ada data

## Testing

- Feature test: visit `/visi-misi`, assert see text dari settings
- Feature test: visit `/informasi`, assert see artikel dari DB
- Feature test: visit `/jurusan`, assert see stats
- Unit test: `Setting::get()` return correct value
