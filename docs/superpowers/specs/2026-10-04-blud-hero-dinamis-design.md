# Design: Hero Banner BLUD Dinamis

Tanggal: 2026-10-04
Branch: `feat/blud-dinamis`

## Problem

Halaman public BLUD (`/blud`) sudah dinamis untuk produk/galeri/komentar, tetapi hero banner masih hardcoded:

- `resources/views/blud/index.blade.php:272-276` — gambar placeholder + judul "Jasa Pentest Website" statis.

Admin tidak bisa mengubah banner tanpa menyentuh kode.

## Scope

**In scope:**
- Hero banner halaman `/blud` diambil otomatis dari database (produk published dengan rating tertinggi).

**Out of scope (tetap statis):**
- Label seksi ("Produk Terlaris", "Semua Produk")
- Badge "Karya Siswa" di kartu
- Footer credit
- Template pesan WA admin

Tidak ada migration, tidak ada tabel baru, tidak ada kolom baru.

## Keputusan Desain

1. **Sumber data**: otomatis, tanpa flag admin. Ranking: `rating DESC, penilaian_count DESC, created_at DESC`.
1a. **Hero diturunkan dari koleksi `$produkBluds`** (bukan query terpisah) — zero query tambahan, search-aware: `?q=` nihil → hero ikut hilang, konsisten dengan `test_blud_index_search_filters_products_backend`.
2. **Konten banner**: gambar galeri produk, judul + subjudul, CTA link ke detail produk. Tanpa harga.
3. **Pendekatan**: query di `BludController::index()` + partial baru. Bukan method model (YAGNI — satu pemakaian), bukan logika di Blade.

## Arsitektur & Data Flow

```
GET /blud
  └─ BludController::index()
       ├─ $query produk published + filter search (existing)
       ├─ $produkBluds = $query->get()
       ├─ $hero = $produkBluds                  ← sort stabil berurutan:
       │      ->sortByDesc('created_at')          (tertiary)
       │      ->sortByDesc('penilaian_count')     (secondary)
       │      ->sortByDesc('rating')              (primary)
       │      ->first()
       └─ view('blud.index', compact('produkBluds', 'hero'))

index.blade.php
  └─ @include('blud.partials.hero')   ← menggantikan blok hardcoded 272-276
```

Hero berasal dari koleksi yang sudah di-fetch (tanpa query tambahan) dan mengikuti filter pencarian — saat `?q=` tidak menemukan apa pun, `$hero = null` dan banner tidak dirender. Urutan `sortByDesc` dibalik dari prioritas karena sort stabil: primary diterapkan terakhir.

## Komponen: `resources/views/blud/partials/hero.blade.php`

- Seluruh `<section>` dibungkus `@if ($hero)` — tanpa produk published, section tidak dirender.
- Gambar: `$hero->galeri->first()?->image_url ?? placehold fallback` (pola identik `card.blade.php:7`).
- Judul: `{{ $hero->title }}`.
- Subjudul: `{{ $hero->jurusan_nama }}` + `Str::limit($hero->deskripsi, 120)`.
- CTA: `route('blud.detail', $hero->slug)`, label statis "Lihat Detail".
- Gambar hero: `loading="eager"` + `fetchpriority="high"` (LCP), `alt` = title.
- Style: pakai class `.blud-hero` yang sudah ada — markup pindah ke partial, tanpa redesign visual.

## Edge Cases

| Kasus | Perilaku |
|---|---|
| Tidak ada produk published | `$hero = null`, section banner hilang, empty state lama tetap jalan |
| Pencarian `?q=` tidak menemukan apa pun | `$hero = null`, banner ikut hilang (search-aware) |
| Rating tie | Tiebreak `penilaian_count` → `created_at`; deterministik |
| Produk hero di-unpublish | Otomatis gugur, produk berikutnya naik tanpa aksi admin |
| Galeri kosong | Placeholder placehold.co |

## Testing

Tambah di `tests/Feature/BludProdukTest.php`:

1. `test_hero_shows_highest_rated_published_product` — seed 3 produk beda rating; judul top-rating muncul, judul lain tidak.
2. `test_hero_hidden_when_no_published_product` — semua `is_published=false`; selector `blud-hero` tidak ada di response.
3. `test_hero_galeri_empty_falls_back_to_placeholder` — hero tanpa galeri; `img src` = placehold.
4. `test_hero_link_points_to_detail` — `href` = `route('blud.detail', slug)`.

Verifikasi: `php artisan test tests/Feature/BludProdukTest.php` + `php vendor/bin/pint --dirty`.
