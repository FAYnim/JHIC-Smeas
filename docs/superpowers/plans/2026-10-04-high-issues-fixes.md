# HIGH Issues Fixes Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix 4 audit HIGH issues (beranda hardcoded, sumber rekomendasi dummy, BLUD search client-only, verifikasi NISN mockup) + small search-form fix on branch `fix/high-issues`.

**Architecture:** Follow the house pattern — closure routes pass Eloquent data to Blade, existing controllers get small additions, one new admin CRUD (BKK) for `SumberRekomendasi`. Spec: `docs/superpowers/specs/2026-10-04-high-issues-fixes-design.md`.

**Tech Stack:** Laravel 13, Blade, Tailwind v4, PHPUnit (`php artisan test`), Laravel Pint.

---

## File Structure

| Action | File | Responsibility |
|---|---|---|
| Modify | `routes/web.php` | Beranda closure data, route `pusat-karir.verifikasi-nisn` |
| Modify | `database/seeders/SettingSeeder.php` | 3 key `profil.prakata_*` |
| Modify | `database/seeders/DatabaseSeeder.php` | Register `SumberRekomendasiSeeder` |
| Create | `database/seeders/SumberRekomendasiSeeder.php` | 5 contoh entri |
| Create | `database/migrations/2026_10_04_000001_create_sumber_rekomendasis_table.php` | Tabel sumber rekomendasi |
| Create | `app/Models/SumberRekomendasi.php` | Model + `image_url` accessor |
| Create | `app/Http/Controllers/Admin/Bkk/SumberRekomendasiController.php` | Admin index/store/destroy |
| Create | `resources/views/admin/bkk/sumber-rekomendasi/index.blade.php` | Admin UI |
| Modify | `routes/admin.php` | 3 route sumber-rekomendasi (role:bkk) |
| Modify | `app/Support/AdminMenu.php` | Menu sidebar "Sumber Rekomendasi" |
| Modify | `resources/views/admin/layout.blade.php` | Icon case `link` |
| Modify | `resources/views/admin/settings/edit.blade.php` | 3 input prakata |
| Modify | `resources/views/index.blade.php` | Prakata, statistik, carousel guru, berita empty, search form |
| Modify | `resources/views/pusat-karir/pusat-karir.blade.php` | Sumber rekomendasi objek-based |
| Modify | `app/Http/Controllers/LowonganController.php` | Pass `$sumberRekomendasi`, `verifikasiNisn()`, guard `exists` |
| Modify | `app/Http/Controllers/BludController.php` | Backend `?q=` search |
| Modify | `resources/views/blud/index.blade.php` | Form GET wrapper |
| Modify | `resources/views/pusat-karir/lamar-lowongan.blade.php` | JS fetch verifikasi NISN |
| Create | `tests/Feature/LowonganVerifikasiNisnTest.php` | Endpoint tests |
| Create | `tests/Feature/SumberRekomendasiPublicTest.php` | Public wiring test |
| Create | `tests/Feature/Admin/Bkk/SumberRekomendasiCrudTest.php` | Admin CRUD tests |
| Modify | `tests/Feature/PublicPagesTest.php` | Beranda tests |
| Modify | `tests/Feature/BludProdukTest.php` | Search tests |
| Modify | `tests/Feature/LowonganApplyValidationTest.php` | Seed CalonSiswa + guard test |
| Modify | `tests/Feature/LowonganApplyUploadTest.php` | Seed CalonSiswa |
| Modify | `tests/Feature/ExampleTest.php` | Add `RefreshDatabase` |

**Baseline (sebelum perubahan):** 183 tests, 3 gagal — `ExampleTest` (fix di Task 4), `PublicPagesTest::test_visi_misi_page_displays_dynamic_content` (di luar scope), `MitraCrudTest::test_store_with_invalid_data_shows_field_errors` (di luar scope). Syarat selesai: tidak ada failure BARU; semua test baru hijau.

---

### Task 1: Beranda — Prakata via Setting (HIGH-01 bagian a)

**Files:**
- Test: `tests/Feature/PublicPagesTest.php`
- Modify: `database/seeders/SettingSeeder.php:29-31`
- Modify: `resources/views/admin/settings/edit.blade.php:42-59`
- Modify: `routes/web.php:21-25`
- Modify: `resources/views/index.blade.php:647-669`

- [ ] **Step 1: Tulis test gagal**

Tambah ke `tests/Feature/PublicPagesTest.php`:

```php
public function test_beranda_displays_prakata_from_settings(): void
{
    Setting::set('profil.prakata_nama', 'Kepala Sekolah Test Unik', 'profil');

    $response = $this->get(route('beranda'));

    $response->assertOk();
    $response->assertSee('Kepala Sekolah Test Unik');
}
```

- [ ] **Step 2: Jalankan — EXPECT FAIL**

Run: `php artisan test tests/Feature/PublicPagesTest.php --filter=test_beranda_displays_prakata_from_settings`
Expected: FAIL (halaman menampilkan nama kepala sekolah hardcoded "Dr. Drs. Anton Sujarwo, M.Pd.", bukan "Kepala Sekolah Test Unik").

- [ ] **Step 3: Tambah 3 key Setting di seeder**

`database/seeders/SettingSeeder.php` — sisipkan setelah baris profil.misi (sebelum `];`):

```php
['key' => 'profil.prakata_nama', 'value' => 'Dr. Drs. Anton Sujarwo, M.Pd.', 'group' => 'profil'],
['key' => 'profil.prakata_quote', 'value' => 'Era globalisasi membawa perubahan yang cepat dalam berbagai aspek kehidupan. Oleh karena itu, pendidikan memiliki peran penting dalam menyiapkan sumber daya manusia yang mampu menghadapi perubahan tersebut. Sekolah perlu memiliki arah pengembangan yang jelas dan berkelanjutan, sekaligus mampu menyesuaikan diri dengan kebutuhan dan permasalahan masyarakat saat ini.', 'group' => 'profil'],
['key' => 'profil.prakata_foto', 'value' => 'images/Group 198.png', 'group' => 'profil'],
```

- [ ] **Step 4: Field admin untuk prakata**

`resources/views/admin/settings/edit.blade.php` — di dalam "Profil Sekolah" (setelah input Misi, baris ~57), sisipkan:

```blade
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah (Prakata)</label>
        <input type="text" name="settings[profil.prakata_nama]"
            value="{{ $settings['profil.prakata_nama'] ?? 'Dr. Drs. Anton Sujarwo, M.Pd.' }}"
            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
    </div>
    <div>
        <label class="block text-xs font-bold text-slate-700 mb-1">Foto Kepala Sekolah (path gambar)</label>
        <input type="text" name="settings[profil.prakata_foto]"
            value="{{ $settings['profil.prakata_foto'] ?? 'images/Group 198.png' }}"
            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
    </div>
</div>
<div class="mt-4">
    <label class="block text-xs font-bold text-slate-700 mb-1">Isi Prakata Kepala Sekolah</label>
    <textarea name="settings[profil.prakata_quote]" rows="4"
        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">{{ $settings['profil.prakata_quote'] ?? '' }}</textarea>
</div>
```

(`SettingController::update` menyimpan semua key `settings[...]` apa adanya — tanpa perubahan controller.)

- [ ] **Step 5: Route beranda pass `$prakata`**

`routes/web.php` — tambah import `use App\Models\Setting;` (blok import, urut setelah `Pengumuman`… tepatnya `use App\Models\StrukturOrganisasi;` lalu `use App\Models\Setting;` tidak berurutan alfabet; tempatkan `Setting` sebelum `StrukturOrganisasi`), ganti closure:

```php
Route::get('/', function () {
    $artikels = Artikel::latest('published_at')->take(4)->get();
    $prakata = [
        'nama' => Setting::get('profil.prakata_nama', 'Dr. Drs. Anton Sujarwo, M.Pd.'),
        'quote' => Setting::get('profil.prakata_quote', 'Era globalisasi membawa perubahan yang cepat dalam berbagai aspek kehidupan. Oleh karena itu, pendidikan memiliki peran penting dalam menyiapkan sumber daya manusia yang mampu menghadapi perubahan tersebut. Sekolah perlu memiliki arah pengembangan yang jelas dan berkelanjutan, sekaligus mampu menyesuaikan diri dengan kebutuhan dan permasalahan masyarakat saat ini.'),
        'foto' => Setting::get('profil.prakata_foto', 'images/Group 198.png'),
    ];

    return view('index', compact('artikels', 'prakata'));
})->name('beranda');
```

- [ ] **Step 6: Blade prakata baca `$prakata`**

`resources/views/index.blade.php`:

Baris 651-655 (paragraf quote) ganti isi teks hardcoded menjadi:

```blade
<p
    style="font-size:clamp(0.95rem, 1.5vw, 1.1rem); color:#334155; font-style:italic; font-weight:600; line-height:1.9; text-align:justify; margin:0;">
    {{ $prakata['quote'] }}
</p>
```

Baris 663-668 (foto + nama) ganti menjadi:

```blade
<img src="{{ asset($prakata['foto']) }}" alt="{{ $prakata['nama'] }}"
    style="width:260px; max-width:100%; height:auto; display:block;">
<p
    style="margin-top:12px; font-size:0.95rem; font-weight:700; color:#0b192c; text-align:center;">
    {{ $prakata['nama'] }}
</p>
```

- [ ] **Step 7: Jalankan — EXPECT PASS**

Run: `php artisan test tests/Feature/PublicPagesTest.php --filter=test_beranda_displays_prakata_from_settings`
Expected: PASS.

- [ ] **Step 8: Commit**

```bash
git add database/seeders/SettingSeeder.php resources/views/admin/settings/edit.blade.php routes/web.php resources/views/index.blade.php tests/Feature/PublicPagesTest.php
git commit -m "feat(beranda): prakata kepala sekolah dari Setting"
```

---

### Task 2: Beranda — Carousel Guru + Statistik + Empty Berita (HIGH-01 bagian b)

**Files:**
- Modify: `routes/web.php:21-30` (closure)
- Modify: `resources/views/index.blade.php:714-741, 918-976, 1090-1102`

- [ ] **Step 1: Tulis test gagal (guru + empty berita)**

Tambah ke `tests/Feature/PublicPagesTest.php` (import `App\Models\Guru`):

```php
public function test_beranda_displays_gurus_from_database(): void
{
    Guru::create([
        'nama' => 'Guru Carousel Khusus, S.Pd.',
        'jabatan' => 'Guru Bahasa Indonesia',
        'mapel' => 'Bahasa Indonesia',
        'kategori' => 'guru',
        'urutan' => 1,
        'is_active' => true,
    ]);

    $response = $this->get(route('beranda'));

    $response->assertOk();
    $response->assertSee('Guru Carousel Khusus, S.Pd.');
}

public function test_beranda_shows_empty_state_when_no_artikels(): void
{
    $response = $this->get(route('beranda'));

    $response->assertOk();
    $response->assertSee('Belum ada berita.');
}
```

Run: `php artisan test tests/Feature/PublicPagesTest.php --filter=test_beranda_displays_gurus_from_database`
Expected: FAIL (carousel masih hardcoded 4 nama statis).

- [ ] **Step 2: Route pass `$gurus` + `$gurusCount`**

`routes/web.php` — di closure beranda, tambah setelah `$artikels`:

```php
$gurus = Guru::where('kategori', 'guru')->where('is_active', true)
    ->orderBy('urutan')->limit(4)->get();
$gurusCount = Guru::where('is_active', true)->count();
```

Ubah `return view('index', compact('artikels', 'prakata'));` menjadi:

```php
return view('index', compact('artikels', 'prakata', 'gurus', 'gurusCount'));
```

- [ ] **Step 3: Statistik "Pengajar" dinamis**

`resources/views/index.blade.php` baris 723-731 ganti menjadi:

```blade
{{-- ponytail: jurusan & siswa masih hardcoded — tak ada tabel jurusans/siswas; upgrade path: buat tabel + hitung di route beranda --}}
<div class="stat-card stat-card-2">
    <div class="stat-card-inner" style="text-align:center;">
        <span
            style="font-size:2.6rem; font-weight:800; color:#024089; line-height:1; display:block;">{{ $gurusCount }}</span>
        <span
            style="font-size:0.875rem; font-weight:700; color:#024089; margin-top:8px; display:block;">Pengajar</span>
    </div>
</div>
```

- [ ] **Step 4: Carousel guru → loop DB**

`resources/views/index.blade.php` — ganti blok 4 kartu hardcoded (baris 918-976, dari `{{-- Teacher Card 1: Sari Okta --}}` sampai kartu ke-4 sebelum `</div>` penutup track) menjadi:

```blade
@forelse ($gurus as $guru)
    <div style="flex:0 0 280px;text-align:center;">
        <div
            style="position:relative;width:280px;height:340px;border-radius:16px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.1);margin-bottom:16px;background:linear-gradient(135deg,#1a8cff,#024089);">
            @if ($guru->foto_url)
                <img src="{{ $guru->foto_url }}" alt="{{ $guru->nama }}"
                    style="width:100%;height:100%;object-fit:cover;object-position:top;transition:transform 0.5s ease;">
            @else
                <div
                    style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;color:#fff;font-size:3.5rem;font-weight:800;">
                    {{ $guru->initials }}</div>
            @endif
            <div
                style="position:absolute;inset:0;background:linear-gradient(to top, rgba(15,23,42,0.5), transparent 40%);">
            </div>
        </div>
        <p style="font-size:0.9rem;font-weight:700;color:#0f172a;">{{ $guru->nama }}</p>
        <p style="font-size:0.8rem;font-weight:500;color:#64748b;">{{ $guru->mapel ?? $guru->jabatan }}</p>
    </div>
@empty
    <p style="flex:1;text-align:center;padding:48px 16px;font-size:0.9rem;color:#64748b;">Belum ada data guru.</p>
@endforelse
```

- [ ] **Step 5: Empty state berita**

`resources/views/index.blade.php` — tutup loop berita dengan `@empty`, ganti baris 1102 `@endforeach` menjadi:

```blade
                    @empty
                        <p class="text-sm text-slate-500 col-span-full text-center">Belum ada berita.</p>
                    @endforelse
```

(Dan `@foreach ($artikels->take(4) as $artikel)` baris 1090 menjadi `@forelse ($artikels->take(4) as $artikel)`.)

- [ ] **Step 6: Jalankan — EXPECT PASS (2 test + test lama)**

Run: `php artisan test tests/Feature/PublicPagesTest.php`
Expected: semua PASS kecuali `test_visi_misi_page_displays_dynamic_content` (baseline pre-existing, di luar scope).

- [ ] **Step 7: Commit**

```bash
git add routes/web.php resources/views/index.blade.php tests/Feature/PublicPagesTest.php
git commit -m "feat(beranda): carousel guru & statistik pengajar dari database"
```

---

### Task 3: Search form jurusan di beranda (HIGH-02 mini fix)

**Files:**
- Test: `tests/Feature/PublicPagesTest.php`
- Modify: `resources/views/index.blade.php:1016-1029`

- [ ] **Step 1: Test form (gagal dulu)**

Tambah ke `tests/Feature/PublicPagesTest.php`:

```php
public function test_beranda_search_form_targets_jurusan(): void
{
    $response = $this->get(route('beranda'));

    $response->assertOk();
    $response->assertSee('action="'.route('jurusan').'"', false);
    $response->assertSee('name="q"', false);
}
```

Run: `php artisan test tests/Feature/PublicPagesTest.php --filter=test_beranda_search_form_targets_jurusan`
Expected: FAIL (input tanpa form).

- [ ] **Step 2: Bungkus input jadi form GET**

`resources/views/index.blade.php` — ganti baris 1016-1029 (div `.search-glow` yang memuat input) menjadi:

```blade
<div style="max-width:640px;margin:0 auto 32px;" class="fade-up">
    <form action="{{ route('jurusan') }}" method="GET" class="search-glow"
        style="display:flex;align-items:center;background:#fff;border-radius:12px;border:2px solid #e2e8f0;box-shadow:0 1px 2px rgba(0,0,0,0.04);overflow:hidden;transition:all 0.3s ease;">
        <div style="padding:0 12px 0 20px;">
            <svg style="width:20px;height:20px;color:#94a3b8;" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input type="text" name="q" value="{{ request('q') }}"
            placeholder="Senang di JHIK, coba pengolahan di bawah ini"
            style="flex:1;padding:16px 16px 16px 0;font-size:0.875rem;color:#334155;border:none;outline:none;background:transparent;">
    </form>
</div>
```

- [ ] **Step 3: Jalankan — EXPECT PASS**

Run: `php artisan test tests/Feature/PublicPagesTest.php --filter=test_beranda_search_form_targets_jurusan`
Expected: PASS.

- [ ] **Step 4: Commit**

```bash
git add resources/views/index.blade.php tests/Feature/PublicPagesTest.php
git commit -m "fix(beranda): search jurusan dibungkus form GET"
```

---

### Task 4: Baseline — ExampleTest pakai RefreshDatabase

**Files:**
- Modify: `tests/Feature/ExampleTest.php`

- [ ] **Step 1: Tambah trait**

`tests/Feature/ExampleTest.php` — tambah import `use Illuminate\Foundation\Testing\RefreshDatabase;` dan di dalam class `use RefreshDatabase;` (route `/` kini query tabel `artikels`; tanpa trait → 500).

- [ ] **Step 2: Jalankan**

Run: `php artisan test tests/Feature/ExampleTest.php`
Expected: PASS.

- [ ] **Step 3: Commit**

```bash
git add tests/Feature/ExampleTest.php
git commit -m "test: ExampleTest pakai RefreshDatabase (route beranda query DB)"
```

---

### Task 5: Tabel + Model + Seeder SumberRekomendasi (HIGH-03 bagian a)

**Files:**
- Create: `database/migrations/2026_10_04_000001_create_sumber_rekomendasis_table.php`
- Create: `app/Models/SumberRekomendasi.php`
- Create: `database/seeders/SumberRekomendasiSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`

- [ ] **Step 1: Migrasi**

Buat `database/migrations/2026_10_04_000001_create_sumber_rekomendasis_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sumber_rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->string('kategori')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sumber_rekomendasis');
    }
};
```

(Nama tabel = `Str::plural('sumber_rekomendasi')` = `sumber_rekomendasis` — default Laravel, tanpa `$table` custom di model.)

- [ ] **Step 2: Model**

Buat `app/Models/SumberRekomendasi.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SumberRekomendasi extends Model
{
    protected $fillable = [
        'title',
        'url',
        'kategori',
        'image_path',
        'urutan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'urutan' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path);
        }

        return null;
    }
}
```

- [ ] **Step 3: Seeder**

Buat `database/seeders/SumberRekomendasiSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\SumberRekomendasi;
use Illuminate\Database\Seeder;

class SumberRekomendasiSeeder extends Seeder
{
    public function run(): void
    {
        $sources = [
            ['title' => 'LinkedIn Jobs', 'url' => 'https://www.linkedin.com/jobs', 'kategori' => 'Lowongan Kerja', 'urutan' => 1],
            ['title' => 'Glints', 'url' => 'https://glints.com/id', 'kategori' => 'Lowongan Kerja', 'urutan' => 2],
            ['title' => 'Dicoding', 'url' => 'https://www.dicoding.com', 'kategori' => 'Kursus & Sertifikasi', 'urutan' => 3],
            ['title' => 'Dibimbing', 'url' => 'https://www.dibimbing.id', 'kategori' => 'Bimbingan Karir', 'urutan' => 4],
            ['title' => 'JobStreet Indonesia', 'url' => 'https://www.jobstreet.co.id', 'kategori' => 'Lowongan Kerja', 'urutan' => 5],
        ];

        foreach ($sources as $source) {
            SumberRekomendasi::updateOrCreate(['url' => $source['url']], $source + ['is_active' => true]);
        }
    }
}
```

- [ ] **Step 4: Daftarkan di DatabaseSeeder**

`database/seeders/DatabaseSeeder.php` — tambah setelah `$this->call(SettingSeeder::class);`:

```php
        $this->call(SumberRekomendasiSeeder::class);
```

- [ ] **Step 5: Cek migrasi + seeder jalan**

Run: `php artisan migrate:fresh --seed`
Expected: tanpa error, tabel `sumber_rekomendasis` terisi 5 baris.

- [ ] **Step 6: Commit**

```bash
git add database/migrations/2026_10_04_000001_create_sumber_rekomendasis_table.php app/Models/SumberRekomendasi.php database/seeders/SumberRekomendasiSeeder.php database/seeders/DatabaseSeeder.php
git commit -m "feat: tabel & model SumberRekomendasi dengan seeder"
```

---

### Task 6: Admin CRUD Sumber Rekomendasi (HIGH-03 bagian b)

**Files:**
- Test: `tests/Feature/Admin/Bkk/SumberRekomendasiCrudTest.php` (baru)
- Create: `app/Http/Controllers/Admin/Bkk/SumberRekomendasiController.php`
- Create: `resources/views/admin/bkk/sumber-rekomendasi/index.blade.php`
- Modify: `routes/admin.php:25-47` (grup `role:bkk`)
- Modify: `app/Support/AdminMenu.php` (item grup Pusat Karir)
- Modify: `resources/views/admin/layout.blade.php` (case icon)

- [ ] **Step 1: Tulis test gagal**

Buat `tests/Feature/Admin/Bkk/SumberRekomendasiCrudTest.php`:

```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\SumberRekomendasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SumberRekomendasiCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    private User $bkk;

    private User $humas;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $this->bkk = User::factory()->create(['role' => User::ROLE_BKK]);
        $this->humas = User::factory()->create(['role' => User::ROLE_HUMAS]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.sumber-rekomendasi.index'))->assertRedirect(route('login'));
    }

    public function test_humas_is_forbidden(): void
    {
        $this->actingAs($this->humas)->get(route('admin.sumber-rekomendasi.index'))->assertForbidden();
    }

    public function test_bkk_and_admin_can_access_index(): void
    {
        $this->actingAs($this->bkk)->get(route('admin.sumber-rekomendasi.index'))->assertOk();
        $this->actingAs($this->admin)->get(route('admin.sumber-rekomendasi.index'))->assertOk();
    }

    public function test_store_creates_record(): void
    {
        $response = $this->actingAs($this->bkk)->post(route('admin.sumber-rekomendasi.store'), [
            'title' => 'Portal Karir Unik',
            'url' => 'https://example.com/karir',
            'kategori' => 'Lowongan Kerja',
        ]);

        $response->assertRedirect(route('admin.sumber-rekomendasi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('sumber_rekomendasis', [
            'title' => 'Portal Karir Unik',
            'url' => 'https://example.com/karir',
        ]);
    }

    public function test_store_with_invalid_url_shows_error(): void
    {
        $this->actingAs($this->bkk)
            ->from(route('admin.sumber-rekomendasi.index'))
            ->post(route('admin.sumber-rekomendasi.store'), [
                'title' => 'Tanpa URL',
                'url' => 'bukan-url',
            ])
            ->assertSessionHasErrors('url');

        $this->assertDatabaseCount('sumber_rekomendasis', 0);
    }

    public function test_destroy_removes_record(): void
    {
        $sumber = SumberRekomendasi::create([
            'title' => 'Akan Dihapus',
            'url' => 'https://example.com/hapus',
            'urutan' => 1,
            'is_active' => true,
        ]);

        $this->actingAs($this->bkk)
            ->delete(route('admin.sumber-rekomendasi.destroy', $sumber))
            ->assertRedirect(route('admin.sumber-rekomendasi.index'));

        $this->assertDatabaseMissing('sumber_rekomendasis', ['id' => $sumber->id]);
    }
}
```

- [ ] **Step 2: Jalankan — EXPECT FAIL (route tidak ada)**

Run: `php artisan test tests/Feature/Admin/Bkk/SumberRekomendasiCrudTest.php`
Expected: FAIL — RouteNotFoundException `admin.sumber-rekomendasi.index`.

- [ ] **Step 3: Controller**

Buat `app/Http/Controllers/Admin/Bkk/SumberRekomendasiController.php`:

```php
<?php

namespace App\Http\Controllers\Admin\Bkk;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\SumberRekomendasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SumberRekomendasiController extends Controller
{
    use HandlesUploads;

    public function index(): View
    {
        $sumbers = SumberRekomendasi::orderBy('urutan')->get();

        return view('admin.bkk.sumber-rekomendasi.index', compact('sumbers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'url' => ['required', 'url', 'max:500'],
            'kategori' => ['nullable', 'string', 'max:60'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $this->uploadFile($request->file('image'), 'sumber-rekomendasi');
        }

        $validated['urutan'] = (SumberRekomendasi::max('urutan') ?? 0) + 1;
        SumberRekomendasi::create($validated);

        return redirect()->route('admin.sumber-rekomendasi.index')
            ->with('success', 'Sumber rekomendasi berhasil ditambahkan.');
    }

    public function destroy(SumberRekomendasi $sumberRekomendasi): RedirectResponse
    {
        $this->deleteFile($sumberRekomendasi->image_path);
        $sumberRekomendasi->delete();

        return redirect()->route('admin.sumber-rekomendasi.index')
            ->with('success', 'Sumber rekomendasi berhasil dihapus.');
    }
}
```

- [ ] **Step 4: Routes (explicit, tanpa resource magic)**

`routes/admin.php` — import tambahan `use App\Http\Controllers\Admin\Bkk\SumberRekomendasiController;` (urutkan di blok import Bkk), dan di dalam grup `Route::middleware('role:bkk')` (setelah blok tracer, sebelum `});` penutup grup) sisipkan:

```php
    Route::get('sumber-rekomendasi', [SumberRekomendasiController::class, 'index'])->name('sumber-rekomendasi.index');
    Route::post('sumber-rekomendasi', [SumberRekomendasiController::class, 'store'])->name('sumber-rekomendasi.store');
    Route::delete('sumber-rekomendasi/{sumberRekomendasi}', [SumberRekomendasiController::class, 'destroy'])->name('sumber-rekomendasi.destroy');
```

- [ ] **Step 5: Menu sidebar + icon**

`app/Support/AdminMenu.php` — sisipkan item setelah 'Bimbingan Karir' (baris ~61):

```php
        [
            'group' => 'Pusat Karir',
            'label' => 'Sumber Rekomendasi',
            'route' => 'admin.sumber-rekomendasi.index',
            'icon' => 'link',
            'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
        ],
```

`resources/views/admin/layout.blade.php` — sisipkan case sebelum `@default` (baris ~221):

```blade
                                @case('link')
                                    <x-lucide-link />
                                @break
```

- [ ] **Step 6: View admin**

Buat `resources/views/admin/bkk/sumber-rekomendasi/index.blade.php`:

```blade
@extends('admin.layout')

@section('title', 'Sumber Rekomendasi')
@section('page-title', 'Sumber Rekomendasi')

@section('content')
    <div class="mb-6">
        <h2 class="text-lg font-bold text-slate-900">Sumber Rekomendasi Karir</h2>
        <p class="text-xs text-slate-500">Tautan eksternal (lowongan, kursus, bimbingan) yang tampil di halaman Pusat Karir. Maksimal 5 tampil berdasarkan urutan.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-6">
        <form method="POST" action="{{ route('admin.sumber-rekomendasi.store') }}" enctype="multipart/form-data"
            class="grid grid-cols-1 sm:grid-cols-4 gap-3 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" required maxlength="120"
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">URL</label>
                <input type="url" name="url" value="{{ old('url') }}" required placeholder="https://..."
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" maxlength="60"
                    placeholder="Lowongan Kerja"
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Gambar (opsional)</label>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"
                    class="w-full px-3 py-1.5 text-xs border border-slate-200 rounded-lg file:mr-3 file:py-1 file:px-2 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 file:text-xs file:font-bold">
            </div>
            <div class="sm:col-span-4 flex justify-end">
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition">
                    Tambah Sumber
                </button>
            </div>
            @if ($errors->any())
                <div class="sm:col-span-4 text-xs font-semibold text-red-600">
                    {{ $errors->first() }}
                </div>
            @endif
        </form>
    </div>

    @if ($sumbers->isEmpty())
        <div class="bg-white rounded-xl border border-slate-200 p-8 text-center">
            <p class="text-sm font-semibold text-slate-600 mb-1">Belum ada sumber rekomendasi</p>
            <p class="text-xs text-slate-400">Tambahkan tautan lewat form di atas.</p>
        </div>
    @else
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-600">
                    <thead class="bg-slate-50 border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Judul</th>
                            <th class="px-5 py-3">URL</th>
                            <th class="px-5 py-3">Kategori</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($sumbers as $sumber)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 text-xs font-bold text-slate-400">{{ $sumber->urutan }}</td>
                                <td class="px-5 py-4">
                                    <p class="font-bold text-slate-900">{{ $sumber->title }}</p>
                                    @if ($sumber->image_path)
                                        <p class="text-xs text-slate-400 mt-0.5">Ada gambar</p>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-xs">
                                    <a href="{{ $sumber->url }}" target="_blank" rel="noopener noreferrer"
                                        class="text-blue-600 hover:underline">{{ \Illuminate\Support\Str::limit($sumber->url, 40) }}</a>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-800 text-xs font-bold rounded">
                                        {{ $sumber->kategori ?? 'Rekomendasi' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    @if ($sumber->is_active)
                                        <span class="text-xs font-bold text-emerald-600">Aktif</span>
                                    @else
                                        <span class="text-xs font-bold text-slate-400">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <form method="POST" action="{{ route('admin.sumber-rekomendasi.destroy', $sumber) }}"
                                        class="inline"
                                        onsubmit="return confirm('Hapus sumber rekomendasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-xs font-bold text-red-600 hover:text-red-800 transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
```

- [ ] **Step 7: Jalankan — EXPECT PASS**

Run: `php artisan test tests/Feature/Admin/Bkk/SumberRekomendasiCrudTest.php`
Expected: semua PASS.

- [ ] **Step 8: Commit**

```bash
git add app/Http/Controllers/Admin/Bkk/SumberRekomendasiController.php resources/views/admin/bkk/sumber-rekomendasi/index.blade.php routes/admin.php app/Support/AdminMenu.php resources/views/admin/layout.blade.php tests/Feature/Admin/Bkk/SumberRekomendasiCrudTest.php
git commit -m "feat(admin): CRUD sumber rekomendasi (BKK)"
```

---

### Task 7: Public wiring Sumber Rekomendasi di Pusat Karir (HIGH-03 bagian c)

**Files:**
- Test: `tests/Feature/SumberRekomendasiPublicTest.php` (baru)
- Modify: `app/Http/Controllers/LowonganController.php:27-106`
- Modify: `resources/views/pusat-karir/pusat-karir.blade.php:918-1021`

- [ ] **Step 1: Tulis test gagal**

Buat `tests/Feature/SumberRekomendasiPublicTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\SumberRekomendasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SumberRekomendasiPublicTest extends TestCase
{
    use RefreshDatabase;

    public function test_pusat_karir_displays_active_sumber_rekomendasi_only(): void
    {
        SumberRekomendasi::create([
            'title' => 'Glints Karier Unik',
            'url' => 'https://glints.com/id',
            'kategori' => 'Lowongan Kerja',
            'urutan' => 1,
            'is_active' => true,
        ]);
        SumberRekomendasi::create([
            'title' => 'Sumber Tersembunyi Unik',
            'url' => 'https://example.com/rahasia',
            'urutan' => 2,
            'is_active' => false,
        ]);

        $response = $this->get(route('pusat-karir.index'));

        $response->assertOk();
        $response->assertSee('Glints Karier Unik');
        $response->assertDontSee('Sumber Tersembunyi Unik');
    }
}
```

- [ ] **Step 2: Jalankan — EXPECT FAIL**

Run: `php artisan test tests/Feature/SumberRekomendasiPublicTest.php`
Expected: FAIL — `Glints Karier Unik` tidak terlihat (view pakai dummy `[]`).

- [ ] **Step 3: Controller pass data**

`app/Http/Controllers/LowonganController.php` — tambah import `use App\Models\SumberRekomendasi;` (blok import App\Models, urut setelah `MitraPerusahaan`… tepatnya antara `MagangApplication`/`MitraPerusahaan` — sisipkan sebelum `TracerMitraAlumnus`), dan di `index()` tambah sebelum `return view(...)`:

```php
        $sumberRekomendasi = SumberRekomendasi::where('is_active', true)
            ->orderBy('urutan')
            ->limit(5)
            ->get();
```

Tambahkan `'sumberRekomendasi'` ke `compact(...)`.

- [ ] **Step 4: Blade pakai objek**

`resources/views/pusat-karir/pusat-karir.blade.php` — ganti blok baris 918-922 (hapus `@php` dummy) menjadi:

```blade
        <!-- ===== Sumber Rekomendasi Section ===== -->
```

Ganti kondisi baris 927:

```blade
            @if ($sumberRekomendasi->isNotEmpty())
```

Di dalam `@foreach ($sumberRekomendasi as $sumber)` (baris 929-1002) lakukan penggantian:

| Lama | Baru |
|---|---|
| `href="{{ $sumber['url'] ?? '#' }}"` | `href="{{ $sumber->url }}"` |
| `@if (!empty($sumber['has_image']))` | `@if ($sumber->image_url !== null)` |
| `<img src="{{ asset($sumber['image']) }}"` | `<img src="{{ $sumber->image_url }}"` |
| `{{ $sumber['category'] ?? 'Rekomendasi' }}` (2×) | `{{ $sumber->kategori ?? 'Rekomendasi' }}` |
| `{{ $sumber['title'] ?? '' }}` (2×) | `{{ $sumber->title }}` |
| `{{ $sumber['date'] ?? '' }}` | `{{ $sumber->created_at->format('d M Y') }}` |

- [ ] **Step 5: Jalankan — EXPECT PASS**

Run: `php artisan test tests/Feature/SumberRekomendasiPublicTest.php`
Expected: PASS.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/LowonganController.php resources/views/pusat-karir/pusat-karir.blade.php tests/Feature/SumberRekomendasiPublicTest.php
git commit -m "feat(pusat-karir): sumber rekomendasi dinamis dari database"
```

---

### Task 8: Backend search BLUD (HIGH-04)

**Files:**
- Test: `tests/Feature/BludProdukTest.php`
- Modify: `app/Http/Controllers/BludController.php:12-20`
- Modify: `resources/views/blud/index.blade.php:279-293`

- [ ] **Step 1: Tulis test gagal**

Tambah ke `tests/Feature/BludProdukTest.php`:

```php
public function test_blud_index_search_filters_products_backend(): void
{
    $this->get(route('blud.index', ['q' => 'Cheeseroll']))
        ->assertOk()
        ->assertSee('Cheeseroll');

    $this->get(route('blud.index', ['q' => 'zonk-tidak-ada-produk']))
        ->assertOk()
        ->assertDontSee('Cheeseroll')
        ->assertDontSee('Website Sekolah');
}
```

- [ ] **Step 2: Jalankan — EXPECT FAIL**

Run: `php artisan test tests/Feature/BludProdukTest.php --filter=test_blud_index_search_filters_products_backend`
Expected: FAIL — `?q=zonk...` tetap menampilkan "Cheeseroll" (controller abaikan `q`).

- [ ] **Step 3: Controller baca `q`**

`app/Http/Controllers/BludController.php` — ganti `index()`:

```php
    public function index(Request $request): View
    {
        $query = ProdukBlud::where('is_published', true)
            ->with('galeri')
            ->orderByDesc('created_at');

        if ($request->filled('q')) {
            $q = $request->string('q')->toString();
            $query->where(fn ($b) => $b->where('title', 'like', "%{$q}%")
                ->orWhere('jurusan_nama', 'like', "%{$q}%")
                ->orWhere('deskripsi', 'like', "%{$q}%"));
        }

        $produkBluds = $query->get();

        return view('blud.index', compact('produkBluds'));
    }
```

- [ ] **Step 4: Jalankan — EXPECT PASS (test backend)**

Run: `php artisan test tests/Feature/BludProdukTest.php --filter=test_blud_index_search_filters_products_backend`
Expected: PASS.

- [ ] **Step 5: Form GET di blade**

`resources/views/blud/index.blade.php` — ganti baris 282-291 (`<label class="blud-search__field" ...>` sampai `</label>`) menjadi:

```blade
                <form action="{{ route('blud.index') }}" method="GET" class="blud-search__field">
                    <svg class="w-5 h-5 text-slate-500 shrink-0" fill="none" stroke="currentColor"
                        stroke-width="2.2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-4.35-4.35M17 10.5a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z" />
                    </svg>
                    <input id="blud-search-input" type="search" name="q" value="{{ request('q') }}"
                        placeholder="Cari produk atau layanan..." autocomplete="off"
                        aria-label="Cari produk atau layanan">
                </form>
```

(CSS `.blud-search__field` class-based — styling utuh. JS filter lama dibiarkan: ketik instan tanpa reload; Enter = submit GET `?q=` ke backend.)

- [ ] **Step 6: Jalankan seluruh test BLUD**

Run: `php artisan test tests/Feature/BludProdukTest.php`
Expected: semua PASS.

- [ ] **Step 7: Commit**

```bash
git add app/Http/Controllers/BludController.php resources/views/blud/index.blade.php tests/Feature/BludProdukTest.php
git commit -m "feat(blud): pencarian produk via backend ?q="
```

---

### Task 9: Endpoint verifikasi NISN (HIGH-07 bagian a)

**Files:**
- Test: `tests/Feature/LowonganVerifikasiNisnTest.php` (baru)
- Modify: `routes/web.php:99` (sebelum catch-all `pusat-karir.detail`)
- Modify: `app/Http/Controllers/LowonganController.php` (method baru + import)

- [ ] **Step 1: Tulis test gagal**

Buat `tests/Feature/LowonganVerifikasiNisnTest.php`:

```php
<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowonganVerifikasiNisnTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_nisn_returns_valid_with_name(): void
    {
        CalonSiswa::create([
            'nisn' => '0051234567',
            'nama_lengkap' => 'Siswa Uji Khusus',
            'asal_sekolah' => 'SMP Uji Khusus',
        ]);

        $this->postJson(route('pusat-karir.verifikasi-nisn'), ['nisn' => '0051234567'])
            ->assertOk()
            ->assertJson(['valid' => true, 'nama' => 'Siswa Uji Khusus']);
    }

    public function test_unknown_nisn_returns_valid_false(): void
    {
        $this->postJson(route('pusat-karir.verifikasi-nisn'), ['nisn' => '9999999999'])
            ->assertOk()
            ->assertJson(['valid' => false]);
    }

    public function test_bad_format_returns_422(): void
    {
        $this->postJson(route('pusat-karir.verifikasi-nisn'), ['nisn' => '123'])
            ->assertStatus(422);
    }
}
```

- [ ] **Step 2: Jalankan — EXPECT FAIL (route tak ada)**

Run: `php artisan test tests/Feature/LowonganVerifikasiNisnTest.php`
Expected: FAIL — RouteNotFoundException.

- [ ] **Step 3: Route**

`routes/web.php` — sisipkan SEBELUM baris 100 (`Route::get('/pusat-karir/{slug}', ...)` catch-all):

```php
Route::post('/pusat-karir/verifikasi-nisn', [LowonganController::class, 'verifikasiNisn'])
    ->middleware('throttle:10,1')
    ->name('pusat-karir.verifikasi-nisn');
```

- [ ] **Step 4: Method controller**

`app/Http/Controllers/LowonganController.php` — tambah import `use App\Models\CalonSiswa;` (blok import App\Models, urut setelah `Artikel`/`BimbinganKarir`), dan method baru setelah `apply()` (sebelum `storeApply`):

```php
    public function verifikasiNisn(Request $request): JsonResponse
    {
        $request->validate(['nisn' => ['required', 'digits:10']]);

        $siswa = CalonSiswa::where('nisn', $request->string('nisn')->toString())->first();

        return response()->json([
            'valid' => $siswa !== null,
            'nama' => $siswa?->nama_lengkap,
        ]);
    }
```

(`JsonResponse` sudah di-import di baris 18 file yang sama.)

- [ ] **Step 5: Jalankan — EXPECT PASS**

Run: `php artisan test tests/Feature/LowonganVerifikasiNisnTest.php`
Expected: 3 test PASS.

- [ ] **Step 6: Commit**

```bash
git add routes/web.php app/Http/Controllers/LowonganController.php tests/Feature/LowonganVerifikasiNisnTest.php
git commit -m "feat(pusat-karir): endpoint verifikasi NISN (CalonSiswa)"
```

---

### Task 10: JS fetch di form lamar (HIGH-07 bagian b)

**Files:**
- Modify: `resources/views/pusat-karir/lamar-lowongan.blade.php:374-384 (error p), 458-481 (JS)`

- [ ] **Step 1: Elemen error**

`resources/views/pusat-karir/lamar-lowongan.blade.php` — setelah `</div>` penutup `#verified-box` (baris 383), sisipkan:

```blade
                    <p id="nisn-verify-error" class="mt-2 text-sm text-red-600 font-medium" style="display: none;"></p>
```

- [ ] **Step 2: Ganti blok JS simulasi**

Ganti baris 469-481 (handler klik pada `#btn-verifikasi-nisn`, dari `document.getElementById('btn-verifikasi-nisn').addEventListener` sampai `});` penutupnya) menjadi:

```js
        const verifyBtn = document.getElementById('btn-verifikasi-nisn');
        const verifyError = document.getElementById('nisn-verify-error');

        verifyBtn.addEventListener('click', async function() {
            const val = nisnInput.value.trim();

            if (!/^\d+$/.test(val) || val.length !== 10) {
                verifiedBox.style.display = 'none';
                verifyError.textContent = 'NISN harus diisi dengan angka, 10 digit tanpa huruf atau simbol.';
                verifyError.style.display = 'block';
                nisnInput.focus();
                return;
            }

            const token = document.querySelector('form input[name="_token"]').value;

            verifyBtn.disabled = true;
            verifyBtn.textContent = 'Memeriksa...';

            try {
                const response = await fetch('{{ route('pusat-karir.verifikasi-nisn') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new URLSearchParams({ nisn: val }),
                });

                if (response.status === 422) {
                    const errors = await response.json();
                    throw new Error(errors.errors?.nisn?.[0] || 'NISN tidak valid.');
                }

                const data = await response.json();

                if (data.valid) {
                    verifyError.style.display = 'none';
                    verifiedBox.style.display = 'flex';
                    verifiedName.textContent = `Data Siswa: ${data.nama} — NISN Valid`;
                } else {
                    verifiedBox.style.display = 'none';
                    verifyError.textContent = 'NISN tidak terdaftar di SMKN 1 Surabaya.';
                    verifyError.style.display = 'block';
                }
            } catch (error) {
                verifiedBox.style.display = 'none';
                verifyError.textContent = error.message || 'Gagal memeriksa NISN. Coba lagi.';
                verifyError.style.display = 'block';
            } finally {
                verifyBtn.disabled = false;
                verifyBtn.textContent = 'Verifikasi';
            }
        });
```

(Variabel `nisnInput`, `verifiedBox`, `verifiedName` dari blok di atasnya tetap dipakai — tidak dihapus. Token CSRF diambil dari input `@csrf` form, tanpa meta tag baru.)

- [ ] **Step 3: Verifikasi manual (cek render)**

Run: `php artisan test tests/Feature/LowonganVerifikasiNisnTest.php tests/Feature/PublicPagesTest.php`
Expected: PASS (tidak ada regresi render).

- [ ] **Step 4: Commit**

```bash
git add resources/views/pusat-karir/lamar-lowongan.blade.php
git commit -m "feat(pusat-karir): verifikasi NISN via fetch ke endpoint"
```

---

### Task 11: Guard server `storeApply` + perbaiki test terdampak (HIGH-07 bagian c)

**Files:**
- Modify: `app/Http/Controllers/LowonganController.php:132`
- Modify: `tests/Feature/LowonganApplyValidationTest.php`
- Modify: `tests/Feature/LowonganApplyUploadTest.php`

- [ ] **Step 1: Tulis test guard gagal**

Tambah ke `tests/Feature/LowonganApplyValidationTest.php`:

```php
public function test_unregistered_nisn_is_rejected(): void
{
    $lowongan = $this->makeLowongan();

    $response = $this->from(route('pusat-karir.lamar', $lowongan->slug))
        ->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '9999999999',
            'consent' => 'on',
        ]);

    $response->assertSessionHasErrors('nisn');
    $this->assertDatabaseCount('magang_applications', 0);
}
```

- [ ] **Step 2: Jalankan — EXPECT FAIL (guard belum ada, NISN 999 diterima)**

Run: `php artisan test tests/Feature/LowonganApplyValidationTest.php --filter=test_unregistered_nisn_is_rejected`
Expected: FAIL — tidak ada error session (NISN diterima).

- [ ] **Step 3: Guard di controller**

`app/Http/Controllers/LowonganController.php:132` — ganti:

```php
        $rules = ['nisn' => ['required', 'numeric', 'digits:10', 'exists:calon_siswas,nisn']];
```

- [ ] **Step 4: Seed CalonSiswa di test lama (NISN `1234567890` dipakai 3 file)**

Tambah import `use App\Models\CalonSiswa;` + method `setUp` ke **kedua** file:

`tests/Feature/LowonganApplyValidationTest.php`:

```php
    protected function setUp(): void
    {
        parent::setUp();

        CalonSiswa::create([
            'nisn' => '1234567890',
            'nama_lengkap' => 'Siswa Lamar Uji',
            'asal_sekolah' => 'SMP Uji',
        ]);
    }
```

`tests/Feature/LowonganApplyUploadTest.php` — blok identik.

(`LowonganBuktiPdfTest` membuat `MagangApplication` langsung — tidak lewat `storeApply` — tanpa perubahan.)

- [ ] **Step 5: Jalankan — EXPECT PASS**

Run: `php artisan test tests/Feature/LowonganApplyValidationTest.php tests/Feature/LowonganApplyUploadTest.php tests/Feature/LowonganBuktiPdfTest.php`
Expected: semua PASS.

- [ ] **Step 6: Commit**

```bash
git add app/Http/Controllers/LowonganController.php tests/Feature/LowonganApplyValidationTest.php tests/Feature/LowonganApplyUploadTest.php
git commit -m "feat(pusat-karir): guard exists NISN di storeApply"
```

---

### Task 12: Full suite + Pint + final

- [ ] **Step 1: Jalankan seluruh suite**

Run: `php artisan test`
Expected: 0 FAILURE baru. Hanya 2 baseline pre-existing yang boleh gagal:
- `PublicPagesTest::test_visi_misi_page_displays_dynamic_content` (out of scope)
- `Admin\Bkk\MitraCrudTest::test_store_with_invalid_data_shows_field_errors` (out of scope)

Jika ada failure lain → perbaiki sebelum lanjut.

- [ ] **Step 2: Pint**

Run: `php vendor/bin/pint --dirty`
Expected: tanpa error (file yang diubah di-formatted).

- [ ] **Step 3: Jalankan lagi setelah Pint**

Run: `php artisan test`
Expected: sama dengan Step 1.

- [ ] **Step 4: Commit sisa (jika Pint mengubah file)**

```bash
git add --dirty
git commit -m "style: pint formatting" || true
```

---

## Catatan Eksekusi

- Branch `fix/high-issues` sudah dibuat dari `main`.
- Jangan sentuh 2 baseline failure (visi-misi, MitraCrudTest) — di luar scope spec ini.
- `report.md` jangan diedit (HIGH-06/HIGH-05 tidak dikerjakan sesuai keputusan user).
- AI Major Finder: spec terpisah, menyusul — jangan implementasikan filter `?q=` di `/jurusan`.
