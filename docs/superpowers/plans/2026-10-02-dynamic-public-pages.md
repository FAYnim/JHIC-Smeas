# Dynamic Public Pages Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Wire static public pages (visi-misi, jurusan, informasi) to database-driven content managed from admin dashboard.

**Architecture:** Closure routes in `routes/web.php` query models directly, pass data to Blade views via `compact()`. No new controllers. Settings table stores visi/misi. Artikel model (already has `kategori` column) drives informasi pages. Jurusan page shows aggregate stats from `lowongans`, `alumnis`, `mitra_perusahaans`.

**Tech Stack:** Laravel 13, Blade, SQLite/MySQL, PHPUnit

---

## File Structure

| File | Action | Responsibility |
|---|---|---|
| `routes/web.php` | Modify | Query DB, pass data to visi-misi/jurusan/informasi views |
| `resources/views/visi-misi.blade.php` | Modify | Display dynamic visi/misi from settings |
| `resources/views/jurusan/index.blade.php` | Modify | Display stats from DB |
| `resources/views/informasi.blade.php` | Modify | Loop artikel + pengumuman from DB |
| `resources/views/informasi-prestasi.blade.php` | Modify | Loop artikel kategori prestasi |
| `resources/views/informasi-akademik.blade.php` | Modify | Loop artikel kategori akademik |
| `resources/views/admin/settings/edit.blade.php` | Modify | Add profil section (visi/misi textareas) |
| `app/Http/Controllers/Admin/SettingsController.php` | Modify | Handle profil.visi/profil.misi save |
| `database/seeders/SettingsSeeder.php` | Modify | Seed default profil.visi/profil.misi |
| `tests/Feature/PublicPagesTest.php` | Create | Test dynamic content renders |

---

## Task 1: Seed Default Visi & Misi Settings

**Files:**
- Modify: `database/seeders/SettingsSeeder.php`

- [x] **Step 1: Add profil keys to seeder**

Open `database/seeders/SettingsSeeder.php`. Add the following inside the `run()` method, after existing settings:

```php
Setting::set('profil.visi', 'Terwujudnya SMK Negeri 1 Surabaya Yang Berkarakter Dan Unggul.', 'profil');
Setting::set('profil.misi', 'Meningkatkan kompetensi peserta didik sesuai standar kompetensi lulusan dan berkarakter profil pelajar Pancasila.', 'profil');
```

- [x] **Step 2: Run seeder**

```bash
php artisan db:seed --class=SettingsSeeder
```

Expected: No errors.

- [x] **Step 3: Commit**

```bash
git add database/seeders/SettingsSeeder.php
git commit -m "feat: seed default visi-misi settings"
```

---

## Task 2: Update Visi-Misi Route & View

**Files:**
- Modify: `routes/web.php:20-22`
- Modify: `resources/views/visi-misi.blade.php`

- [x] **Step 1: Update route to query settings**

In `routes/web.php`, replace the `/visi-misi` closure:

```php
Route::get('/visi-misi', function () {
    $visi = Setting::get('profil.visi', '');
    $misi = Setting::get('profil.misi', '');

    return view('visi-misi', compact('visi', 'misi'));
})->name('visi-misi');
```

Add `use App\Models\Setting;` at the top of `routes/web.php` (after existing `use` statements).

- [x] **Step 2: Update view to use dynamic content**

In `resources/views/visi-misi.blade.php`, replace the hardcoded visi text (line 139):

```blade
<h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-[#023775] leading-snug lg:leading-tight">
    {{ $visi }}
</h2>
```

Replace the hardcoded misi text (line 169, inside the first misi card):

```blade
<h3 class="text-base sm:text-lg font-extrabold text-[#013572] group-hover:text-blue-700 transition-colors leading-snug">
    {{ $misi }}
</h3>
```

Note: The remaining 4 misi cards (02-05) stay hardcoded for now — they contain distinct content that would need separate settings keys. Only misi 01 uses the dynamic `$misi` value.

- [x] **Step 3: Test**

```bash
php artisan test --filter=visi-misi
```

Expected: PASS (page returns 200, contains dynamic text).

- [x] **Step 4: Commit**

```bash
git add routes/web.php resources/views/visi-misi.blade.php
git commit -m "feat: wire visi-misi page to settings"
```

---

## Task 3: Update Jurusan Route & View with Stats

**Files:**
- Modify: `routes/web.php:45-47`
- Create: `resources/views/jurusan/index.blade.php`

- [x] **Step 1: Update route to query stats**

In `routes/web.php`, replace the `/jurusan` closure:

```php
Route::get('/jurusan', function () {
    $totalLowongan = Lowongan::where('is_published', true)->count();
    $totalAlumni = Alumni::count();
    $totalMitra = MitraPerusahaan::count();

    return view('jurusan.index', compact('totalLowongan', 'totalAlumni', 'totalMitra'));
})->name('jurusan');
```

Add `use App\Models\Lowongan;`, `use App\Models\Alumni;`, `use App\Models\MitraPerusahaan;` at the top.

- [x] **Step 2: Create jurusan index view**

Create `resources/views/jurusan/index.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurusan — SMK Negeri 1 Surabaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased flex flex-col min-h-screen">
    @include('partials.navbar', ['activePage' => 'jurusan', 'berandaUrl' => route('pusat-karir.index')])

    <main class="flex-grow">
        <section class="relative bg-gradient-to-br from-[#024089] via-[#0452b0] to-[#013572] text-white pt-14 pb-28 md:pt-20 md:pb-36 overflow-hidden">
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-5">Program Keahlian</h1>
                <p class="text-base sm:text-lg text-blue-100/90 max-w-2xl">SMK Negeri 1 Surabaya memiliki 9 program keahlian yang siap menghadapi tantangan industri.</p>
            </div>
        </section>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 md:-mt-20 z-10 pb-20">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600">{{ $totalLowongan }}</div>
                    <div class="text-sm text-slate-500 mt-1">Lowongan Aktif</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600">{{ $totalAlumni }}</div>
                    <div class="text-sm text-slate-500 mt-1">Alumni</div>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center shadow-sm">
                    <div class="text-3xl font-extrabold text-blue-600">{{ $totalMitra }}</div>
                    <div class="text-sm text-slate-500 mt-1">Mitra Industri</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $jurusans = [
                        ['slug' => 'akuntansi', 'nama' => 'Akuntansi', 'kode' => 'AK'],
                        ['slug' => 'bisnis-daring-dan-pemasaran', 'nama' => 'Bisnis Daring dan Pemasaran', 'kode' => 'BDP'],
                        ['slug' => 'desain-komunikasi-visual', 'nama' => 'Desain Komunikasi Visual', 'kode' => 'DKV'],
                        ['slug' => 'manajemen-logistik', 'nama' => 'Manajemen Logistik', 'kode' => 'ML'],
                        ['slug' => 'manajemen-perkantoran', 'nama' => 'Manajemen Perkantoran', 'kode' => 'MP'],
                        ['slug' => 'perhotelan', 'nama' => 'Perhotelan', 'kode' => 'HT'],
                        ['slug' => 'produksi-siaran-program-pertelevisian', 'nama' => 'Produksi Siaran Program Pertelevisian', 'kode' => 'PSPP'],
                        ['slug' => 'rekayasa-perangkat-lunak', 'nama' => 'Rekayasa Perangkat Lunak', 'kode' => 'RPL'],
                        ['slug' => 'teknik-komputer-dan-jaringan', 'nama' => 'Teknik Komputer dan Jaringan', 'kode' => 'TKJ'],
                    ];
                @endphp
                @foreach ($jurusans as $jurusan)
                    <a href="{{ route('jurusan.detail', $jurusan['slug']) }}" class="bg-white rounded-2xl border border-slate-200 p-6 hover:border-blue-300 hover:shadow-md transition-all">
                        <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-lg mb-4">{{ $jurusan['kode'] }}</div>
                        <h3 class="text-base font-bold text-slate-900">{{ $jurusan['nama'] }}</h3>
                    </a>
                @endforeach
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
```

- [x] **Step 3: Test**

```bash
php artisan test --filter=jurusan
```

Expected: PASS.

- [x] **Step 4: Commit**

```bash
git add routes/web.php resources/views/jurusan/index.blade.php
git commit -m "feat: wire jurusan page to DB stats"
```

---

## Task 4: Update Informasi Routes & Views

**Files:**
- Modify: `routes/web.php:53-63`
- Modify: `resources/views/informasi.blade.php`
- Modify: `resources/views/informasi-prestasi.blade.php`
- Modify: `resources/views/informasi-akademik.blade.php`

- [x] **Step 1: Update routes**

In `routes/web.php`, replace the 3 informasi closures:

```php
Route::get('/informasi', function () {
    $artikels = Artikel::where('kategori', 'berita')->latest('published_at')->limit(6)->get();
    $pengumumans = Pengumuman::latest()->limit(5)->get();

    return view('informasi', compact('artikels', 'pengumumans'));
})->name('informasi');

Route::get('/informasi/prestasi', function () {
    $artikels = Artikel::where('kategori', 'prestasi')->latest('published_at')->limit(6)->get();
    $pengumumans = Pengumuman::latest()->limit(5)->get();

    return view('informasi-prestasi', compact('artikels', 'pengumumans'));
})->name('informasi.prestasi');

Route::get('/informasi/akademik', function () {
    $artikels = Artikel::where('kategori', 'akademik')->latest('published_at')->limit(6)->get();
    $pengumumans = Pengumuman::latest()->limit(5)->get();

    return view('informasi-akademik', compact('artikels', 'pengumumans'));
})->name('informasi.akademik');
```

Add `use App\Models\Artikel;` and `use App\Models\Pengumuman;` at the top.

- [x] **Step 2: Update informasi.blade.php to loop artikel**

In `resources/views/informasi.blade.php`, replace the hardcoded berita section (lines 257-297) with:

```blade
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
    @forelse ($artikels as $artikel)
        <div class="berita-card group bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:border-blue-300">
            <div class="aspect-[16/10] overflow-hidden bg-slate-200">
                @if ($artikel->image_path)
                    <img src="{{ asset('storage/' . $artikel->image_path) }}" alt="{{ $artikel->title }}" class="berita-img w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-slate-200 to-slate-300"></div>
                @endif
            </div>
            <div class="p-5 sm:p-6">
                <h3 class="text-base font-bold text-slate-900 leading-snug group-hover:text-blue-700 transition-colors">
                    {{ $artikel->title }}
                </h3>
            </div>
        </div>
    @empty
        <p class="text-sm text-slate-500 col-span-3">Belum ada artikel.</p>
    @endforelse
</section>
```

Also replace the hardcoded event list (lines 194-242) with pengumuman loop:

```blade
<div class="flex-1 space-y-4">
    @forelse ($pengumumans as $pengumuman)
        <div class="event-card flex items-center gap-4 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200/80 bg-slate-50/50 hover:bg-white hover:border-blue-200">
            <div class="flex-1 min-w-0">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 leading-snug mb-1">{{ $pengumuman->judul }}</h3>
                <p class="text-xs sm:text-sm text-slate-500">{{ $pengumuman->created_at->format('d M Y') }}</p>
            </div>
        </div>
    @empty
        <p class="text-sm text-slate-500">Belum ada pengumuman.</p>
    @endforelse
</div>
```

- [x] **Step 3: Update informasi-prestasi.blade.php**

Same pattern as Step 2 — replace hardcoded content with `@forelse ($artikels as $artikel)` loop. Use the same card structure.

- [x] **Step 4: Update informasi-akademik.blade.php**

Same pattern — replace hardcoded content with `@forelse ($artikels as $artikel)` loop.

- [x] **Step 5: Test**

```bash
php artisan test --filter=informasi
```

Expected: PASS.

- [x] **Step 6: Commit**

```bash
git add routes/web.php resources/views/informasi.blade.php resources/views/informasi-prestasi.blade.php resources/views/informasi-akademik.blade.php
git commit -m "feat: wire informasi pages to artikel + pengumuman from DB"
```

---

## Task 5: Add Profil Section to Settings Admin

**Files:**
- Modify: `resources/views/admin/settings/edit.blade.php`
- Modify: `app/Http/Controllers/Admin/SettingsController.php`

- [x] **Step 1: Add profil section to settings form**

In `resources/views/admin/settings/edit.blade.php`, add a new section after the "Identitas Lembaga" section (after line 40):

```blade
<div>
    <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 mb-4 pb-2 border-b">
        Profil Sekolah
    </h3>
    <div class="space-y-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Visi Sekolah</label>
            <textarea name="settings[profil.visi]" rows="3"
                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ $settings['profil.visi'] ?? '' }}</textarea>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Misi Sekolah</label>
            <textarea name="settings[profil.misi]" rows="3"
                class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ $settings['profil.misi'] ?? '' }}</textarea>
        </div>
    </div>
</div>
```

- [x] **Step 2: Update SettingsController to handle dotted keys**

In `app/Http/Controllers/Admin/SettingsController.php`, find the `update` method. Replace the settings-saving logic with:

```php
public function update(Request $request): RedirectResponse
{
    $settings = $request->input('settings', []);

    foreach ($settings as $key => $value) {
        Setting::set($key, $value);
    }

    return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
}
```

- [x] **Step 3: Test**

```bash
php artisan test --filter=settings
```

Expected: PASS.

- [x] **Step 4: Commit**

```bash
git add resources/views/admin/settings/edit.blade.php app/Http/Controllers/Admin/SettingsController.php
git commit -m "feat: add profil visi-misi section to admin settings"
```

---

## Task 6: Feature Tests

**Files:**
- Create: `tests/Feature/PublicPagesTest.php`

- [x] **Step 1: Write feature tests**

Create `tests/Feature/PublicPagesTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\Artikel;
use App\Models\Lowongan;
use App\Models\Pengumuman;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_visi_misi_page_displays_dynamic_content(): void
    {
        Setting::set('profil.visi', 'Visi Test Unik', 'profil');
        Setting::set('profil.misi', 'Misi Test Unik', 'profil');

        $response = $this->get(route('visi-misi'));

        $response->assertStatus(200);
        $response->assertSee('Visi Test Unik');
        $response->assertSee('Misi Test Unik');
    }

    public function test_jurusan_page_displays_stats(): void
    {
        Lowongan::factory()->create(['is_published' => true]);
        Lowongan::factory()->create(['is_published' => true]);

        $response = $this->get(route('jurusan'));

        $response->assertStatus(200);
        $response->assertSee('2');
    }

    public function test_informasi_page_displays_artikels(): void
    {
        Artikel::factory()->create(['kategori' => 'berita', 'title' => 'Berita Test Unik']);

        $response = $this->get(route('informasi'));

        $response->assertStatus(200);
        $response->assertSee('Berita Test Unik');
    }

    public function test_informasi_prestasi_page_filters_by_kategori(): void
    {
        Artikel::factory()->create(['kategori' => 'prestasi', 'title' => 'Prestasi Test Unik']);

        $response = $this->get(route('informasi.prestasi'));

        $response->assertStatus(200);
        $response->assertSee('Prestasi Test Unik');
    }

    public function test_informasi_akademik_page_filters_by_kategori(): void
    {
        Artikel::factory()->create(['kategori' => 'akademik', 'title' => 'Akademik Test Unik']);

        $response = $this->get(route('informasi.akademik'));

        $response->assertStatus(200);
        $response->assertSee('Akademik Test Unik');
    }
}
```

- [x] **Step 2: Run tests**

```bash
php artisan test --filter=PublicPagesTest
```

Expected: All 5 tests PASS.

- [x] **Step 3: Commit**

```bash
git add tests/Feature/PublicPagesTest.php
git commit -m "test: add feature tests for dynamic public pages"
```

---

## Self-Review Checklist

- [x] All spec sections have corresponding tasks
- [x] No placeholders or TBDs
- [x] Type consistency: `Artikel`, `Pengumuman`, `Setting`, `Lowongan`, `Alumni`, `MitraPerusahaan` all exist
- [x] Route names match existing pattern (`visi-misi`, `jurusan`, `informasi`, `informasi.prestasi`, `informasi.akademik`)
- [x] `kategori` column already exists in `artikels` table — no migration needed
- [x] `Setting::get()` and `Setting::set()` already exist
