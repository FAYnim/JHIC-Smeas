# Admin Panel Multi-Role — Fase 2 (BKK) Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun seluruh modul back-office untuk peran BKK (Pusat Karir): Lowongan CRUD (toggle publish, file upload, auto slug), Lamaran review & status update, Mitra DUDI CRUD & logo upload, Bimbingan Karir & Kategori CRUD serta wiring DB ke publik, dan Tracer Study management (Alumni CRUD, Kuesioner Tracer konfirmasi toggle, dan Tracer Settings edit).

**Architecture:** Modul admin BKK diletakkan di `app/Http/Controllers/Admin/Bkk/` dan view di `resources/views/admin/bkk/`. Pengamanan hak akses via middleware `auth` dan `role:bkk` (dengan super admin otomatis lolos). Upload berkas menggunakan shared concern `HandlesUploads` yang menyimpan ke disk `public`. Seluruh mutasi divalidasi dengan FormRequest dedicated. Sidebar menu diperbarui di `AdminMenu` dan ikon di `resources/views/admin/layout.blade.php`.

**Tech Stack:** Laravel 13, PHP 8.3+, Blade, Tailwind CSS v4 (@tailwindcss/vite), `mallardduck/blade-lucide-icons`, PHPUnit 12, Laravel Pint.

---

## File Structure

| File | Responsibility |
|---|---|
| `database/migrations/2026_10_02_000001_add_bkk_fase2_fields.php` | Menambah `is_published` dan `logo_path` ke `lowongans`, serta `logo_path` ke `mitra_perusahaans` |
| `app/Http/Controllers/Admin/Concerns/HandlesUploads.php` | Trait upload berkas gambar yang aman ke disk public dengan sanitasi dan validasi mime |
| `app/Models/Lowongan.php` | Cast dan fillable `is_published`, `logo_path`, accessor/helper `logo_url` fallback |
| `app/Models/MitraPerusahaan.php` | Cast dan fillable `logo_path`, accessor/helper `logo_url` fallback |
| `app/Support/AdminMenu.php` | Menambah item menu BKK: Bimbingan Karir dan Tracer Study |
| `resources/views/admin/layout.blade.php` | Menambah ikon case untuk lucide icons tracer/bimbingan jika diperlukan |
| `app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php` | Validasi input form create lowongan |
| `app/Http/Requests/Admin/Bkk/UpdateLowonganRequest.php` | Validasi input form edit lowongan |
| `app/Http/Controllers/Admin/Bkk/LowonganController.php` | CRUD Lowongan, toggle publish, auto slug, upload logo |
| `resources/views/admin/bkk/lowongan/index.blade.php` | Daftar lowongan, filter jenis & status publish, search, pagination |
| `resources/views/admin/bkk/lowongan/create.blade.php` | Form tambah lowongan baru |
| `resources/views/admin/bkk/lowongan/edit.blade.php` | Form ubah lowongan |
| `app/Http/Controllers/Admin/Bkk/LamaranController.php` | Review pelamar magang, filter status, update status (pending, accepted, rejected) |
| `resources/views/admin/bkk/lamaran/index.blade.php` | Tabel lamaran magang, modal/dropdown update status, filter lowongan/status |
| `app/Http/Requests/Admin/Bkk/StoreMitraRequest.php` | Validasi form create mitra DUDI |
| `app/Http/Requests/Admin/Bkk/UpdateMitraRequest.php` | Validasi form edit mitra DUDI |
| `app/Http/Controllers/Admin/Bkk/MitraController.php` | CRUD Mitra DUDI, MoU status, program JSON handling, logo upload |
| `resources/views/admin/bkk/mitra/index.blade.php` | Tabel mitra DUDI, status MoU, search |
| `resources/views/admin/bkk/mitra/create.blade.php` | Form create mitra |
| `resources/views/admin/bkk/mitra/edit.blade.php` | Form edit mitra |
| `app/Http/Requests/Admin/Bkk/StoreBimbinganRequest.php` | Validasi form bimbingan karir & kategori |
| `app/Http/Requests/Admin/Bkk/UpdateBimbinganRequest.php` | Validasi update bimbingan karir |
| `app/Http/Controllers/Admin/Bkk/BimbinganController.php` | CRUD Bimbingan Karir & Kategori bimbingan |
| `resources/views/admin/bkk/bimbingan/index.blade.php` | List artikel/modul bimbingan karir dan tab/kategori |
| `resources/views/admin/bkk/bimbingan/create.blade.php` | Form tambah materi bimbingan karir |
| `resources/views/admin/bkk/bimbingan/edit.blade.php` | Form edit materi bimbingan karir |
| `app/Http/Controllers/LowonganController.php` | Wiring query publik `$bimbinganKatalog` dari tabel `bimbingan_karirs` & `bimbingan_kategori` |
| `resources/views/pusat-karir/pusat-karir.blade.php` | Update view publik katalog bimbingan karir menggunakan data dari DB |
| `app/Http/Controllers/Admin/Bkk/TracerController.php` | Manajemen Tracer Study: list alumni + CRUD, list kuesioner + konfirmasi toggle, update settings |
| `resources/views/admin/bkk/tracer/alumni/index.blade.php` | Tabel alumni, filter jurusan & angkatan |
| `resources/views/admin/bkk/tracer/alumni/create.blade.php` | Form tambah alumni |
| `resources/views/admin/bkk/tracer/alumni/edit.blade.php` | Form ubah alumni |
| `resources/views/admin/bkk/tracer/kuesioner/index.blade.php` | Tabel respons kuesioner, toggle status konfirmasi |
| `resources/views/admin/bkk/tracer/settings/edit.blade.php` | Form edit pengaturan statistik tracer study |
| `routes/admin.php` | Registrasi seluruh route resource BKK dengan proteksi `role:bkk` |
| `tests/Feature/Admin/Bkk/LowonganCrudTest.php` | Pengujian fitur CRUD Lowongan, auto slug, toggle publish, upload |
| `tests/Feature/Admin/Bkk/LamaranReviewTest.php` | Pengujian fitur review dan update status lamaran magang |
| `tests/Feature/Admin/Bkk/MitraCrudTest.php` | Pengujian fitur CRUD Mitra Perusahaan & upload logo |
| `tests/Feature/Admin/Bkk/BimbinganCrudTest.php` | Pengujian CRUD Bimbingan & verifikasi wiring halaman publik |
| `tests/Feature/Admin/Bkk/TracerStudyTest.php` | Pengujian CRUD Alumni, toggle kuesioner, update tracer settings |

---

## Task 1: Migration Kolom BKK (`is_published`, `logo_path`) & HandlesUploads Concern

**Files:**
- Create: `database/migrations/2026_10_02_000001_add_bkk_fase2_fields.php`
- Create: `app/Http/Controllers/Admin/Concerns/HandlesUploads.php`
- Modify: `app/Models/Lowongan.php`
- Modify: `app/Models/MitraPerusahaan.php`
- Test: `tests/Feature/Admin/Bkk/BkkFoundationTest.php`

- [ ] **Step 1: Write the failing test**

Create `tests/Feature/Admin/Bkk/BkkFoundationTest.php`:
```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Lowongan;
use App\Models\MitraPerusahaan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BkkFoundationTest extends TestCase
{
    use RefreshDatabase;

    public function test_lowongan_supports_is_published_and_logo_path(): void
    {
        $lowongan = Lowongan::create([
            'company_name' => 'PT Solusi Teknologi',
            'title' => 'Web Developer',
            'slug' => 'web-developer-solusi',
            'location' => 'Surabaya',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'deskripsi' => 'Deskripsi pekerjaan',
            'batas_pendaftaran' => now()->addMonth(),
            'durasi_pelaksanaan' => '6 Bulan',
            'is_published' => true,
            'logo_path' => 'logos/pt-solusi.png',
        ]);

        $this->assertDatabaseHas('lowongans', [
            'id' => $lowongan->id,
            'is_published' => 1,
            'logo_path' => 'logos/pt-solusi.png',
        ]);
    }

    public function test_mitra_supports_logo_path(): void
    {
        $mitra = MitraPerusahaan::create([
            'name' => 'PT Mitra Digital',
            'slug' => 'pt-mitra-digital',
            'short_name' => 'MitraDigi',
            'sector' => 'IT',
            'city' => 'Surabaya',
            'logo_path' => 'mitra/mitra-digi.png',
        ]);

        $this->assertDatabaseHas('mitra_perusahaans', [
            'id' => $mitra->id,
            'logo_path' => 'mitra/mitra-digi.png',
        ]);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/Bkk/BkkFoundationTest.php`
Expected: FAIL due to missing columns `is_published` / `logo_path`.

- [ ] **Step 3: Create the migration**

Create `database/migrations/2026_10_02_000001_add_bkk_fase2_fields.php`:
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->boolean('is_published')->default(true)->after('status_kuota');
            $table->string('logo_path')->nullable()->after('logo_color');
        });

        Schema::table('mitra_perusahaans', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('logo_text');
        });
    }

    public function down(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropColumn(['is_published', 'logo_path']);
        });

        Schema::table('mitra_perusahaans', function (Blueprint $table) {
            $table->dropColumn(['logo_path']);
        });
    }
};
```

- [ ] **Step 4: Update Models fillable and casts**

Modify `app/Models/Lowongan.php`:
Add `'is_published'`, `'logo_path'` into `$fillable`.
Add `'is_published' => 'boolean'` into `casts()`.
Add accessor `getLogoUrlAttribute()`:
```php
public function getLogoUrlAttribute(): ?string
{
    return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
}
```

Modify `app/Models/MitraPerusahaan.php`:
Add `'logo_path'` into `$fillable`.
Add accessor `getLogoUrlAttribute()`:
```php
public function getLogoUrlAttribute(): ?string
{
    return $this->logo_path ? asset('storage/' . $this->logo_path) : null;
}
```

- [ ] **Step 5: Create HandlesUploads trait**

Create `app/Http/Controllers/Admin/Concerns/HandlesUploads.php`:
```php
<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesUploads
{
    /**
     * Upload an uploaded file to the public disk under a directory.
     */
    public function uploadFile(UploadedFile $file, string $directory): string
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Delete an existing file from the public disk if present.
     */
    public function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
```

- [ ] **Step 6: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/Bkk/BkkFoundationTest.php`
Expected: PASS

- [ ] **Step 7: Commit**

```bash
git add database/migrations/2026_10_02_000001_add_bkk_fase2_fields.php app/Models/Lowongan.php app/Models/MitraPerusahaan.php app/Http/Controllers/Admin/Concerns/HandlesUploads.php tests/Feature/Admin/Bkk/BkkFoundationTest.php
git commit -m "feat(bkk): add is_published and logo_path fields with HandlesUploads trait"
```

---

## Task 2: Modul Admin Lowongan CRUD

**Files:**
- Create: `app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php`
- Create: `app/Http/Requests/Admin/Bkk/UpdateLowonganRequest.php`
- Create: `app/Http/Controllers/Admin/Bkk/LowonganController.php`
- Create: `resources/views/admin/bkk/lowongan/index.blade.php`
- Create: `resources/views/admin/bkk/lowongan/create.blade.php`
- Create: `resources/views/admin/bkk/lowongan/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Bkk/LowonganCrudTest.php`

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Admin/Bkk/LowonganCrudTest.php`:
```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Lowongan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LowonganCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.lowongan.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_humas_role_is_forbidden(): void
    {
        $humas = User::factory()->humas()->create();
        $response = $this->actingAs($humas)->get(route('admin.lowongan.index'));
        $response->assertForbidden();
    }

    public function test_bkk_user_can_view_lowongan_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        Lowongan::factory()->create(['title' => 'Software Engineer PKL']);

        $response = $this->actingAs($bkk)->get(route('admin.lowongan.index'));
        $response->assertOk();
        $response->assertSee('Software Engineer PKL');
    }

    public function test_bkk_user_can_create_lowongan_with_auto_slug_and_logo(): void
    {
        Storage::fake('public');
        $bkk = User::factory()->bkk()->create();

        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->actingAs($bkk)->post(route('admin.lowongan.store'), [
            'company_name' => 'PT Inovasi Digital',
            'company_short' => 'Inovasi',
            'title' => 'Junior Web Programmer',
            'jenis' => 'magang',
            'location' => 'Surabaya',
            'duration' => '6 Bulan',
            'jurusan' => 'RPL',
            'kuota' => 5,
            'metode_kerja' => 'On-site',
            'deskripsi' => 'Deskripsi pekerjaan magang...',
            'tanggung_jawab' => "Membuat fitur web\nDebugging error",
            'kualifikasi' => "Menguasai PHP & Laravel\nDisiplin",
            'benefits' => "Uang saku\nSertifikat",
            'batas_pendaftaran' => now()->addDays(20)->format('Y-m-d'),
            'durasi_pelaksanaan' => '6 Bulan',
            'is_published' => '1',
            'logo' => $file,
        ]);

        $response->assertRedirect(route('admin.lowongan.index'));
        $this->assertDatabaseHas('lowongans', [
            'company_name' => 'PT Inovasi Digital',
            'slug' => 'junior-web-programmer',
            'is_published' => 1,
        ]);

        $lowongan = Lowongan::where('slug', 'junior-web-programmer')->firstOrFail();
        $this->assertNotNull($lowongan->logo_path);
        Storage::disk('public')->assertExists($lowongan->logo_path);
    }

    public function test_bkk_user_can_toggle_publish(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create(['is_published' => true]);

        $response = $this->actingAs($bkk)->patch(route('admin.lowongan.toggle-publish', $lowongan));
        $response->assertRedirect();

        $this->assertFalse($lowongan->fresh()->is_published);
    }

    public function test_bkk_user_can_delete_lowongan(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create();

        $response = $this->actingAs($bkk)->delete(route('admin.lowongan.destroy', $lowongan));
        $response->assertRedirect(route('admin.lowongan.index'));

        $this->assertDatabaseMissing('lowongans', ['id' => $lowongan->id]);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/Bkk/LowonganCrudTest.php`
Expected: FAIL because route `admin.lowongan.index` is not defined.

- [ ] **Step 3: Create FormRequests for Lowongan**

Create `app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php`:
```php
<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_short' => ['nullable', 'string', 'max:50'],
            'is_mitra_dudi' => ['nullable', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:0'],
            'metode_kerja' => ['required', 'string', 'max:50'],
            'jenis' => ['required', 'in:magang,lowongan'],
            'deskripsi' => ['required', 'string'],
            'tanggung_jawab' => ['nullable', 'string'],
            'kualifikasi' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'batas_pendaftaran' => ['required', 'date'],
            'durasi_pelaksanaan' => ['required', 'string', 'max:100'],
            'status_kuota' => ['nullable', 'string', 'max:50'],
            'pokja_nama' => ['nullable', 'string', 'max:255'],
            'pokja_koordinator' => ['nullable', 'string', 'max:255'],
            'pokja_wa' => ['nullable', 'string', 'max:30'],
            'gaji_min' => ['nullable', 'integer', 'min:0'],
            'gaji_max' => ['nullable', 'integer', 'min:0'],
            'tipe_pekerjaan' => ['nullable', 'string', 'max:100'],
            'pengalaman' => ['nullable', 'string', 'max:100'],
            'bidang_industri' => ['nullable', 'string', 'max:100'],
            'jenjang_pendidikan' => ['nullable', 'string', 'max:100'],
            'fresh_graduate_ok' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'mitra_id' => ['nullable', 'exists:mitra_perusahaans,id'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
```

Create `app/Http/Requests/Admin/Bkk/UpdateLowonganRequest.php`:
```php
<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_short' => ['nullable', 'string', 'max:50'],
            'is_mitra_dudi' => ['nullable', 'boolean'],
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'duration' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:255'],
            'kuota' => ['required', 'integer', 'min:0'],
            'metode_kerja' => ['required', 'string', 'max:50'],
            'jenis' => ['required', 'in:magang,lowongan'],
            'deskripsi' => ['required', 'string'],
            'tanggung_jawab' => ['nullable', 'string'],
            'kualifikasi' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'batas_pendaftaran' => ['required', 'date'],
            'durasi_pelaksanaan' => ['required', 'string', 'max:100'],
            'status_kuota' => ['nullable', 'string', 'max:50'],
            'pokja_nama' => ['nullable', 'string', 'max:255'],
            'pokja_koordinator' => ['nullable', 'string', 'max:255'],
            'pokja_wa' => ['nullable', 'string', 'max:30'],
            'gaji_min' => ['nullable', 'integer', 'min:0'],
            'gaji_max' => ['nullable', 'integer', 'min:0'],
            'tipe_pekerjaan' => ['nullable', 'string', 'max:100'],
            'pengalaman' => ['nullable', 'string', 'max:100'],
            'bidang_industri' => ['nullable', 'string', 'max:100'],
            'jenjang_pendidikan' => ['nullable', 'string', 'max:100'],
            'fresh_graduate_ok' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'mitra_id' => ['nullable', 'exists:mitra_perusahaans,id'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
```

- [ ] **Step 4: Create LowonganController**

Create `app/Http/Controllers/Admin/Bkk/LowonganController.php`:
Implement:
- `use HandlesUploads;`
- Helper parsing textarea line-by-line ke JSON array.
- Auto slug generator (unik bila slug sama sudah ada).
- `index`, `create`, `store`, `edit`, `update`, `destroy`, `togglePublish`.

- [ ] **Step 5: Create Views for Lowongan CRUD**

Create:
- `resources/views/admin/bkk/lowongan/index.blade.php`: Header tindakan (tambah lowongan), filter jenis (semua/magang/lowongan), search query, pagination, tabel rapi dengan kolom logo/perusahaan, judul, kuota, status publish toggle switch/button, dan aksi edit/delete.
- `resources/views/admin/bkk/lowongan/create.blade.php`: Full-page form dengan seksi teratur (Informasi Perusahaan, Posisi & Spesifikasi, Kualifikasi & Tanggung Jawab, Kontak & Publikasi), file input logo dengan preview/instruksi max 2MB.
- `resources/views/admin/bkk/lowongan/edit.blade.php`: Full-page form edit dengan isi nilai existing, preview logo yang sudah tersimpan, tombol batal dan simpan perubahan.

- [ ] **Step 6: Register routes in `routes/admin.php`**

Add in `routes/admin.php`:
```php
use App\Http\Controllers\Admin\Bkk\LowonganController;

Route::middleware('role:bkk')->group(function () {
    Route::patch('lowongan/{lowongan}/toggle-publish', [LowonganController::class, 'togglePublish'])->name('lowongan.toggle-publish');
    Route::resource('lowongan', LowonganController::class);
});
```

- [ ] **Step 7: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/Bkk/LowonganCrudTest.php`
Expected: PASS

- [ ] **Step 8: Commit**

```bash
git add app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php app/Http/Requests/Admin/Bkk/UpdateLowonganRequest.php app/Http/Controllers/Admin/Bkk/LowonganController.php resources/views/admin/bkk/lowongan/ routes/admin.php tests/Feature/Admin/Bkk/LowonganCrudTest.php
git commit -m "feat(bkk): add full Lowongan CRUD with publish toggle and logo upload"
```

---

## Task 3: Modul Admin Lamaran Magang Review

**Files:**
- Create: `app/Http/Controllers/Admin/Bkk/LamaranController.php`
- Create: `resources/views/admin/bkk/lamaran/index.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Bkk/LamaranReviewTest.php`

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Admin/Bkk/LamaranReviewTest.php`:
```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LamaranReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_lamaran_list_and_filter_by_status(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create(['title' => 'Teknisi Jaringan']);
        MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-TEL-20261001-ABC12345',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.lamaran.index'));
        $response->assertOk();
        $response->assertSee('1234567890');
        $response->assertSee('PKL-TEL-20261001-ABC12345');
    }

    public function test_bkk_user_can_update_lamaran_status(): void
    {
        $bkk = User::factory()->bkk()->create();
        $lowongan = Lowongan::factory()->create();
        $app = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => '1234567890',
            'registration_code' => 'PKL-TEL-20261001-ABC12345',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($bkk)->patch(route('admin.lamaran.update-status', $app), [
            'status' => 'accepted',
        ]);

        $response->assertRedirect();
        $this->assertEquals('accepted', $app->fresh()->status);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/Bkk/LamaranReviewTest.php`
Expected: FAIL because routes and controller do not exist yet.

- [ ] **Step 3: Create LamaranController**

Create `app/Http/Controllers/Admin/Bkk/LamaranController.php`:
Implement:
- `index(Request $request)`: daftar lamaran dengan relasi `lowongan`, filter status (`pending`, `accepted`, `rejected`), search NISN/kode registrasi, pagination.
- `updateStatus(Request $request, MagangApplication $application)`: validasi `status => in:pending,accepted,rejected`, update dan redirect kembali dengan flash `success`.

- [ ] **Step 4: Create View `resources/views/admin/bkk/lamaran/index.blade.php`**

Design:
- Statistik singkat: Total Pelamar, Menunggu, Diterima, Ditolak.
- Baris filter status dan search input.
- Tabel dengan kolom: Kode Registrasi, NISN, Posisi Lowongan, Perusahaan, Tanggal Daftar, Status (badge berwarna), Form/Dropdown aksi ubah status langsung dengan konfirmasi atau submit cepat.

- [ ] **Step 5: Register routes in `routes/admin.php`**

Add to `routes/admin.php` inside `role:bkk`:
```php
use App\Http\Controllers\Admin\Bkk\LamaranController;

Route::get('lamaran', [LamaranController::class, 'index'])->name('lamaran.index');
Route::patch('lamaran/{application}/status', [LamaranController::class, 'updateStatus'])->name('lamaran.update-status');
```

- [ ] **Step 6: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/Bkk/LamaranReviewTest.php`
Expected: PASS

- [ ] **Step 7: Commit**

```bash
git add app/Http/Controllers/Admin/Bkk/LamaranController.php resources/views/admin/bkk/lamaran/ routes/admin.php tests/Feature/Admin/Bkk/LamaranReviewTest.php
git commit -m "feat(bkk): add Lamaran Magang review and status management"
```

---

## Task 4: Modul Admin Mitra DUDI CRUD

**Files:**
- Create: `app/Http/Requests/Admin/Bkk/StoreMitraRequest.php`
- Create: `app/Http/Requests/Admin/Bkk/UpdateMitraRequest.php`
- Create: `app/Http/Controllers/Admin/Bkk/MitraController.php`
- Create: `resources/views/admin/bkk/mitra/index.blade.php`
- Create: `resources/views/admin/bkk/mitra/create.blade.php`
- Create: `resources/views/admin/bkk/mitra/edit.blade.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Bkk/MitraCrudTest.php`

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Admin/Bkk/MitraCrudTest.php`:
```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\MitraPerusahaan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MitraCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_mitra_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        MitraPerusahaan::create([
            'name' => 'PT Surya Telekomunikasi',
            'slug' => 'pt-surya-telekomunikasi',
            'short_name' => 'SuryaTel',
            'sector' => 'Telekomunikasi',
            'city' => 'Surabaya',
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.mitra.index'));
        $response->assertOk();
        $response->assertSee('PT Surya Telekomunikasi');
    }

    public function test_bkk_user_can_create_mitra_with_logo_and_programs(): void
    {
        Storage::fake('public');
        $bkk = User::factory()->bkk()->create();

        $logo = UploadedFile::fake()->image('mitra.png');

        $response = $this->actingAs($bkk)->post(route('admin.mitra.store'), [
            'name' => 'PT Tekno Maju Bersama',
            'short_name' => 'TeknoMaju',
            'sector' => 'Software House',
            'city' => 'Surabaya',
            'description' => 'Perusahaan software house mitra SMKN 1 Surabaya',
            'website' => 'https://teknomaju.example.com',
            'is_mou_active' => '1',
            'mou_until' => now()->addYears(2)->format('Y-m-d'),
            'kemitraan_sejak' => 2021,
            'programs' => "Tempat PKL Resmi\nKelas Industri",
            'narahubung_nama' => 'Hendra Setiawan',
            'narahubung_jabatan' => 'HR Manager',
            'narahubung_wa' => '081234567890',
            'logo' => $logo,
        ]);

        $response->assertRedirect(route('admin.mitra.index'));
        $this->assertDatabaseHas('mitra_perusahaans', [
            'name' => 'PT Tekno Maju Bersama',
            'slug' => 'pt-tekno-maju-bersama',
            'is_mou_active' => 1,
        ]);

        $mitra = MitraPerusahaan::where('slug', 'pt-tekno-maju-bersama')->firstOrFail();
        $this->assertNotNull($mitra->logo_path);
        Storage::disk('public')->assertExists($mitra->logo_path);
        $this->assertContains('Tempat PKL Resmi', $mitra->programs);
    }

    public function test_bkk_user_can_update_mitra(): void
    {
        $bkk = User::factory()->bkk()->create();
        $mitra = MitraPerusahaan::create([
            'name' => 'PT Awal',
            'slug' => 'pt-awal',
            'short_name' => 'Awal',
            'sector' => 'IT',
            'city' => 'Surabaya',
        ]);

        $response = $this->actingAs($bkk)->put(route('admin.mitra.update', $mitra), [
            'name' => 'PT Awal Diperbarui',
            'short_name' => 'AwalNew',
            'sector' => 'Fintech',
            'city' => 'Sidoarjo',
            'is_mou_active' => '0',
        ]);

        $response->assertRedirect(route('admin.mitra.index'));
        $this->assertDatabaseHas('mitra_perusahaans', [
            'id' => $mitra->id,
            'name' => 'PT Awal Diperbarui',
            'sector' => 'Fintech',
            'is_mou_active' => 0,
        ]);
    }

    public function test_bkk_user_can_delete_mitra(): void
    {
        $bkk = User::factory()->bkk()->create();
        $mitra = MitraPerusahaan::create([
            'name' => 'PT Hapus',
            'slug' => 'pt-hapus',
            'short_name' => 'Hapus',
            'sector' => 'IT',
            'city' => 'Surabaya',
        ]);

        $response = $this->actingAs($bkk)->delete(route('admin.mitra.destroy', $mitra));
        $response->assertRedirect(route('admin.mitra.index'));
        $this->assertDatabaseMissing('mitra_perusahaans', ['id' => $mitra->id]);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/Bkk/MitraCrudTest.php`
Expected: FAIL because route `admin.mitra.index` is not defined.

- [ ] **Step 3: Create StoreMitraRequest & UpdateMitraRequest**

Create `app/Http/Requests/Admin/Bkk/StoreMitraRequest.php`:
```php
<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreMitraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['required', 'string', 'max:50'],
            'sector' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'website' => ['nullable', 'url', 'max:255'],
            'logo_color' => ['nullable', 'string', 'max:20'],
            'logo_text' => ['nullable', 'string', 'max:10'],
            'is_mou_active' => ['nullable', 'boolean'],
            'mou_until' => ['nullable', 'date'],
            'kemitraan_sejak' => ['nullable', 'integer', 'min:1950', 'max:' . (date('Y') + 1)],
            'programs' => ['nullable', 'string'],
            'narahubung_nama' => ['nullable', 'string', 'max:255'],
            'narahubung_jabatan' => ['nullable', 'string', 'max:100'],
            'narahubung_wa' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
        ];
    }
}
```

Create `app/Http/Requests/Admin/Bkk/UpdateMitraRequest.php`:
Validasi serupa dengan `StoreMitraRequest`.

- [ ] **Step 4: Create MitraController**

Create `app/Http/Controllers/Admin/Bkk/MitraController.php`:
Implement:
- `use HandlesUploads;`
- Auto slug dari name (dengan generator unik).
- Parsing programs dari multiline string ke JSON array.
- Handle logo upload & delete old logo saat diganti/dihapus.
- `index`, `create`, `store`, `edit`, `update`, `destroy`.

- [ ] **Step 5: Create Views for Mitra CRUD**

Create:
- `resources/views/admin/bkk/mitra/index.blade.php`: List mitra, badge MoU aktif/tidak, sektor, kota, logo, jumlah lowongan aktif terhubung, tombol edit dan hapus.
- `resources/views/admin/bkk/mitra/create.blade.php`: Form data mitra, upload logo, detail MoU, dan narahubung.
- `resources/views/admin/bkk/mitra/edit.blade.php`: Form edit mitra dengan preview logo dan nilai eksisting.

- [ ] **Step 6: Register routes in `routes/admin.php`**

Add to `routes/admin.php` inside `role:bkk`:
```php
use App\Http\Controllers\Admin\Bkk\MitraController;

Route::resource('mitra', MitraController::class);
```

- [ ] **Step 7: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/Bkk/MitraCrudTest.php`
Expected: PASS

- [ ] **Step 8: Commit**

```bash
git add app/Http/Requests/Admin/Bkk/*MitraRequest.php app/Http/Controllers/Admin/Bkk/MitraController.php resources/views/admin/bkk/mitra/ routes/admin.php tests/Feature/Admin/Bkk/MitraCrudTest.php
git commit -m "feat(bkk): add Mitra DUDI full CRUD with MoU and logo management"
```

---

## Task 5: Modul Admin Bimbingan Karir & Wiring Publik

**Files:**
- Create: `app/Http/Requests/Admin/Bkk/StoreBimbinganRequest.php`
- Create: `app/Http/Requests/Admin/Bkk/UpdateBimbinganRequest.php`
- Create: `app/Http/Controllers/Admin/Bkk/BimbinganController.php`
- Create: `resources/views/admin/bkk/bimbingan/index.blade.php`
- Create: `resources/views/admin/bkk/bimbingan/create.blade.php`
- Create: `resources/views/admin/bkk/bimbingan/edit.blade.php`
- Modify: `app/Http/Controllers/LowonganController.php`
- Modify: `resources/views/pusat-karir/pusat-karir.blade.php`
- Modify: `app/Support/AdminMenu.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Bkk/BimbinganCrudTest.php`

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Admin/Bkk/BimbinganCrudTest.php`:
```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\BimbinganKarir;
use App\Models\BimbinganKategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BimbinganCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_bimbingan_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        $kat = BimbinganKategori::create(['nama' => 'Tips CV', 'slug' => 'tips-cv']);
        BimbinganKarir::create([
            'bimbingan_kategori_id' => $kat->id,
            'title' => 'Panduan CV ATS Friendly',
            'slug' => 'panduan-cv-ats-friendly',
            'description' => 'Langkah membuat CV ramah ATS',
            'is_published' => true,
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.bimbingan.index'));
        $response->assertOk();
        $response->assertSee('Panduan CV ATS Friendly');
    }

    public function test_bkk_user_can_create_bimbingan(): void
    {
        $bkk = User::factory()->bkk()->create();
        $kat = BimbinganKategori::create(['nama' => 'Tips Interview', 'slug' => 'tips-interview']);

        $response = $this->actingAs($bkk)->post(route('admin.bimbingan.store'), [
            'bimbingan_kategori_id' => $kat->id,
            'title' => 'Menghadapi User Interview',
            'description' => 'Tips saat wawancara dengan calon atasan',
            'external_url' => 'https://example.com/tips',
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.bimbingan.index'));
        $this->assertDatabaseHas('bimbingan_karirs', [
            'title' => 'Menghadapi User Interview',
            'slug' => 'menghadapi-user-interview',
            'bimbingan_kategori_id' => $kat->id,
            'is_published' => 1,
        ]);
    }

    public function test_public_pusat_karir_displays_bimbingan_from_database(): void
    {
        $kat = BimbinganKategori::create(['nama' => 'Tips CV', 'slug' => 'tips-cv']);
        BimbinganKarir::create([
            'bimbingan_kategori_id' => $kat->id,
            'title' => 'Judul Bimbingan Dinamis DB',
            'slug' => 'judul-bimbingan-dinamis-db',
            'description' => 'Deskripsi dinamis',
            'external_url' => '#',
            'is_published' => true,
        ]);

        $response = $this->get(route('pusat-karir.index'));
        $response->assertOk();
        $response->assertSee('Judul Bimbingan Dinamis DB');
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/Bkk/BimbinganCrudTest.php`
Expected: FAIL.

- [ ] **Step 3: Create FormRequests & Controller for Bimbingan**

Create `app/Http/Requests/Admin/Bkk/StoreBimbinganRequest.php`:
```php
<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreBimbinganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bimbingan_kategori_id' => ['required', 'exists:bimbingan_kategori,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
        ];
    }
}
```

Create `app/Http/Requests/Admin/Bkk/UpdateBimbinganRequest.php` with similar rules.

Create `app/Http/Controllers/Admin/Bkk/BimbinganController.php`:
Implement:
- `index`, `create`, `store`, `edit`, `update`, `destroy`.
- Support auto slug unik dari `title`.
- Support juga CRUD sederhana kategori bimbingan (`storeKategori`, `destroyKategori`) atau dropdown kategori.

- [ ] **Step 4: Create Views for Bimbingan CRUD**

Create:
- `resources/views/admin/bkk/bimbingan/index.blade.php`: List modul bimbingan karir, kategori badge, url eksternal, status publish, tombol tambah materi & kelola kategori.
- `resources/views/admin/bkk/bimbingan/create.blade.php`: Form tambah materi bimbingan.
- `resources/views/admin/bkk/bimbingan/edit.blade.php`: Form edit materi bimbingan.

- [ ] **Step 5: Wire database to public `LowonganController@index` and view**

In `app/Http/Controllers/LowonganController.php`:
Query bimbingan published beserta kategorinya:
```php
$bimbinganKatalog = \App\Models\BimbinganKarir::with('kategori')
    ->where('is_published', true)
    ->latest()
    ->get()
    ->map(function ($item) {
        return [
            'title' => $item->title,
            'kategori' => $item->kategori->slug ?? 'umum',
            'kategori_label' => $item->kategori->nama ?? 'Umum',
            'type' => 'Materi',
            'url' => $item->external_url ?? '#',
        ];
    })
    ->all();
```
Pass `$bimbinganKatalog` ke view `compact(..., 'bimbinganKatalog')`.

In `resources/views/pusat-karir/pusat-karir.blade.php`:
Hapus fallback hardcoded inline array `$bimbinganKatalog = ...` di baris 853 agar murni mengambil variabel yang dikirim controller (atau empty array jika kosong).

- [ ] **Step 6: Update `AdminMenu.php` and `routes/admin.php`**

Add menu item in `app/Support/AdminMenu.php`:
```php
[
    'group' => 'Pusat Karir',
    'label' => 'Bimbingan Karir',
    'route' => 'admin.bimbingan.index',
    'icon' => 'academic-cap',
    'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
],
```
Add lucide icon handling if needed in `resources/views/admin/layout.blade.php` (`@case('academic-cap') <x-lucide-graduation-cap />` or `<x-lucide-book-open />`).

Add route in `routes/admin.php`:
```php
use App\Http\Controllers\Admin\Bkk\BimbinganController;

Route::resource('bimbingan', BimbinganController::class);
```

- [ ] **Step 7: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/Bkk/BimbinganCrudTest.php`
Expected: PASS

- [ ] **Step 8: Commit**

```bash
git add app/Http/Requests/Admin/Bkk/*BimbinganRequest.php app/Http/Controllers/Admin/Bkk/BimbinganController.php resources/views/admin/bkk/bimbingan/ app/Http/Controllers/LowonganController.php resources/views/pusat-karir/pusat-karir.blade.php app/Support/AdminMenu.php routes/admin.php resources/views/admin/layout.blade.php tests/Feature/Admin/Bkk/BimbinganCrudTest.php
git commit -m "feat(bkk): add Bimbingan Karir CRUD and wire public catalog to database"
```

---

## Task 6: Modul Admin Tracer Study (Alumni, Kuesioner, & Settings)

**Files:**
- Create: `app/Http/Controllers/Admin/Bkk/TracerController.php`
- Create: `app/Http/Requests/Admin/Bkk/StoreAlumniRequest.php`
- Create: `app/Http/Requests/Admin/Bkk/UpdateAlumniRequest.php`
- Create: `app/Http/Requests/Admin/Bkk/UpdateTracerSettingsRequest.php`
- Create: `resources/views/admin/bkk/tracer/index.blade.php`
- Create: `resources/views/admin/bkk/tracer/alumni/create.blade.php`
- Create: `resources/views/admin/bkk/tracer/alumni/edit.blade.php`
- Modify: `app/Support/AdminMenu.php`
- Modify: `routes/admin.php`
- Test: `tests/Feature/Admin/Bkk/TracerStudyTest.php`

- [ ] **Step 1: Write the failing tests**

Create `tests/Feature/Admin/Bkk/TracerStudyTest.php`:
```php
<?php

namespace Tests\Feature\Admin\Bkk;

use App\Models\Alumni;
use App\Models\KuesionerTracer;
use App\Models\TracerSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TracerStudyTest extends TestCase
{
    use RefreshDatabase;

    public function test_bkk_user_can_view_tracer_dashboard_and_alumni_list(): void
    {
        $bkk = User::factory()->bkk()->create();
        Alumni::create([
            'nisn' => '0012345678',
            'nama' => 'Ahmad Dani',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'tahun_lulus' => 2024,
            'angkatan' => 2021,
        ]);

        $response = $this->actingAs($bkk)->get(route('admin.tracer.index'));
        $response->assertOk();
        $response->assertSee('Ahmad Dani');
        $response->assertSee('0012345678');
    }

    public function test_bkk_user_can_create_and_update_alumni(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->post(route('admin.tracer.alumni.store'), [
            'nisn' => '0098765432',
            'nama' => 'Rina Salsabila',
            'jurusan' => 'Desain Komunikasi Visual',
            'tahun_lulus' => 2025,
            'angkatan' => 2022,
        ]);

        $response->assertRedirect(route('admin.tracer.index'));
        $this->assertDatabaseHas('alumnis', [
            'nisn' => '0098765432',
            'nama' => 'Rina Salsabila',
        ]);
    }

    public function test_bkk_user_can_toggle_kuesioner_confirmation(): void
    {
        $bkk = User::factory()->bkk()->create();
        $kuesioner = KuesionerTracer::create([
            'nisn' => '0012345678',
            'nama' => 'Ahmad Dani',
            'jurusan' => 'RPL',
            'tahun_lulus' => 2024,
            'status_pekerjaan' => 'Bekerja',
            'relevansi' => 'Relevan',
            'is_konfirmasi' => false,
        ]);

        $response = $this->actingAs($bkk)->patch(route('admin.tracer.kuesioner.toggle-confirm', $kuesioner));
        $response->assertRedirect();
        $this->assertTrue($kuesioner->fresh()->is_konfirmasi);
    }

    public function test_bkk_user_can_update_tracer_settings(): void
    {
        $bkk = User::factory()->bkk()->create();
        TracerSetting::create([
            'tingkat_keterserapan' => '85%',
        ]);

        $response = $this->actingAs($bkk)->put(route('admin.tracer.settings.update'), [
            'tingkat_keterserapan' => '92.5%',
            'masa_tunggu' => '2.1 Bulan',
            'kesesuaian' => '88%',
            'total_alumni' => '1.450+',
        ]);

        $response->assertRedirect();
        $this->assertEquals('92.5%', TracerSetting::first()->tingkat_keterserapan);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run: `php artisan test tests/Feature/Admin/Bkk/TracerStudyTest.php`
Expected: FAIL because routes and controller do not exist yet.

- [ ] **Step 3: Create Requests & TracerController**

Create `app/Http/Requests/Admin/Bkk/StoreAlumniRequest.php`:
```php
<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumniRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nisn' => ['required', 'string', 'digits:10', 'unique:alumnis,nisn'],
            'nama' => ['required', 'string', 'max:255'],
            'jurusan' => ['required', 'string', 'max:255'],
            'tahun_lulus' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'angkatan' => ['required', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
        ];
    }
}
```

Create `app/Http/Requests/Admin/Bkk/UpdateAlumniRequest.php`:
Similar rules with ignore current ID on unique rule.

Create `app/Http/Requests/Admin/Bkk/UpdateTracerSettingsRequest.php`:
```php
<?php

namespace App\Http\Requests\Admin\Bkk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTracerSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tingkat_keterserapan' => ['nullable', 'string', 'max:50'],
            'keterserapan_trend' => ['nullable', 'string', 'max:50'],
            'masa_tunggu' => ['nullable', 'string', 'max:50'],
            'masa_tunggu_sub' => ['nullable', 'string', 'max:50'],
            'kesesuaian' => ['nullable', 'string', 'max:50'],
            'kesesuaian_sub' => ['nullable', 'string', 'max:50'],
            'total_alumni' => ['nullable', 'string', 'max:50'],
            'total_alumni_sub' => ['nullable', 'string', 'max:50'],
            'catatan_bmw' => ['nullable', 'string'],
        ];
    }
}
```

Create `app/Http/Controllers/Admin/Bkk/TracerController.php`:
Implement:
- `index`: tabs atau seksi (Alumni List with search & filter, Kuesioner Tracer Responses, dan Edit Tracer Settings).
- `createAlumni`, `storeAlumni`, `editAlumni`, `updateAlumni`, `destroyAlumni`.
- `toggleConfirmKuesioner(KuesionerTracer $kuesioner)`.
- `updateSettings(UpdateTracerSettingsRequest $request)`.

- [ ] **Step 4: Create Views for Tracer Study Management**

Create:
- `resources/views/admin/bkk/tracer/index.blade.php`: Tab navigasi terpadu (1. Database Alumni, 2. Respon Kuesioner, 3. Pengaturan Statistik & Indikator).
- `resources/views/admin/bkk/tracer/alumni/create.blade.php`: Form tambah alumni baru.
- `resources/views/admin/bkk/tracer/alumni/edit.blade.php`: Form edit data alumni.

- [ ] **Step 5: Register AdminMenu & routes**

Add menu in `app/Support/AdminMenu.php`:
```php
[
    'group' => 'Pusat Karir',
    'label' => 'Tracer Study',
    'route' => 'admin.tracer.index',
    'icon' => 'chart-bar',
    'roles' => [User::ROLE_ADMIN, User::ROLE_BKK],
],
```

Register in `routes/admin.php`:
```php
use App\Http\Controllers\Admin\Bkk\TracerController;

Route::prefix('tracer')->name('tracer.')->group(function () {
    Route::get('/', [TracerController::class, 'index'])->name('index');
    Route::get('alumni/create', [TracerController::class, 'createAlumni'])->name('alumni.create');
    Route::post('alumni', [TracerController::class, 'storeAlumni'])->name('alumni.store');
    Route::get('alumni/{alumni}/edit', [TracerController::class, 'editAlumni'])->name('alumni.edit');
    Route::put('alumni/{alumni}', [TracerController::class, 'updateAlumni'])->name('alumni.update');
    Route::delete('alumni/{alumni}', [TracerController::class, 'destroyAlumni'])->name('alumni.destroy');

    Route::patch('kuesioner/{kuesioner}/toggle-confirm', [TracerController::class, 'toggleConfirmKuesioner'])->name('kuesioner.toggle-confirm');
    Route::put('settings', [TracerController::class, 'updateSettings'])->name('settings.update');
});
```

- [ ] **Step 6: Run test to verify it passes**

Run: `php artisan test tests/Feature/Admin/Bkk/TracerStudyTest.php`
Expected: PASS

- [ ] **Step 7: Commit**

```bash
git add app/Http/Requests/Admin/Bkk/*AlumniRequest.php app/Http/Requests/Admin/Bkk/UpdateTracerSettingsRequest.php app/Http/Controllers/Admin/Bkk/TracerController.php resources/views/admin/bkk/tracer/ routes/admin.php app/Support/AdminMenu.php tests/Feature/Admin/Bkk/TracerStudyTest.php
git commit -m "feat(bkk): add Tracer Study management including alumni CRUD, kuesioner toggle, and settings"
```

---

## Task 7: Full Test Suite, Pint Code Style, & Regresi

**Files:**
- Test: All tests in `tests/Feature/Admin/Bkk/`
- All modified & created files

- [ ] **Step 1: Run complete PHPUnit test suite**

Run: `php artisan test`
Expected: All tests pass with 0 failures, 0 errors.

- [ ] **Step 2: Run Laravel Pint format inspection and fix**

Run: `php vendor/bin/pint`
Expected: Code style matches Laravel standards cleanly.

- [ ] **Step 3: Final verification commit**

```bash
git add .
git commit -m "chore(bkk): format code and finalize Fase 2 implementation"
```
