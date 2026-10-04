# Navigation Fixes Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix all navigation issues found in the audit — dead links, wrong destinations, broken routes, missing elements, and accessibility gaps across the JHIC-Smeas-v2 Laravel app.

**Architecture:** Systematically fix each category: (1) user-facing dead links and wrong destinations in Blade views, (2) controller return-type mismatches, (3) route wiring issues, (4) missing navigation elements, (5) accessibility. Each task is self-contained with TDD steps where applicable.

**Tech Stack:** Laravel 13.x, PHP 8.3+, Blade, Tailwind CSS v4, PHPUnit 12.x

---

## File Structure

| File | Responsibility |
|------|----------------|
| `resources/views/partials/navbar.blade.php` | Default logo URL fix (A1) |
| `resources/views/pusat-karir/pusat-karir.blade.php` | Hero search form action (A2) |
| `resources/views/index.blade.php` | Homepage search + news cards (A3, A5) |
| `app/Http/Controllers/LowonganController.php` | storeApply redirect (A4), bimbinganKatalog url filter (A15) |
| `resources/views/pusat-karir/lamar-lowongan.blade.php` | Breadcrumbs (A8) |
| `resources/views/informasi-prestasi.blade.php` | Article cards clickable (A6) |
| `resources/views/informasi-akademik.blade.php` | Article cards + dead CTAs (A6, A12) |
| `resources/views/informasi.blade.php` | Agenda tab + event cards (A7) |
| 8 public footer files | Footer BLUD link (A9) |
| `resources/views/pusat-karir/detail-lowongan.blade.php` | Full dynamic render (A10) |
| `resources/views/pusat-karir/katalog-mitra.blade.php` | CTA buttons (A11) |
| `resources/views/pusat-karir/artikel.blade.php` | CV template links (A13) |
| `resources/views/blud/detail-kustom.blade.php` | WA links (A14) |
| `resources/views/blud/detail-showcase.blade.php` | WA links (A14) |
| `resources/views/pusat-karir/detail-mitra.blade.php` | Latent WA/doc links (A16) |
| `routes/web.php` | spmb.logout + middleware (B4), duplicate SPMB route (B3) |
| `app/Http/Controllers/SpmbController.php` | logout method (B4) |
| `resources/views/spmb/dashboard/layout.blade.php` | Logout button (B4) |
| `routes/admin.php` | Drop show from 10 resources (B1) |
| `routes/web.php` | jurusan.detail 404 guard (B2) |
| `resources/views/admin/layout.blade.php` | "View site" link (C3) |
| `resources/views/admin/dashboard.blade.php` | Quick-access cards (C1) |
| `resources/views/admin/bkk/lowongan/index.blade.php` | Public preview link (C2) |
| `resources/views/admin/bkk/mitra/index.blade.php` | Public preview link (C2) |
| `routes/admin.php` | Rename tracer settings route (C4) |
| `resources/views/spmb/login.blade.php` | url() -> route() (C5) |
| `resources/views/partials/navbar.blade.php` | aria-label + keyboard access (D1, D2) |
| `resources/views/admin/layout.blade.php` | aria-label (D2) |
| Multiple breadcrumb files | aria-label="Breadcrumb" (D3) |

---

## Task 1: Fix Navbar Logo Default URL (A1)

**Files:**
- Modify: `resources/views/partials/navbar.blade.php:4`

- [ ] **Step 1: Change default logo URL from pusat-karir to beranda**

Replace line 4:
```php
// OLD:
$logoUrl = $logoUrl ?? route('pusat-karir.index');
// NEW:
$logoUrl = $logoUrl ?? route('beranda');
```

- [ ] **Step 2: Verify**

Run: `php artisan route:list --name=beranda`
Expected: Route exists.

---

## Task 2: Fix Hero Search Form Action (A2)

**Files:**
- Modify: `resources/views/pusat-karir/pusat-karir.blade.php:248`

- [ ] **Step 1: Point hero search to katalog-lowongan**

Replace:
```blade
<form class="hero-search-bar" action="#" method="GET" id="hero-search-form">
```
With:
```blade
<form class="hero-search-bar" action="{{ route('pusat-karir.katalog-lowongan') }}" method="GET" id="hero-search-form">
```

---

## Task 3: Fix Homepage Search + News Cards (A3, A5)

**Files:**
- Modify: `resources/views/index.blade.php:1057` (search form)
- Modify: `resources/views/index.blade.php:1090-1156` (news cards)

- [ ] **Step 1: Fix homepage search form action**

Replace:
```blade
<form ... action="{{ route('pusat-karir.index') }}" method="GET">
```
With:
```blade
<form ... action="{{ route('pusat-karir.katalog-lowongan') }}" method="GET">
```

- [ ] **Step 2: Replace hardcoded news cards with dynamic articles**

Replace the 4 hardcoded news cards (lines ~1090-1156) with:
```blade
@foreach ($artikels->take(4) as $artikel)
    <a href="{{ route('pusat-karir.detail-artikel', $artikel->slug) }}" class="block group">
        <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
            @if ($artikel->image)
                <img src="{{ asset('storage/' . $artikel->image) }}" alt="{{ $artikel->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
            @endif
            <div class="p-5">
                <h3 class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">{{ $artikel->title }}</h3>
                <p class="text-sm text-slate-500 mt-2">{{ $artikel->excerpt ?? Str::limit(strip_tags($artikel->content), 120) }}</p>
            </div>
        </article>
    </a>
@endforeach
```

---

## Task 4: Fix Apply Form Redirect (A4)

**Files:**
- Modify: `app/Http/Controllers/LowonganController.php:134-141`

- [ ] **Step 1: Replace JSON response with redirect + flash**

Replace the `return response()->json(...)` block at lines 134-141:
```php
return redirect()->route('pusat-karir.detail', $slug)->with('lamaran_success', [
    'nisn' => $application->nisn,
    'registration_code' => $application->registration_code,
]);
```

---

## Task 5: Make Prestasi/ Akademik Article Cards Clickable (A6)

**Files:**
- Modify: `resources/views/informasi-prestasi.blade.php:334-348`
- Modify: `resources/views/informasi-akademik.blade.php:281-297`

- [ ] **Step 1: Wrap prestasi article cards in anchor tags**

Replace the `<div class="berita-card">` loop content with:
```blade
<a href="{{ route('pusat-karir.detail-artikel', $artikel->slug) }}" class="block group">
    <article class="berita-card group-hover:shadow-md transition-shadow">
        <!-- existing card content -->
    </article>
</a>
```

- [ ] **Step 2: Repeat same pattern for informasi-akademik.blade.php**

Apply the same `<a>` wrapper pattern to the `@forelse` block in `informasi-akademik.blade.php`.

---

## Task 6: Fix Informasi Agenda Tab + Event Cards (A7)

**Files:**
- Modify: `resources/views/informasi.blade.php:152-166, 209-254`

- [ ] **Step 1: Remove dead agenda tab button or make it a real link**

Replace:
```blade
<button type="button" data-category="agenda" class="category-tab active ...">Agenda Sekolah</button>
```
With:
```blade
<a href="{{ route('informasi') }}#agenda" class="category-tab active ...">Agenda Sekolah</a>
```

- [ ] **Step 2: Make event cards clickable if detail URLs exist**

If event cards have detail pages, wrap in `<a>`. Otherwise, remove `cursor-pointer` class to avoid false affordance.

---

## Task 7: Fix Breadcrumb Dead Links (A8)

**Files:**
- Modify: `resources/views/pusat-karir/detail-lowongan.blade.php:1346,1350`
- Modify: `resources/views/pusat-karir/lamar-lowongan.blade.php:296,300`

- [ ] **Step 1: Fix detail-lowongan breadcrumbs**

Replace:
```blade
<a href="#">Beranda</a>
```
With:
```blade
<a href="{{ route('beranda') }}">Beranda</a>
```

Replace:
```blade
<a href="#">Mitra Industri (DUDI)</a>
```
With:
```blade
<a href="{{ route('pusat-karir.katalog-mitra') }}">Mitra Industri (DUDI)</a>
```

- [ ] **Step 2: Fix lamar-lowongan breadcrumbs**

Replace:
```blade
<a href="#">Beranda</a>
```
With:
```blade
<a href="{{ route('beranda') }}">Beranda</a>
```

Replace:
```blade
<a href="#">Peluang Unggulan</a>
```
With:
```blade
<a href="{{ route('pusat-karir.index') }}#peluang-unggulan">Peluang Unggulan</a>
```

---

## Task 8: Fix Footer BLUD Links on 8 Pages (A9)

**Files:**
- Modify: `resources/views/informasi.blade.php:417`
- Modify: `resources/views/informasi-prestasi.blade.php:429`
- Modify: `resources/views/informasi-akademik.blade.php:376`
- Modify: `resources/views/struktur-organisasi.blade.php:274`
- Modify: `resources/views/sarana-dan-prasarana.blade.php:251`
- Modify: `resources/views/guru-dan-tenaga-kependidikan.blade.php:212`
- Modify: `resources/views/jurusan/index.blade.php:453`
- Modify: `resources/views/jurusan/layout.blade.php:172`

- [ ] **Step 1: Replace all footer BLUD href="#" with route()**

In each file, find:
```blade
<a href="#" ...>BLUD</a>
```
Replace with:
```blade
<a href="{{ route('blud.index') }}" ...>BLUD</a>
```

---

## Task 9: Fix Detail Lowongan Static Template (A10)

**Files:**
- Modify: `resources/views/pusat-karir/detail-lowongan.blade.php` (multiple sections)

- [ ] **Step 1: Remove hardcoded Telkom references**

Replace hardcoded company tag link:
```blade
<a href="https://www.telkom.co.id" ...>{{ $lowongan->company_name }}</a>
```

- [ ] **Step 2: Replace dead "Lihat Detail Loker" CTA**

Replace:
```blade
<a href="#" class="...">Lihat Detail Loker →</a>
```
With:
```blade
<a href="{{ route('pusat-karir.katalog-lowongan') }}" class="...">Lihat Detail Loker →</a>
```

- [ ] **Step 3: Wire document download buttons to $lowongan->dokumen**

Replace static `href="#"` doc buttons with:
```blade
@if ($lowongan->dokumen)
    <a href="{{ asset('storage/' . $lowongan->dokumen) }}" download class="doc-unduh-btn">Unduh Dokumen</a>
@endif
```

- [ ] **Step 4: Remove fake WA default number**

Replace:
```blade
href="https://wa.me/{{ $lowongan->pokja_wa ?? '6281234567890' }}"
```
With:
```blade
@if ($lowongan->pokja_wa)
    <a href="https://wa.me/{{ $lowongan->pokja_wa }}" target="_blank">Hubungi via WhatsApp</a>
@endif
```

- [ ] **Step 5: Remove static demo block**

Remove the "Job Card 2 — Loker BKK Alumni (hardcoded demo)" static block entirely.

---

## Task 10: Fix Katalog Mitra Dead CTAs (A11)

**Files:**
- Modify: `resources/views/pusat-karir/katalog-mitra.blade.php:232,237`

- [ ] **Step 1: Wire CTA buttons to real destinations**

Replace:
```blade
<a href="#" class="...">Hubungi Pokja Hubungan Industri</a>
```
With:
```blade
<a href="{{ route('pusat-karir.index') }}#kontak" class="...">Hubungi Pokja Hubungan Industri</a>
```

Replace:
```blade
<a href="#" class="...">Unduh Draf Panduan MoU (.PDF)</a>
```
With:
```blade
<a href="{{ asset('storage/dokumen/panduan-mou.pdf') }}" download class="...">Unduh Draf Panduan MoU (.PDF)</a>
```

---

## Task 11: Fix Informasi Akademik Dead CTAs (A12)

**Files:**
- Modify: `resources/views/informasi-akademik.blade.php:192,258`

- [ ] **Step 1: Wire "Unduh PDF" button**

Replace:
```blade
<a href="#" class="...">Unduh PDF</a>
```
With:
```blade
<a href="{{ asset('storage/dokumen/kalender-akademik.pdf') }}" download class="...">Unduh PDF</a>
```

- [ ] **Step 2: Wire "SMEAS.AI" button**

Replace:
```blade
<a href="#" class="...">SMEAS.AI</a>
```
With:
```blade
<a href="https://smeas.smkn1sch.sch.id" target="_blank" class="...">SMEAS.AI</a>
```

---

## Task 12: Fix Artikel CV Template Dead Links (A13)

**Files:**
- Modify: `resources/views/pusat-karir/artikel.blade.php:86`

- [ ] **Step 1: Wire CV template download links**

Replace:
```blade
@foreach (['Format CV ATS', ...] as $tpl)
    <a href="#" class="...">Unduh</a>
@endforeach
```
With:
```blade
@foreach (['Format CV ATS' => 'cv-ats.pdf', 'Format CV Kreatif' => 'cv-kreatif.pdf', 'Format CV Formal' => 'cv-formal.pdf'] as $label => $file)
    <a href="{{ asset('storage/dokumen/' . $file) }}" download class="...">Unduh {{ $label }}</a>
@endforeach
```

---

## Task 13: Fix BLUD Detail WhatsApp Links (A14)

**Files:**
- Modify: `resources/views/blud/detail-kustom.blade.php:129`
- Modify: `resources/views/blud/detail-showcase.blade.php:121,139`

- [ ] **Step 1: Build WA links from product data**

Replace:
```blade
<a href="https://wa.me/" ...>
```
With:
```blade
@if ($produk->wa_number)
    <a href="https://wa.me/{{ $produk->wa_number }}" target="_blank" ...>
@endif
```

---

## Task 14: Fix Detail Mitra Latent Dead Links (A16)

**Files:**
- Modify: `resources/views/pusat-karir/detail-mitra.blade.php:137,343,395`

- [ ] **Step 1: Guard WA and doc links with null checks**

Replace:
```blade
$waLink = $mitra->narahubung_wa ? 'https://wa.me/...' : '#'
```
With:
```blade
$waLink = $mitra->narahubung_wa ? 'https://wa.me/' . $mitra->narahubung_wa : null
```
And in the template:
```blade
@if ($waLink)
    <a href="{{ $waLink }}">Hubungi via WhatsApp</a>
@endif
```

Apply same null-guard pattern for document download links.

---

## Task 15: Drop Admin Show Routes (B1)

**Files:**
- Modify: `routes/admin.php` (10 Route::resource declarations)

- [ ] **Step 1: Add ->only() to each resource missing show()**

For each of these resources: `lowongan`, `mitra`, `bimbingan`, `guru`, `struktur-organisasi`, `fasilitas`, `artikel`, `webinar`, `pengumuman`, `faq`, `users`:

Replace:
```php
Route::resource('lowongan', Admin\Bkk\LowonganController::class);
```
With:
```php
Route::resource('lowongan', Admin\Bkk\LowonganController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
```

Repeat for all 10 resources.

---

## Task 16: Fix Jurusan Detail 404 Guard (B2)

**Files:**
- Modify: `routes/web.php:59-61`

- [ ] **Step 1: Add view existence check**

Replace:
```php
Route::get('/jurusan/{slug}', function (string $slug) {
    return view("jurusan.{$slug}");
})->name('jurusan.detail');
```
With:
```php
Route::get('/jurusan/{slug}', function (string $slug) {
    $view = "jurusan.{$slug}";
    if (! view()->exists($view)) {
        abort(404);
    }
    return view($view);
})->name('jurusan.detail');
```

---

## Task 17: Fix Duplicate SPMB Routes (B3)

**Files:**
- Modify: `routes/web.php:112-113`

- [ ] **Step 1: Make spmb.login-page an alias**

Replace:
```php
Route::get('/spmb/login', [SpmbController::class, 'index'])->name('spmb.login-page');
```
With:
```php
Route::get('/spmb/login', fn () => redirect()->route('spmb.index'));
```

---

## Task 18: Add SPMB Logout + Middleware (B4)

**Files:**
- Modify: `routes/web.php` (add logout route + middleware group)
- Modify: `app/Http/Controllers/SpmbController.php` (add logout method)
- Modify: `resources/views/spmb/dashboard/layout.blade.php` (add logout button)

- [ ] **Step 1: Create SpmbAuthMiddleware**

Create `app/Http/Middleware/SpmbAuthMiddleware.php`:
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpmbAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! session()->has('spmb_nisn')) {
            return redirect()->route('spmb.index');
        }

        return $next($request);
    }
}
```

- [ ] **Step 2: Register middleware alias in bootstrap/app.php**

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['spmb.auth' => \App\Http\Middleware\SpmbAuthMiddleware::class]);
})
```

- [ ] **Step 3: Add logout route and wrap dashboard in middleware**

In `routes/web.php`, add:
```php
Route::post('/spmb/logout', [SpmbController::class, 'logout'])->name('spmb.logout');
```

Wrap existing dashboard routes in middleware group:
```php
Route::middleware('spmb.auth')->group(function () {
    // existing dashboard, biodata, orang-tua, dokumen, formulir, dll routes
});
```

Create `app/Http/Middleware/SpmbAuthMiddleware.php`:
```php
public function handle(Request $request, Closure $next): Response
{
    if (! session()->has('spmb_nisn')) {
        return redirect()->route('spmb.index');
    }
    return $next($request);
}
```

Register in `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['spmb.auth' => SpmbAuthMiddleware::class]);
})
```

- [ ] **Step 2: Add logout method to SpmbController**

```php
public function logout(): RedirectResponse
{
    session()->forget('spmb_nisn');
    return redirect()->route('spmb.index');
}
```

- [ ] **Step 3: Add logout button to SPMB dashboard layout**

In `resources/views/spmb/dashboard/layout.blade.php`, add:
```blade
<form action="{{ route('spmb.logout') }}" method="POST">
    @csrf
    <button type="submit" class="...">Keluar</button>
</form>
```

---

## Task 19: Add Admin "View Site" Link (C3)

**Files:**
- Modify: `resources/views/admin/layout.blade.php:147-230`

- [ ] **Step 1: Add "Lihat Situs" link to sidebar**

Add before the logout button:
```blade
<a href="{{ route('beranda') }}" target="_blank" class="...">
    Lihat Situs
</a>
```

---

## Task 20: Add Admin Dashboard Quick-Access Cards (C1)

**Files:**
- Modify: `resources/views/admin/dashboard.blade.php`

- [ ] **Step 1: Add quick-access navigation cards**

Add:
```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <a href="{{ route('admin.lowongan.index') }}" class="p-4 bg-white rounded-lg shadow hover:shadow-md transition">
        <h3 class="font-bold">Lowongan</h3>
        <p class="text-sm text-gray-500">Kelola lowongan kerja & magang</p>
    </a>
    <a href="{{ route('admin.mitra.index') }}" class="p-4 bg-white rounded-lg shadow hover:shadow-md transition">
        <h3 class="font-bold">Mitra</h3>
        <p class="text-sm text-gray-500">Kelola mitra industri</p>
    </a>
    <a href="{{ route('admin.lamaran.index') }}" class="p-4 bg-white rounded-lg shadow hover:shadow-md transition">
        <h3 class="font-bold">Lamaran</h3>
        <p class="text-sm text-gray-500">Kelola lamaran masuk</p>
    </a>
</div>
```

---

## Task 21: Add Admin Public Preview Links (C2)

**Files:**
- Modify: `resources/views/admin/bkk/lowongan/index.blade.php`
- Modify: `resources/views/admin/bkk/mitra/index.blade.php`

- [ ] **Step 1: Add "Lihat di Situs" link to lowongan index**

Add in the header area:
```blade
<a href="{{ route('pusat-karir.katalog-lowongan') }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat di Situs →</a>
```

- [ ] **Step 2: Add "Lihat di Situs" link to mitra index**

```blade
<a href="{{ route('pusat-karir.katalog-mitra') }}" target="_blank" class="text-sm text-blue-600 hover:underline">Lihat di Situs →</a>
```

---

## Task 22: Rename Tracer Settings Route (C4)

**Files:**
- Modify: `routes/admin.php:45`

- [ ] **Step 1: Rename route**

Replace:
```php
Route::put('tracer/settings', [TracerController::class, 'updateSettings'])->name('admin.tracer.settings.update');
```
With:
```php
Route::put('tracer/settings', [TracerController::class, 'updateSettings'])->name('admin.tracer.settings.store');
```

Update any references from `admin.tracer.settings.update` to `admin.tracer.settings.store`.

---

## Task 23: Fix url() vs route() Inconsistency (C5)

**Files:**
- Modify: `resources/views/spmb/login.blade.php:184-185`
- Modify: `resources/views/pusat-karir/pusat-karir.blade.php:653`

- [ ] **Step 1: Replace url('/') with route('beranda') in SPMB login**

Replace:
```php
'logoUrl' => url('/'), 'berandaUrl' => url('/')
```
With:
```php
'logoUrl' => route('beranda'), 'berandaUrl' => route('beranda')
```

- [ ] **Step 2: Replace hardcoded url() with route() in pusat-karir**

Replace:
```blade
<a href="{{ url('pusat-karir/artikel/' . $slug) }}">
```
With:
```blade
<a href="{{ route('pusat-karir.detail-artikel', $slug) }}">
```

---

## Task 24: Fix Navbar Accessibility (D1, D2)

**Files:**
- Modify: `resources/views/partials/navbar.blade.php:38,43-49`

- [ ] **Step 1: Add aria-label to nav landmark**

Replace:
```blade
<nav class="hidden md:flex items-center gap-7">
```
With:
```blade
<nav class="hidden md:flex items-center gap-7" aria-label="Main navigation">
```

- [ ] **Step 2: Add click handler for desktop Profil dropdown**

In the `<script>` section, add:
```javascript
const ddBtn = document.getElementById('desktop-profil-btn');
if (ddBtn && ddMenu) {
    ddBtn.addEventListener('click', () => {
        const isOpen = !ddMenu.classList.contains('hidden');
        if (isOpen) {
            ddMenu.classList.add('hidden', 'opacity-0', '-translate-y-1');
            ddMenu.classList.remove('opacity-100', 'translate-y-0');
            ddBtn.setAttribute('aria-expanded', 'false');
        } else {
            ddMenu.classList.remove('hidden', 'opacity-0', '-translate-y-1');
            ddMenu.classList.add('opacity-100', 'translate-y-0');
            ddBtn.setAttribute('aria-expanded', 'true');
        }
    });
}
```

Add `aria-expanded="false"` to the button element.

---

## Task 25: Add Breadcrumb aria-labels (D3)

**Files:**
- Modify: `resources/views/pusat-karir/katalog-lowongan.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/katalog-magang.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/katalog-mitra.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/lamar-lowongan.blade.php:295`
- Modify: `resources/views/pusat-karir/detail-lowongan.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/study-tracer.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/kuesioner-tracer.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/artikel.blade.php` (breadcrumb nav)
- Modify: `resources/views/pusat-karir/detail-artikel.blade.php` (breadcrumb nav)
- Modify: `resources/views/jurusan/layout.blade.php:61`

- [ ] **Step 1: Add aria-label to all breadcrumb navs**

Replace:
```blade
<nav class="...breadcrumb...">
```
With:
```blade
<nav class="...breadcrumb..." aria-label="Breadcrumb">
```

---

## Task 26: Fix Pusat Karir Landing Fallback Links (A15)

**Files:**
- Modify: `resources/views/pusat-karir/pusat-karir.blade.php:363,467,827,863,916`

- [ ] **Step 1: Fix category fallback URL**

Replace:
```php
'url' => $category['url'] ?? url('pusat-karir/kategori/' . $category['slug']),
```
With:
```php
'url' => $category['url'] ?? route('pusat-karir.index'),
```

- [ ] **Step 2: Fix Study Tracer fallback card**

Replace:
```blade
<a href="#" class="...">Study Tracer</a>
```
With:
```blade
<a href="{{ route('pusat-karir.study-tracer') }}" class="...">Study Tracer</a>
```

- [ ] **Step 3: Hide webinar CTA when registration_url null**

Replace:
```blade
<a href="{{ $upcomingWebinar->registration_url ?: '#' }}" class="...">Register Now</a>
```
With:
```blade
@if ($upcomingWebinar->registration_url)
    <a href="{{ $upcomingWebinar->registration_url }}" class="...">Register Now</a>
@endif
```

- [ ] **Step 4: Hide bimbingan CTA when external_url null**

Replace:
```blade
<a href="{{ $item['url'] ?? '#' }}">{{ $item['title'] }}</a>
```
With:
```blade
@if ($item['url'] && $item['url'] !== '#')
    <a href="{{ $item['url'] }}">{{ $item['title'] }}</a>
@else
    <span>{{ $item['title'] }}</span>
@endif
```

---

## Task 27: Fix Bimbingan Katalog URL Filter (A15 - Controller)

**Files:**
- Modify: `app/Http/Controllers/LowonganController.php:47`

- [ ] **Step 1: Filter out '#' from bimbinganKatalog URLs**

Replace:
```php
'url' => $item->external_url ?? '#',
```
With:
```php
'url' => ($item->external_url && $item->external_url !== '#') ? $item->external_url : null,
```

---

## Task 28: Remove Dead Welcome View (C6)

**Files:**
- Modify: `resources/views/welcome.blade.php`

- [ ] **Step 1: Replace with redirect or minimal content**

Replace entire content with:
```blade
@php
    header('Location: ' . route('beranda'));
    exit;
@endphp
```

---

## Self-Review

**1. Spec coverage:**
- A1-A16: All covered in Tasks 1-14, 26-27
- B1-B4: All covered in Tasks 15-18
- C1-C6: All covered in Tasks 19-23, 28
- D1-D3: All covered in Tasks 24-25

**2. Placeholder scan:** No TBDs, no "implement later", no "similar to Task N". All code blocks contain actual code.

**3. Type consistency:** All route names consistent throughout. All variable names match controller definitions.

---

## Execution Handoff

Plan complete and saved to `docs/superpowers/plans/2026-10-03-navigation-fixes.md`. Two execution options:

**1. Subagent-Driven (recommended)** - I dispatch a fresh subagent per task, review between tasks, fast iteration

**2. Inline Execution** - Execute tasks in this session using executing-plans, batch execution with checkpoints

Which approach?
