# Hero Banner BLUD Dinamis Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Ganti hero banner hardcoded "Jasa Pentest Website" di halaman `/blud` dengan produk published rating tertinggi dari database.

**Architecture:** `BludController::index()` menurunkan `$hero` dari koleksi `$produkBluds` (sort stabil: rating → penilaian_count → created_at), meneruskannya ke view. Markup hero pindah dari `index.blade.php` ke partial baru `blud/partials/hero.blade.php` yang dirender kondisional (`@if ($hero)`). Tanpa migration, tanpa tabel/kolom baru.

**Tech Stack:** Laravel 13, Blade, PHPUnit (`php artisan test`), Laravel Pint.

**Spec:** `docs/superpowers/specs/2026-10-04-blud-hero-dinamis-design.md`

---

### Task 1: Tests hero (TDD — tulis dulu, pastikan gagal)

**Files:**
- Modify: `tests/Feature/BludProdukTest.php` (tambah 2 helper + 4 test method, taruh setelah `test_unpublished_product_detail_returns_404` / di akhir class sebelum `}`)

- [ ] **Step 1: Tambah helper privat di `BludProdukTest`**

```php
    private function unpublishAllProduk(): void
    {
        ProdukBlud::query()->update(['is_published' => false]);
    }

    private function createProdukHero(array $overrides): ProdukBlud
    {
        return ProdukBlud::create(array_merge([
            'tipe' => 'showcase',
            'jurusan_nama' => 'TKJ',
            'jurusan_slug' => 'tkj',
            'deskripsi' => 'Deskripsi produk hero.',
            'is_published' => true,
        ], $overrides));
    }
```

- [ ] **Step 2: Tambah 4 test method**

```php
    public function test_hero_shows_highest_rated_published_product(): void
    {
        $this->unpublishAllProduk();

        $this->createProdukHero(['slug' => 'produk-rendah', 'title' => 'Produk Rendah', 'rating' => 3.00]);
        $this->createProdukHero(['slug' => 'produk-sedang', 'title' => 'Produk Sedang', 'rating' => 4.00]);
        $this->createProdukHero(['slug' => 'produk-juara', 'title' => 'Produk Juara', 'rating' => 5.00]);

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee('<h1 class="blud-hero__title">Produk Juara</h1>', false);
        $response->assertDontSee('<h1 class="blud-hero__title">Produk Rendah</h1>', false);
        $response->assertDontSee('<h1 class="blud-hero__title">Produk Sedang</h1>', false);
    }

    public function test_hero_hidden_when_no_published_product(): void
    {
        $this->unpublishAllProduk();

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertDontSee('blud-hero', false);
    }

    public function test_hero_galeri_empty_falls_back_to_placeholder(): void
    {
        $this->unpublishAllProduk();
        $this->createProdukHero([
            'slug' => 'produk-tanpa-galeri',
            'title' => 'Produk Tanpa Galeri',
            'rating' => 5.00,
        ]);

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee('placehold.co/1600x560', false);
    }

    public function test_hero_link_points_to_detail(): void
    {
        $this->unpublishAllProduk();
        $this->createProdukHero(['slug' => 'produk-juara', 'title' => 'Produk Juara', 'rating' => 5.00]);

        $response = $this->get(route('blud.index'));

        $response->assertOk();
        $response->assertSee(
            'href="' . route('blud.detail', 'produk-juara') . '" class="blud-hero__cta"',
            false
        );
    }
```

Catatan: `<h1 class="blud-hero__title">Produk Juara</h1>` adalah string kontinu yang hanya muncul di partial hero (daftar produk pakai `<article>`/card). Atribut `href` + `class="blud-hero__cta"` berdampingan di satu baris agar tidak cocok dengan link card (`class="blud-btn-detail"`).

- [ ] **Step 3: Jalankan test, pastikan GAGAL**

Run: `php artisan test tests/Feature/BludProdukTest.php`
Expected: 4 test baru FAIL (hero masih hardcoded "Jasa Pentest Website"; `test_hero_shows...` tidak menemukan `Produk Juara` di `<h1 class="blud-hero__title">`, `test_hero_hidden...` masih menemukan `blud-hero`). Test lama tetap PASS.

- [ ] **Step 4: Commit test saja**

```bash
git add tests/Feature/BludProdukTest.php
git commit -m "test: hero BLUD dinamis (failing)"
```

### Task 2: Implementasi — controller + partial + view

**Files:**
- Modify: `app/Http/Controllers/BludController.php:25-27`
- Create: `resources/views/blud/partials/hero.blade.php`
- Modify: `resources/views/blud/index.blade.php` (CSS blok :70-89 dan markup :271-277)

- [ ] **Step 1: Controller — hitung `$hero`**

Di `BludController::index()`, ganti bagian akhir method (baris 25-27):

```php
        $produkBluds = $query->get();

        // Sort stabil: prioritas rating > penilaian_count > created_at
        // (primary diterapkan terakhir).
        $hero = $produkBluds
            ->sortByDesc('created_at')
            ->sortByDesc('penilaian_count')
            ->sortByDesc('rating')
            ->first();

        return view('blud.index', compact('produkBluds', 'hero'));
```

- [ ] **Step 2: Buat partial hero**

Create `resources/views/blud/partials/hero.blade.php`:

```blade
@if ($hero)
    <section class="blud-hero" aria-label="Banner layanan unggulan">
        <img src="{{ $hero->galeri->first()?->image_url ?? 'https://placehold.co/1600x560/0f172a/94a3b8?text=' . urlencode($hero->title) }}"
            alt="{{ $hero->title }}" width="1600" height="560" loading="eager" fetchpriority="high">
        <div class="blud-hero__overlay"></div>
        <div class="blud-hero__content">
            <h1 class="blud-hero__title">{{ $hero->title }}</h1>
            <p class="blud-hero__subtitle">{{ $hero->jurusan_nama }} · {{ Str::limit($hero->deskripsi ?? '', 120) }}</p>
            <a href="{{ route('blud.detail', $hero->slug) }}" class="blud-hero__cta">Lihat Detail</a>
        </div>
    </section>
@endif
```

- [ ] **Step 3: Ganti CSS `.blud-hero__title` di `index.blade.php`**

Di `index.blade.php`, ganti blok CSS baris 70-89 (`.blud-hero__title` + media query) dengan:

```css
        .blud-hero__content {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            padding: 1.5rem 1.25rem 1.75rem;
            color: #fff;
            max-width: 90rem;
            margin-inline: auto;
            z-index: 1;
        }

        .blud-hero__title {
            font-weight: 800;
            font-size: clamp(1.75rem, 4.2vw, 2.75rem);
            line-height: 1.15;
            letter-spacing: -0.02em;
        }

        .blud-hero__subtitle {
            margin-top: 0.5rem;
            font-size: clamp(0.95rem, 1.6vw, 1.125rem);
            color: rgba(255, 255, 255, 0.85);
            max-width: 48rem;
        }

        .blud-hero__cta {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.65rem 1.4rem;
            border-radius: 9999px;
            background: #fff;
            color: #0f172a;
            font-weight: 700;
            font-size: 0.95rem;
            transition: background 0.15s ease;
        }

        .blud-hero__cta:hover {
            background: #e2e8f0;
        }

        @media (min-width: 768px) {
            .blud-hero__content {
                padding: 2rem 2rem 2.25rem;
            }
        }
```

- [ ] **Step 4: Ganti markup hero hardcoded di `index.blade.php`**

Ganti baris 271-277 (blok dari `{{-- Hero banner --}}` sampai `</section>` penutup hero) dengan:

```blade
        {{-- Hero banner --}}
        @include('blud.partials.hero')
```

`$hero` otomatis ter-include dari variabel view induk.

- [ ] **Step 5: Jalankan test, pastikan LULUS**

Run: `php artisan test tests/Feature/BludProdukTest.php`
Expected: semua test PASS (4 baru + lama). Khususnya `test_blud_index_search_filters_products_backend` tetap PASS karena hero ikut filter `?q=`.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/BludController.php resources/views/blud/partials/hero.blade.php resources/views/blud/index.blade.php
git commit -m "feat: hero banner BLUD dinamis dari produk rating tertinggi"
```

### Task 3: Verifikasi penuh + Pint

**Files:** tidak ada perubahan kode baru

- [ ] **Step 1: Jalankan seluruh test suite**

Run: `php artisan test`
Expected: semua PASS, tanpa regresi (terkait: `tests/Feature/Admin/Blud/*`).

- [ ] **Step 2: Pint**

Run: `php vendor/bin/pint --dirty`
Expected: file yang diubah di-format, exit 0.

- [ ] **Step 3: Cek visual manual (opsional tapi disarankan)**

Run: `php artisan serve` lalu buka `http://localhost:8000/blud`
Expected: banner menampilkan produk rating tertinggi (Cheeseroll dari seeder), judul + subjudul + tombol "Lihat Detail" mengarah ke detail produk, tidak ada layar rusak.

- [ ] **Step 4: Cek git status**

Run: `git status`
Expected: hanya perubahan plan ini yang ter-commit. File `database/migrations/2026_09_26_070821_create_lowongans_table.php` adalah perubahan lama di luar plan — **jangan di-commit, jangan di-revert**, biarkan tetap unstaged.
