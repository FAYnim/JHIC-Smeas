# CRITICAL-02 s/d CRITICAL-05 Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Memperbaiki alur lamaran magang (redirect + popup sukses, simpan berkas, PDF bukti) dan pencatatan dokumen SPMB yang terstruktur dan terlihat oleh siswa & admin.

**Architecture:** Semua perubahan memakai pola yang sudah ada: controller Laravel + Blade, disk `public` untuk upload, Dompdf (sudah dipakai di `SpmbController::unduhFormulir`). Berkas magang dicatat sebagai kolom JSON `documents` pada `magang_applications`. Dokumen SPMB disimpan dengan nama terstruktur (`akta.ext`, `kartu_keluarga.ext`, `ijazah_smp.ext`) sehingga statusnya diturunkan dari filesystem lewat satu method model (tanpa tabel baru, sesuai opsi di report).

**Tech Stack:** Laravel 13, PHP 8.3+, PHPUnit 12 (`php artisan test`), Dompdf, Blade, Laravel Pint.

---

## Hasil Eksplorasi (konteks)

| ID | Temuan terverifikasi di kode |
|----|------------------------------|
| C-02 | [LowonganController::storeApply](../../../app/Http/Controllers/LowonganController.php) selalu `response()->json(..., 201)`. Popup `session('lamaran_success')` di `detail-lowongan.blade.php:1356` memakai key `registration_code` & `nisn`. Test lama `LowonganApplyValidationTest::test_numeric_nisn_is_accepted` mengharapkan JSON 201 (tanpa header Accept) — harus diubah. |
| C-03 | Form `lamar-lowongan.blade.php` membuat input per `$lowongan->dokumen` dengan `name = Str::slug($doc['name'], '_')` (contoh `CV.pdf` -> `cv_pdf`; tipe `link` = `<input type="url">`). Controller hanya validasi `nisn`. Tabel `magang_applications` tak punya kolom berkas. Admin view `admin/bkk/lamaran/index.blade.php` belum menampilkan berkas. |
| C-04 | `SpmbController::saveDokumen` memakai `store()` (nama hash acak) sehingga jenis dokumen tak bisa dikenali. `verifikasi.blade.php:124-152` statis "Wajib diunggah". Admin `CalonSiswaController::show` menebak isi folder. Key `docs[kartu-keluarga]` / `docs[ijazah-smp]` kebab-case (ikut dirapikan = MEDIUM-06, karena baris yang sama disentuh). |
| C-05 | Tombol `.success-download-btn` (`detail-lowongan.blade.php:1403`) tanpa aksi. Ada 5 anchor `href="#" class="doc-unduh-btn"` (2 salinan card "Dokumen & Silabus" + milik tab info) berisi file demo hardcoded; tidak ada data silabus di model `Lowongan`. Dompdf sudah ada. |

**Keputusan desain:**
- C-05 PDF bukti: diimplementasikan (route baru). Link silabus: **dinonaktifkan** (bukan dihapus) karena itu data demo tanpa sumber file — tidak membuat fitur silabus baru (YAGNI).
- Reupload dokumen SPMB wajib mengunggah ketiga berkas lagi (perilaku `required` lama dipertahankan).
- File lama SPMB bernama hash tidak dimigrasi; akan tampil sebagai "belum diunggah" sampai diunggah ulang.

## File Structure

| File | Aksi | Tanggung jawab |
|------|------|----------------|
| `app/Http/Controllers/LowonganController.php` | Modify | `storeApply` (redirect/JSON + upload), `unduhBukti` (PDF) |
| `database/migrations/2026_10_03_100000_add_documents_to_magang_applications_table.php` | Create | kolom `documents` JSON nullable |
| `app/Models/MagangApplication.php` | Modify | fillable + cast `documents` |
| `resources/views/admin/bkk/lamaran/index.blade.php` | Modify | kolom "Berkas" |
| `resources/views/pusat-karir/bukti-lamaran-pdf.blade.php` | Create | template PDF bukti |
| `routes/web.php` | Modify | route `pusat-karir.bukti-lamar` |
| `resources/views/pusat-karir/detail-lowongan.blade.php` | Modify | tombol bukti jadi link; nonaktifkan link silabus |
| `app/Models/CalonSiswa.php` | Modify | `DOKUMEN` const + `dokumenStatus()` |
| `app/Http/Controllers/SpmbController.php` | Modify | `saveDokumen` nama terstruktur; pass `$dokumenStatus` |
| `app/Http/Controllers/Admin/Spmb/CalonSiswaController.php` | Modify | `show` pakai `dokumenStatus()` |
| `resources/views/spmb/dashboard/{dokumen,verifikasi}.blade.php`, `resources/views/admin/spmb/calon-siswa/show.blade.php` | Modify | tampilkan status riil |
| `tests/Feature/LowonganApplyValidationTest.php` | Modify | sesuaikan + test baru |
| `tests/Feature/LowonganApplyUploadTest.php`, `tests/Feature/LowonganBuktiPdfTest.php`, `tests/Feature/SpmbDokumenTest.php` | Create | test fitur baru |

---

### Task 1: CRITICAL-02 — storeApply redirect dengan flash session

**Files:**
- Modify: `app/Http/Controllers/LowonganController.php` (method `storeApply`, baris 119-142; import)
- Test: `tests/Feature/LowonganApplyValidationTest.php`

- [ ] **Step 1: Update test lama & tambah test (failing)**

Ganti `test_numeric_nisn_is_accepted` dengan dua test berikut (CV pdf wajib akan ditambah di Task 2, jadi lowongan test saat ini punya dokumen `CV.pdf` — di Task 1 ubah `makeLowongan()` agar `'dokumen' => []` supaya task ini independen; Task 2 menambah test dengan dokumen sendiri):

```php
    public function test_regular_post_redirects_to_detail_with_flash(): void
    {
        $lowongan = $this->makeLowongan();

        $response = $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'consent' => 'on',
        ]);

        $response->assertRedirect(route('pusat-karir.detail', $lowongan->slug));
        $response->assertSessionHas('lamaran_success', function (array $data): bool {
            return $data['nisn'] === '1234567890'
                && str_starts_with($data['registration_code'], 'PKL-');
        });
    }

    public function test_json_request_still_receives_json(): void
    {
        $lowongan = $this->makeLowongan();

        $response = $this->postJson(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'consent' => 'on',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Ajuan lamaran magang Anda berhasil dikirim.',
        ]);
    }
```

Di `makeLowongan()` ubah baris `'dokumen' => [[...]]` menjadi `'dokumen' => [],`.

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/LowonganApplyValidationTest.php`
Expected: `test_regular_post_redirects_to_detail_with_flash` FAIL (response 201, bukan redirect).

- [ ] **Step 3: Implementasi minimal**

Tambah import (urut alfabet): `use Illuminate\Http\JsonResponse;` sebelum `RedirectResponse`. Ganti `return response()->json([...], 201);` dan signature:

```php
    public function storeApply(Request $request, string $slug): RedirectResponse|JsonResponse
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nisn' => ['required', 'numeric', 'digits:10'],
        ]);

        $application = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => $validated['nisn'],
            'registration_code' => $this->generateRegistrationCode($lowongan->company_short ?? 'TELKOM'),
            'status' => 'pending',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ajuan lamaran magang Anda berhasil dikirim.',
                'data' => [
                    'nisn' => $application->nisn,
                    'registration_code' => $application->registration_code,
                ],
            ], 201);
        }

        return redirect()->route('pusat-karir.detail', $lowongan->slug)
            ->with('lamaran_success', [
                'nisn' => $application->nisn,
                'registration_code' => $application->registration_code,
            ]);
    }
```

- [ ] **Step 4: Jalankan, pastikan lulus**

Run: `php artisan test tests/Feature/LowonganApplyValidationTest.php`
Expected: PASS (semua test file ini).

- [ ] **Step 5: Commit**

```bash
git add app/Http/Controllers/LowonganController.php tests/Feature/LowonganApplyValidationTest.php
git commit -m "fix: redirect storeApply to detail with lamaran_success flash"
```

---

### Task 2: CRITICAL-03 — Simpan berkas lamaran magang

**Files:**
- Create: `database/migrations/2026_10_03_100000_add_documents_to_magang_applications_table.php`
- Modify: `app/Models/MagangApplication.php`, `app/Http/Controllers/LowonganController.php`, `resources/views/admin/bkk/lamaran/index.blade.php`
- Test: `tests/Feature/LowonganApplyUploadTest.php`

- [ ] **Step 1: Tulis test (failing)**

```php
<?php

namespace Tests\Feature;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LowonganApplyUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_required_pdf_is_validated(): void
    {
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
        ])->assertSessionHasErrors('cv_pdf');

        $this->assertDatabaseCount('magang_applications', 0);
    }

    public function test_non_pdf_is_rejected(): void
    {
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'cv_pdf' => UploadedFile::fake()->create('cv.png', 10, 'image/png'),
        ])->assertSessionHasErrors('cv_pdf');
    }

    public function test_uploaded_files_are_stored_and_recorded(): void
    {
        Storage::fake('public');
        $lowongan = $this->makeLowongan();

        $this->post(route('pusat-karir.store-lamar', $lowongan->slug), [
            'nisn' => '1234567890',
            'cv_pdf' => UploadedFile::fake()->create('cv.pdf', 100, 'application/pdf'),
            'portofolio' => 'https://example.com/porto',
        ])->assertSessionHasNoErrors();

        $application = MagangApplication::firstOrFail();
        $documents = collect($application->documents)->keyBy('key');

        $this->assertSame('file', $documents['cv_pdf']['type']);
        Storage::disk('public')->assertExists($documents['cv_pdf']['value']);
        $this->assertSame('https://example.com/porto', $documents['portofolio']['value']);
    }

    protected function makeLowongan(): Lowongan
    {
        return Lowongan::create([
            'company_name' => 'PT Telkom Indonesia',
            'company_short' => 'Telkom Indonesia',
            'is_mitra_dudi' => true,
            'title' => 'Software Engineer Intern (PKL)',
            'slug' => 'telkom-software-engineer-intern',
            'location' => 'Surabaya, Jatim',
            'duration' => '6 Bulan (Jan - Jun)',
            'jurusan' => 'Khusus RPL & SIJA',
            'kuota' => 2,
            'metode_kerja' => 'On-site (Surabaya)',
            'deskripsi' => 'Deskripsi contoh untuk testing.',
            'tanggung_jawab' => ['Mengerjakan tugas harian'],
            'kualifikasi' => ['Siswa aktif'],
            'dokumen' => [
                ['name' => 'CV.pdf', 'desc' => 'CV', 'type' => 'pdf'],
                ['name' => 'Portofolio', 'desc' => 'Link', 'type' => 'link'],
            ],
            'benefits' => ['Uang saku'],
            'batas_pendaftaran' => '2026-08-15',
            'durasi_pelaksanaan' => '6 Bulan',
            'status_kuota' => 'Tersedia',
            'pokja_nama' => 'Pokja PKL',
            'pokja_koordinator' => 'Bpk. Test',
            'pokja_wa' => '6281234567890',
        ]);
    }
}
```

- [ ] **Step 2: Jalankan, pastikan gagal**

Run: `php artisan test tests/Feature/LowonganApplyUploadTest.php`
Expected: FAIL (tidak ada error validasi `cv_pdf` / kolom `documents` tidak ada).

- [ ] **Step 3: Migration**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            $table->json('documents')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('magang_applications', function (Blueprint $table) {
            $table->dropColumn('documents');
        });
    }
};
```

- [ ] **Step 4: Model**

Di `MagangApplication`: tambah `'documents'` ke `$fillable` dan method:

```php
    protected function casts(): array
    {
        return [
            'documents' => 'array',
        ];
    }
```

- [ ] **Step 5: Controller — ganti isi `storeApply` (versi final Task 1 + upload)**

```php
    public function storeApply(Request $request, string $slug): RedirectResponse|JsonResponse
    {
        $lowongan = Lowongan::where('slug', $slug)->firstOrFail();

        $requirements = collect($lowongan->dokumen ?? [])->map(fn (array $doc): array => [
            'key' => Str::slug($doc['name'], '_'),
            'label' => str_replace(['_', '.pdf'], [' ', ''], $doc['name']),
            'type' => ($doc['type'] ?? 'pdf') === 'link' ? 'link' : 'file',
        ]);

        $rules = ['nisn' => ['required', 'numeric', 'digits:10']];
        foreach ($requirements as $doc) {
            $rules[$doc['key']] = $doc['type'] === 'link'
                ? ['nullable', 'url', 'max:2048']
                : ['required', 'file', 'mimes:pdf', 'max:2048'];
        }

        $validated = $request->validate($rules);

        $registrationCode = $this->generateRegistrationCode($lowongan->company_short ?? 'TELKOM');

        $documents = [];
        foreach ($requirements as $doc) {
            if ($doc['type'] === 'link') {
                if (! empty($validated[$doc['key']])) {
                    $documents[] = $doc + ['value' => $validated[$doc['key']]];
                }

                continue;
            }

            $path = $request->file($doc['key'])
                ->storeAs("magang/{$registrationCode}", $doc['key'].'.pdf', 'public');
            $documents[] = $doc + ['value' => $path];
        }

        $application = MagangApplication::create([
            'lowongan_id' => $lowongan->id,
            'nisn' => $validated['nisn'],
            'registration_code' => $registrationCode,
            'status' => 'pending',
            'documents' => $documents,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ajuan lamaran magang Anda berhasil dikirim.',
                'data' => [
                    'nisn' => $application->nisn,
                    'registration_code' => $application->registration_code,
                ],
            ], 201);
        }

        return redirect()->route('pusat-karir.detail', $lowongan->slug)
            ->with('lamaran_success', [
                'nisn' => $application->nisn,
                'registration_code' => $application->registration_code,
            ]);
    }
```

- [ ] **Step 6: Admin view — kolom Berkas**

Di `resources/views/admin/bkk/lamaran/index.blade.php`: sisipkan setelah baris 49 (`<th ...>Posisi Lowongan</th>`):

```blade
                    <th class="px-4 py-3">Berkas</th>
```

Sisipkan setelah blok `<td>` Perusahaan (baris 63):

```blade
                        <td class="px-4 py-3">
                            <div class="flex flex-col gap-1">
                                @forelse (($lamaran->documents ?? []) as $doc)
                                    <a href="{{ $doc['type'] === 'link' ? $doc['value'] : asset('storage/'.$doc['value']) }}"
                                        target="_blank" rel="noopener"
                                        class="text-xs font-semibold text-blue-600 hover:underline">{{ $doc['label'] }}</a>
                                @empty
                                    <span class="text-xs text-slate-400">-</span>
                                @endforelse
                            </div>
                        </td>
```

Ubah `colspan="7"` menjadi `colspan="8"`.

- [ ] **Step 7: Jalankan migrasi & test**

Run: `php artisan test tests/Feature/LowonganApplyUploadTest.php tests/Feature/LowonganApplyValidationTest.php`
Expected: PASS. (Lokal: `php artisan migrate`.)

- [ ] **Step 8: Commit**

```bash
git add database/migrations app/Models/MagangApplication.php app/Http/Controllers/LowonganController.php resources/views/admin/bkk/lamaran/index.blade.php tests/Feature/LowonganApplyUploadTest.php
git commit -m "feat: validate and store magang application documents"
```

---

### Task 3: CRITICAL-05a — PDF Bukti Pengajuan Magang

**Files:**
- Modify: `app/Http/Controllers/LowonganController.php`, `routes/web.php`, `resources/views/pusat-karir/detail-lowongan.blade.php:1403-1405`
- Create: `resources/views/pusat-karir/bukti-lamaran-pdf.blade.php`
- Test: `tests/Feature/LowonganBuktiPdfTest.php`

- [ ] **Step 1: Test (failing)**

```php
<?php

namespace Tests\Feature;

use App\Models\Lowongan;
use App\Models\MagangApplication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LowonganBuktiPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_bukti_pdf_can_be_downloaded(): void
    {
        $lowongan = Lowongan::create([
            'company_name' => 'PT Uji', 'company_short' => 'Uji', 'is_mitra_dudi' => true,
            'title' => 'Intern', 'slug' => 'uji-intern', 'location' => 'Surabaya',
            'duration' => '3 Bulan', 'jurusan' => 'RPL', 'kuota' => 1,
            'metode_kerja' => 'On-site', 'deskripsi' => 'x', 'tanggung_jawab' => [],
            'kualifikasi' => [], 'dokumen' => [], 'benefits' => [],
            'batas_pendaftaran' => '2026-12-01', 'durasi_pelaksanaan' => '3 Bulan',
            'status_kuota' => 'Tersedia', 'pokja_nama' => 'P', 'pokja_koordinator' => 'K',
            'pokja_wa' => '62800000000',
        ]);
        $application = MagangApplication::create([
            'lowongan_id' => $lowongan->id, 'nisn' => '1234567890',
            'registration_code' => 'PKL-UJI-20261003-ABCDEFGH', 'status' => 'pending',
        ]);

        $response = $this->get(route('pusat-karir.bukti-lamar', $application->registration_code));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_unknown_code_returns_404(): void
    {
        $this->get(route('pusat-karir.bukti-lamar', 'PKL-TIDAK-ADA'))->assertNotFound();
    }
}
```

- [ ] **Step 2: Jalankan** — `php artisan test tests/Feature/LowonganBuktiPdfTest.php` → FAIL (route tidak ada).

- [ ] **Step 3: Route** — tambahkan di `routes/web.php` setelah route `pusat-karir.store-lamar` (baris 96):

```php
Route::get('/pusat-karir/lamaran/{registrationCode}/bukti', [LowonganController::class, 'unduhBukti'])->name('pusat-karir.bukti-lamar');
```

(4 segmen, tidak bentrok dengan `/pusat-karir/{slug}/lamar`.)

- [ ] **Step 4: Controller** — tambah import `use Dompdf\Dompdf;` dan `use Dompdf\Options;` (urut alfabet di atas `Illuminate`), lalu method (sebelum `generateRegistrationCode`):

```php
    public function unduhBukti(string $registrationCode)
    {
        $application = MagangApplication::with('lowongan')
            ->where('registration_code', $registrationCode)
            ->firstOrFail();

        $options = new Options;
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('pusat-karir.bukti-lamaran-pdf', compact('application'))->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream("bukti-{$application->registration_code}.pdf", ['Attachment' => true]);
    }
```

- [ ] **Step 5: View PDF** `resources/views/pusat-karir/bukti-lamaran-pdf.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Pengajuan Magang {{ $application->registration_code }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #0f172a; }
        h1 { font-size: 18px; margin: 0 0 4px; }
        .sub { color: #64748b; margin-bottom: 20px; }
        .code { font-size: 16px; font-weight: bold; padding: 10px 14px; background: #eff6ff; border: 1px solid #bfdbfe; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        td { padding: 8px 0; border-bottom: 1px solid #e2e8f0; }
        td:first-child { width: 35%; color: #64748b; }
    </style>
</head>
<body>
    <h1>Bukti Pengajuan Magang (PKL)</h1>
    <p class="sub">SMK Negeri 1 Surabaya &mdash; Pusat Karir</p>

    <div class="code">{{ $application->registration_code }}</div>

    <table>
        <tr><td>NISN</td><td>{{ $application->nisn }}</td></tr>
        <tr><td>Posisi Magang</td><td>{{ $application->lowongan?->title ?? '-' }}</td></tr>
        <tr><td>Mitra Industri</td><td>{{ $application->lowongan?->company_name ?? '-' }}</td></tr>
        <tr><td>Status</td><td>{{ ucfirst($application->status) }}</td></tr>
        <tr><td>Tanggal Pengajuan</td><td>{{ $application->created_at->format('d M Y H:i') }}</td></tr>
    </table>
</body>
</html>
```

- [ ] **Step 6: Tombol popup** — di `detail-lowongan.blade.php` ganti baris 1403-1405:

```blade
                    <a href="{{ route('pusat-karir.bukti-lamar', $lamaran['registration_code']) }}"
                        class="success-download-btn" style="display: block; text-align: center; text-decoration: none;">
                        Unduh Bukti Pengajuan (PDF)
                    </a>
```

- [ ] **Step 7: Test lulus** — `php artisan test tests/Feature/LowonganBuktiPdfTest.php` → PASS.

- [ ] **Step 8: Commit**

```bash
git add app/Http/Controllers/LowonganController.php routes/web.php resources/views/pusat-karir tests/Feature/LowonganBuktiPdfTest.php
git commit -m "feat: add magang application proof PDF download"
```

---

### Task 4: CRITICAL-05b — Nonaktifkan link silabus kosong

**Files:** Modify `resources/views/pusat-karir/detail-lowongan.blade.php`

- [ ] **Step 1: Ganti semua anchor mati** (5 kemunculan) — jalankan di PowerShell dari root repo:

```powershell
$f = 'resources\views\pusat-karir\detail-lowongan.blade.php'
(Get-Content $f -Raw) -replace '<a href="#" class="doc-unduh-btn">', '<a aria-disabled="true" tabindex="-1" title="Dokumen belum tersedia" class="doc-unduh-btn">' | Set-Content $f -NoNewline
```

- [ ] **Step 2: Style non-aktif** — di blok `<style>` file yang sama, tambahkan di dekat definisi `.doc-unduh-btn`:

```css
.doc-unduh-btn[aria-disabled="true"] { pointer-events: none; opacity: 0.45; cursor: not-allowed; }
```

- [ ] **Step 3: Verifikasi**

Run: `rg 'href="#" class="doc-unduh-btn"' resources/views` — Expected: tidak ada hasil.
Run: `php artisan test` — Expected: PASS.

- [ ] **Step 4: Commit**

```bash
git add resources/views/pusat-karir/detail-lowongan.blade.php
git commit -m "fix: disable unavailable silabus download links"
```

---

### Task 5: CRITICAL-04 — Dokumen SPMB terstruktur & status riil

**Files:**
- Modify: `app/Models/CalonSiswa.php`, `app/Http/Controllers/SpmbController.php`, `app/Http/Controllers/Admin/Spmb/CalonSiswaController.php`, `resources/views/spmb/dashboard/dokumen.blade.php`, `resources/views/spmb/dashboard/verifikasi.blade.php`, `resources/views/admin/spmb/calon-siswa/show.blade.php`
- Test: `tests/Feature/SpmbDokumenTest.php`

- [ ] **Step 1: Test (failing)**

```php
<?php

namespace Tests\Feature;

use App\Models\CalonSiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SpmbDokumenTest extends TestCase
{
    use RefreshDatabase;

    public function test_documents_are_saved_with_structured_names_and_reported(): void
    {
        Storage::fake('public');
        $siswa = CalonSiswa::create([
            'nisn' => '1234567890', 'nama_lengkap' => 'Budi', 'asal_sekolah' => 'SMPN 1',
        ]);

        $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-dokumen'), ['docs' => [
                'akta' => UploadedFile::fake()->create('a.pdf', 50, 'application/pdf'),
                'kartu_keluarga' => UploadedFile::fake()->create('b.jpg', 50, 'image/jpeg'),
                'ijazah_smp' => UploadedFile::fake()->create('c.png', 50, 'image/png'),
            ]])
            ->assertRedirect(route('spmb.dokumen'));

        Storage::disk('public')->assertExists('spmb/1234567890/akta.pdf');
        Storage::disk('public')->assertExists('spmb/1234567890/kartu_keluarga.jpg');
        Storage::disk('public')->assertExists('spmb/1234567890/ijazah_smp.png');

        $status = $siswa->dokumenStatus();
        $this->assertTrue($status['akta']['uploaded']);
        $this->assertSame('kartu_keluarga.jpg', $status['kartu_keluarga']['name']);
    }

    public function test_reupload_replaces_previous_extension(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('spmb/1234567890/akta.pdf', 'lama');
        CalonSiswa::create(['nisn' => '1234567890', 'nama_lengkap' => 'Budi', 'asal_sekolah' => 'SMPN 1']);

        $this->withSession(['spmb_nisn' => '1234567890'])
            ->post(route('spmb.save-dokumen'), ['docs' => [
                'akta' => UploadedFile::fake()->create('a.png', 50, 'image/png'),
                'kartu_keluarga' => UploadedFile::fake()->create('b.png', 50, 'image/png'),
                'ijazah_smp' => UploadedFile::fake()->create('c.png', 50, 'image/png'),
            ]]);

        Storage::disk('public')->assertMissing('spmb/1234567890/akta.pdf');
        Storage::disk('public')->assertExists('spmb/1234567890/akta.png');
    }

    public function test_missing_status_when_nothing_uploaded(): void
    {
        Storage::fake('public');
        $siswa = CalonSiswa::create(['nisn' => '1234567890', 'nama_lengkap' => 'Budi', 'asal_sekolah' => 'SMPN 1']);

        $this->assertFalse($siswa->dokumenStatus()['akta']['uploaded']);
    }
}
```

- [ ] **Step 2: Jalankan** — `php artisan test tests/Feature/SpmbDokumenTest.php` → FAIL (`dokumenStatus` tidak ada).

- [ ] **Step 3: Model `CalonSiswa`** — tambah `use Illuminate\Support\Facades\Storage;`, lalu di dalam class:

```php
    public const DOKUMEN = [
        'akta' => 'Akta Kelahiran',
        'kartu_keluarga' => 'Kartu Keluarga',
        'ijazah_smp' => 'Ijazah SMP',
    ];

    /**
     * Status unggahan per jenis dokumen, diturunkan dari nama file terstruktur.
     *
     * @return array<string, array{label: string, uploaded: bool, name: ?string, url: ?string, size: ?int}>
     */
    public function dokumenStatus(): array
    {
        $disk = Storage::disk('public');
        $files = $disk->files("spmb/{$this->nisn}");

        $status = [];
        foreach (self::DOKUMEN as $key => $label) {
            $path = collect($files)->first(fn (string $file): bool => pathinfo($file, PATHINFO_FILENAME) === $key);

            $status[$key] = [
                'label' => $label,
                'uploaded' => $path !== null,
                'name' => $path !== null ? basename($path) : null,
                'url' => $path !== null ? $disk->url($path) : null,
                'size' => $path !== null ? $disk->size($path) : null,
            ];
        }

        return $status;
    }
```

- [ ] **Step 4: `SpmbController::saveDokumen`** — tambah `use Illuminate\Support\Facades\Storage;` (urut: setelah `Redirect`, sebelum `View`), ganti isi method:

```php
    public function saveDokumen(Request $request)
    {
        $request->validate([
            'docs.akta' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'docs.kartu_keluarga' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'docs.ijazah_smp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'docs.akta.required' => 'Akta kelahiran wajib diunggah.',
            'docs.kartu_keluarga.required' => 'Kartu keluarga wajib diunggah.',
            'docs.ijazah_smp.required' => 'Ijazah SMP wajib diunggah.',
        ]);

        $nisn = session('spmb_nisn');
        $disk = Storage::disk('public');

        foreach (array_keys(CalonSiswa::DOKUMEN) as $key) {
            foreach ($disk->files("spmb/{$nisn}") as $existing) {
                if (pathinfo($existing, PATHINFO_FILENAME) === $key) {
                    $disk->delete($existing);
                }
            }

            $file = $request->file("docs.{$key}");
            $file->storeAs("spmb/{$nisn}", $key.'.'.$file->extension(), 'public');
        }

        return Redirect::route('spmb.dokumen')
            ->with('spmb_notice', 'Dokumen tersimpan.');
    }
```

Ubah `dokumen()` dan `verifikasi()` agar meneruskan status:

```php
    public function dokumen()
    {
        $calonSiswa = CalonSiswa::where('nisn', session('spmb_nisn'))->first();

        return view('spmb.dashboard.dokumen', [
            'dokumenStatus' => $calonSiswa?->dokumenStatus() ?? [],
        ]);
    }
```

dan di `verifikasi()`:

```php
        return view('spmb.dashboard.verifikasi', [
            'calonSiswa' => $calonSiswa,
            'dokumenStatus' => $calonSiswa?->dokumenStatus() ?? [],
        ]);
```

- [ ] **Step 5: View `dokumen.blade.php`** — ganti name/error key kebab -> snake (3 tempat tiap jenis):

- `docs[kartu-keluarga]` -> `docs[kartu_keluarga]`, `@error('docs.kartu-keluarga')` -> `@error('docs.kartu_keluarga')`
- `docs[ijazah-smp]` -> `docs[ijazah_smp]`, `@error('docs.ijazah-smp')` -> `@error('docs.ijazah_smp')`

Sisipkan di bawah tiap `<div class="flex flex-wrap ...">` header dokumen (sebelum `<input ...>`), mengganti `akta`/`kartu_keluarga`/`ijazah_smp` sesuai blok:

```blade
                    @if (($dokumenStatus['akta']['uploaded'] ?? false))
                        <p class="mt-2 text-xs font-semibold text-emerald-700">Sudah diunggah: {{ $dokumenStatus['akta']['name'] }}</p>
                    @endif
```

- [ ] **Step 6: View `verifikasi.blade.php`** — ganti isi grid baris 124-152 (tiga card statis) dengan:

```blade
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach (\App\Models\CalonSiswa::DOKUMEN as $key => $label)
                    @php $doc = $dokumenStatus[$key] ?? ['uploaded' => false, 'name' => null]; @endphp
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-md bg-[#1d5fa8]/10 text-[#1d5fa8] flex items-center justify-center shrink-0">
                            <x-lucide-book class="w-4 h-4" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-bold text-slate-900 truncate">{{ strtoupper($label) }}</p>
                            @if ($doc['uploaded'])
                                <p class="text-[0.65rem] font-semibold text-emerald-600 truncate">Terunggah &middot; {{ $doc['name'] }}</p>
                            @else
                                <p class="text-[0.65rem] font-semibold text-slate-400">Belum diunggah</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
```

(Catatan Pint/AGENTS.md melarang FQCN inline di kode PHP; di Blade, tambahkan `@use('App\Models\CalonSiswa')` di baris pertama setelah `@extends` lalu pakai `CalonSiswa::DOKUMEN`.)

- [ ] **Step 7: Admin** — `CalonSiswaController::show` ganti isi dan hapus `use Illuminate\Support\Facades\Storage;`:

```php
    public function show(CalonSiswa $calonSiswa): View
    {
        $documents = $calonSiswa->dokumenStatus();

        return view('admin.spmb.calon-siswa.show', compact('calonSiswa', 'documents'));
    }
```

Di `show.blade.php` ganti blok baris 144-165 (`@if (!empty($files)) ... @endif`) dengan:

```blade
                <ul class="divide-y divide-slate-100">
                    @foreach ($documents as $doc)
                        <li class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $doc['label'] }}</p>
                                @if ($doc['uploaded'])
                                    <p class="text-xs text-slate-400">{{ $doc['name'] }} &middot; {{ round($doc['size'] / 1024, 1) }} KB</p>
                                @else
                                    <p class="text-xs font-semibold text-red-500">Belum diunggah</p>
                                @endif
                            </div>
                            @if ($doc['uploaded'])
                                <a href="{{ $doc['url'] }}" target="_blank" rel="noopener"
                                    class="inline-flex items-center gap-1 rounded-md bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-700 hover:bg-slate-200 shrink-0">
                                    <x-lucide-external-link class="w-3.5 h-3.5" />
                                    Buka
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
```

- [ ] **Step 8: Cek test admin yang terdampak**

Run: `rg "files" tests/Feature/Admin/Spmb` — jika ada assertion `files`, ubah menjadi `documents`.

- [ ] **Step 9: Jalankan test**

Run: `php artisan test tests/Feature/SpmbDokumenTest.php tests/Feature/SpmbSaveDataTest.php tests/Feature/Admin/Spmb`
Expected: PASS.

- [ ] **Step 10: Commit**

```bash
git add app resources/views tests
git commit -m "feat: structured SPMB document storage with real upload status"
```

---

### Task 6: Verifikasi akhir & update report

- [ ] **Step 1:** `php vendor/bin/pint --dirty` — Expected: 0 file perlu diperbaiki (atau auto-fix).
- [ ] **Step 2:** `php artisan test` — Expected: seluruh suite PASS.
- [ ] **Step 3:** Smoke manual: `php artisan serve`; ajukan lamaran magang -> popup muncul + unduh PDF; unggah dokumen SPMB -> `verifikasi` menampilkan "Terunggah"; admin `/admin/lamaran` & `/admin/calon-siswa/{id}` menampilkan berkas.
- [ ] **Step 4:** Di `report.md` tandai CRITICAL-02..05 sebagai `✅ FIXED` (judul, tabel ringkasan "5 Temuan (5 Fixed)", baris checklist 2-5) dan MEDIUM-06 sebagai fixed.
- [ ] **Step 5:** Commit

```bash
git add report.md
git commit -m "docs: mark CRITICAL-02..05 and MEDIUM-06 as fixed"
```

---

## Self-Review

- **Spec coverage:** C-02 → Task 1; C-03 → Task 2 (migration, upload, admin tampilan); C-04 → Task 5 (nama terstruktur, status siswa & admin); C-05 → Task 3 (PDF) + Task 4 (silabus). Bonus MEDIUM-06 ditangani di Task 5.
- **Placeholder scan:** tidak ada TBD; semua langkah berisi kode/perintah.
- **Konsistensi:** `dokumenStatus()` & `CalonSiswa::DOKUMEN` dipakai konsisten di Task 5; key `lamaran_success` (`nisn`, `registration_code`) cocok dengan popup; `documents` item berbentuk `key/label/type/value` dipakai sama di controller dan admin view; route `pusat-karir.bukti-lamar` konsisten di Task 3.
- **Risiko:** Task 1 mengubah dokumen test `makeLowongan` jadi `[]` agar independen dari Task 2; `LowonganApplyValidationTest` lain tidak terdampak.
