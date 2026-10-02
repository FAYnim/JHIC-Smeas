# Fix 12 Bug Error-List — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [x]`) syntax for tracking.

**Goal:** Memperbaiki 12 bug dari `error-list`: kegagalan simpan lowongan & webinar, validasi yang tidak informatif, catatan verifikasi wajib saat ditolak, batas panjang input (maxlength + validasi max), overflow teks yang menutup tombol aksi, ambiguitas durasi, dan chip nama user yang meluap.

**Architecture:** Dua migrasi kecil (nullable kolom JSON lowongan; nullable `durasi_pelaksanaan`), perubahan FormRequest (rule max, pesan Indonesia, `required_if`), perubahan controller (set `dokumen` default, wajib catatan), dan perubahan Blade (`maxlength`, `@error`, `line-clamp`/`truncate`, chip user). Tidak ada perubahan routing.

**Tech Stack:** Laravel ^13.17 (PHP 8.3), Blade, Tailwind, MySQL (dev/prod) / SQLite `:memory:` (test), PHPUnit 12.

**Catatan penting untuk eksekutor:**
- Test suite memakai **SQLite :memory:** (`phpunit.xml`) — migrasi baru harus kompatibel SQLite (pakai Schema Builder, bukan `DB::statement` MySQL-specific).
- Kolom JSON lama di `lowongans` dibuat dengan `->default('[]')` yang **diabaikan MySQL 8** (strict mode) → ini penyebab error #1 (terbukti via tinker: `1364 Field 'tanggung_jawab' doesn't have a default value`).
- Jalankan `php artisan migrate` ke DB dev **hanya setelah konfirmasi user** (test tidak menyentuh DB dev).
- Konvensi test mengikuti file existing: `RefreshDatabase`, `User::factory()->bkk()->create()`, dst.

---

## Ringkasan Error → Task

| # | Error | Task |
|---|-------|------|
| 1 | Tambah lowongan gagal simpan (JSON default value) | Task 1 |
| 4 | Tambah/edit webinar gagal (start_time TIME vs teks) | Task 2 |
| 7 | Verifikasi ditolak tanpa catatan + siswa tak lihat status | Task 3 |
| 9 | Tambah mitra: tak tahu field mana yang salah | Task 4 |
| 10 | Durasi vs durasi pelaksanaan | Task 5 |
| 12 | Chip nama user panjang meluap di admin | Task 6 |
| 2 | Bimbingan karir & tracer study: limit input + clamp teks | Task 7 |
| 3 | Artikel, guru/tendik, pimpinan/WKS, fasilitas: limit + clamp | Task 8 |
| 5 | Struktur organisasi unit & bagian: limit + clamp | Task 8 |
| 6 | Dashboard: judul artikel keluar kotak | Task 9 |
| 8 | Pengumuman & FAQ SPMB: limit + clamp | Task 10 |
| 11 | Pengguna sistem: limit + clamp | Task 11 |

**Pola umum "limit input" (Task 7–11):** setiap input/textarea yang rule-nya punya `max:N` di FormRequest diberi atribut HTML `maxlength="N"` (dan `rows` tetap), sehingga user tak bisa "spam huruf". Textarea tanpa limit diberi limit wajar (disebut per task).

**Pola umum "clamp teks" (Task 7–11):** sel teks panjang di tabel admin diberi `max-w-*` + Tailwind `truncate` (1 baris) atau `line-clamp-N` (multi-baris) sehingga kolom aksi (Edit/Hapus) tidak tertutup.

---

### Task 1: Fix lowongan gagal simpan — kolom JSON default value (Error #1)

Kolom `tanggung_jawab`, `kualifikasi`, `dokumen`, `benefits` NOT NULL tanpa default efektif. Controller tidak pernah mengisi `dokumen` → setiap store/edit yang validasi lolos tetap bisa gagal di DB.

**Files:**
- Create: `database/migrations/2026_10_02_300001_make_lowongan_json_columns_nullable.php`
- Modify: `app/Http/Controllers/Admin/Bkk/LowonganController.php` (method `prepareData`, baris 106-119)
- Test: `tests/Feature/Admin/Bkk/LowonganCrudTest.php`

- [x] **Step 1: Tulis test regression**

Tambahkan method di `tests/Feature/Admin/Bkk/LowonganCrudTest.php` (setelah `test_bkk_user_can_create_lowongan_with_auto_slug_and_logo`):

```php
    public function test_store_without_optional_multiline_fields_succeeds(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->post(route('admin.lowongan.store'), [
            'company_name' => 'PT Tanpa Dokumen',
            'title' => 'Posisi Tanpa Dokumen',
            'jenis' => 'lowongan',
            'location' => 'Surabaya',
            'duration' => 'Full-time',
            'jurusan' => 'RPL',
            'kuota' => 2,
            'metode_kerja' => 'On-site',
            'deskripsi' => 'Deskripsi singkat.',
            'batas_pendaftaran' => now()->addDays(10)->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.lowongan.index'));
        $this->assertDatabaseHas('lowongans', [
            'company_name' => 'PT Tanpa Dokumen',
            'title' => 'Posisi Tanpa Dokumen',
        ]);
    }
```

- [x] **Step 2: Jalankan test (kondisi awal)**

Run: `php artisan test tests/Feature/Admin/Bkk/LowonganCrudTest.php`
Expected: test baru kemungkinan PASS di SQLite (bug utama di MySQL) — test ini adalah regression guard; kepastian bug sudah dibuktikan via tinker di MySQL.

- [x] **Step 3: Buat migrasi nullable**

Buat `database/migrations/2026_10_02_300001_make_lowongan_json_columns_nullable.php`:

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
            $table->json('tanggung_jawab')->nullable()->change();
            $table->json('kualifikasi')->nullable()->change();
            $table->json('dokumen')->nullable()->change();
            $table->json('benefits')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Tidak dikembalikan ke NOT NULL karena data lama bisa berisi NULL.
    }
};
```

- [x] **Step 4: Set `dokumen` default di controller**

Di `app/Http/Controllers/Admin/Bkk/LowonganController.php`, ganti method `prepareData` menjadi:

```php
    protected function prepareData(Request $request): array
    {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug($data['title']);

        $data['tanggung_jawab'] = $this->parseMultiline($data['tanggung_jawab'] ?? null);
        $data['kualifikasi'] = $this->parseMultiline($data['kualifikasi'] ?? null);
        $data['benefits'] = $this->parseMultiline($data['benefits'] ?? null);
        $data['dokumen'] = $data['dokumen'] ?? [];

        $data['is_published'] = $request->boolean('is_published');

        return $data;
    }
```

- [x] **Step 5: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Bkk/LowonganCrudTest.php`
Expected: semua PASS.

- [x] **Step 6: Migrasi DB dev (dengan konfirmasi user)**

Run: `php artisan migrate`
Expected: `2026_10_02_300001_make_lowongan_json_columns_nullable ... DONE`

- [x] **Step 7: Commit**

```bash
git add database/migrations/2026_10_02_300001_make_lowongan_json_columns_nullable.php app/Http/Controllers/Admin/Bkk/LowonganController.php tests/Feature/Admin/Bkk/LowonganCrudTest.php
git commit -m "fix: make lowongan json columns nullable so store never fails on missing dokumen"
```

---

### Task 2: Fix webinar — start_time pakai input time (Error #4)

Form mengirim teks bebas `"09:00 - 11:30 WIB"` ke kolom TIME → `SQLSTATE[22007]` (terbukti via tinker). Keputusan user: `<input type="time">`. View publik `pusat-karir.blade.php:824` sudah render `substr($upcomingWebinar->start_time, 0, 5)` → kompatibel dengan nilai `HH:MM:SS`.

**Files:**
- Modify: `resources/views/admin/humas/webinar/create.blade.php` (baris 60-68)
- Modify: `resources/views/admin/humas/webinar/edit.blade.php` (baris 59-67)
- Modify: `app/Http/Requests/Admin/Humas/StoreWebinarRequest.php` (baris 24)
- Modify: `app/Http/Requests/Admin/Humas/UpdateWebinarRequest.php` (baris 27)
- Modify: `resources/views/admin/humas/webinar/index.blade.php` (baris 67)
- Test: `tests/Feature/Admin/Humas/WebinarCrudTest.php`

- [x] **Step 1: Perbarui nilai start_time di test existing**

Di `tests/Feature/Admin/Humas/WebinarCrudTest.php` ganti:
- `test_can_create_webinar`: `'start_time' => '09:00 WIB'` → `'start_time' => '09:00'`
- `test_can_update_webinar`: `'start_time' => '13:00 WIB'` → `'start_time' => '13:00'`
- `test_can_toggle_publish`: `'start_time' => '09:00 WIB'` → `'start_time' => '09:00'`
- `test_can_delete_webinar`: `'start_time' => '10:00 WIB'` → `'start_time' => '10:00'`

- [x] **Step 2: Tambah test validasi ditolak**

Tambahkan method di `WebinarCrudTest`:

```php
    public function test_rejects_non_time_start_time(): void
    {
        $response = $this->actingAs($this->humas)->post(route('admin.webinar.store'), [
            'title' => 'Webinar Validasi Waktu',
            'description' => 'Deskripsi',
            'speaker' => 'Pembicara',
            'platform' => 'Zoom',
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'start_time' => '09:00 - 11:30 WIB',
            'registration_url' => 'https://example.com/reg',
        ]);

        $response->assertSessionHasErrors('start_time');
    }
```

Run: `php artisan test tests/Feature/Admin/Humas/WebinarCrudTest.php`
Expected: `test_rejects_non_time_start_time` GAGAL (rule lama `string|max:50` menerima teks itu).

- [x] **Step 3: Perketat rule start_time**

`app/Http/Requests/Admin/Humas/StoreWebinarRequest.php` — ganti baris `'start_time' => ['required', 'string', 'max:50'],` menjadi:

```php
            'start_time' => ['required', 'date_format:H:i'],
```

Lakukan hal sama di `app/Http/Requests/Admin/Humas/UpdateWebinarRequest.php`.

- [x] **Step 4: Ganti input create & edit ke type=time**

`resources/views/admin/humas/webinar/create.blade.php` — ganti blok "Waktu Pelaksanaan" (baris 60-68) menjadi:

```blade
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Pelaksanaan *</label>
                        <input type="time" name="start_time" value="{{ old('start_time', '09:00') }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('start_time') border-red-500 @enderror">
                        <p class="mt-1 text-[11px] text-slate-400">Jam mulai webinar (WIB).</p>
                        @error('start_time')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
```

`resources/views/admin/humas/webinar/edit.blade.php` — ganti blok setara (baris 59-67) menjadi:

```blade
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Waktu Pelaksanaan *</label>
                        <input type="time" name="start_time" value="{{ old('start_time', $webinar->start_time ? substr($webinar->start_time, 0, 5) : '09:00') }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-xs focus:border-blue-500 focus:outline-hidden @error('start_time') border-red-500 @enderror">
                        <p class="mt-1 text-[11px] text-slate-400">Jam mulai webinar (WIB).</p>
                        @error('start_time')
                            <p class="mt-1 text-[11px] text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
```

- [x] **Step 5: Rapikan tampilan jam di index admin**

`resources/views/admin/humas/webinar/index.blade.php` baris 67 — ganti `{{ $item->start_time }}` menjadi `{{ substr($item->start_time, 0, 5) }} WIB`:

```blade
<p class="font-medium text-slate-800">{{ $item->start_date ? $item->start_date->format('d M Y') : '-' }} • {{ substr($item->start_time, 0, 5) }} WIB</p>
```

- [x] **Step 6: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Humas/WebinarCrudTest.php`
Expected: semua PASS termasuk `test_rejects_non_time_start_time`.

- [x] **Step 7: Verifikasi manual via tinker**

```bash
php artisan tinker --execute="$w = new \App\Models\Webinar(); $w->title='T'; $w->slug='t-'.\Illuminate\Support\Str::random(5); $w->description='d'; $w->speaker='s'; $w->platform='Zoom'; $w->start_date='2026-12-01'; $w->start_time='09:00'; $w->registration_url='https://x.com'; $w->is_published=false; $w->save(); echo 'OK id='.$w->id; $w->delete();"
```
Expected: `OK id=...` tanpa QueryException.

- [x] **Step 8: Commit**

```bash
git add resources/views/admin/humas/webinar/ app/Http/Requests/Admin/Humas/StoreWebinarRequest.php app/Http/Requests/Admin/Humas/UpdateWebinarRequest.php tests/Feature/Admin/Humas/WebinarCrudTest.php
git commit -m "fix: webinar start_time uses H:i time input and validation so save succeeds"
```

---

### Task 3: Verifikasi SPMB — wajib catatan saat ditolak + tampilkan ke siswa (Error #7)

Dua bagian: (a) validasi `required_if status_verifikasi=ditolak` di admin; (b) halaman `spmb.dashboard.verifikasi` kini menampilkan badge status + catatan panitia (sebelumnya status/catatan tidak tampil sama sekali).

**Files:**
- Modify: `app/Http/Controllers/Admin/Spmb/CalonSiswaController.php` (method `updateVerifikasi`, baris 85-96)
- Modify: `resources/views/admin/spmb/calon-siswa/show.blade.php` (blok form verifikasi, baris 114-127)
- Modify: `resources/views/spmb/dashboard/verifikasi.blade.php` (sisip kartu status di atas)
- Test: `tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php`

- [x] **Step 1: Tulis test catatan wajib**

Tambahkan di `tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php` (file sudah memakai `$this->spmbUser` dari `setUp()`; `CalonSiswa` tidak punya factory — buat via `create()` dengan kolom wajib `nisn`, `nama_lengkap`, `asal_sekolah`):

```php
    public function test_reject_status_requires_catatan(): void
    {
        $siswa = CalonSiswa::create([
            'nisn' => '3333333333',
            'nama_lengkap' => 'Calon Siswa Verifikasi',
            'asal_sekolah' => 'SMPN 3 Surabaya',
            'status_verifikasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->spmbUser)
            ->patch(route('admin.calon-siswa.update-verifikasi', $siswa), [
                'status_verifikasi' => 'ditolak',
                'catatan_verifikasi' => null,
            ]);

        $response->assertSessionHasErrors('catatan_verifikasi');

        $response2 = $this->actingAs($this->spmbUser)
            ->patch(route('admin.calon-siswa.update-verifikasi', $siswa), [
                'status_verifikasi' => 'ditolak',
                'catatan_verifikasi' => 'Scan KK buram, mohon unggah ulang.',
            ]);

        $response2->assertSessionHasNoErrors();
        $this->assertDatabaseHas('calon_siswas', [
            'id' => $siswa->id,
            'status_verifikasi' => 'ditolak',
            'catatan_verifikasi' => 'Scan KK buram, mohon unggah ulang.',
        ]);
    }
```

Run: `php artisan test tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php`
Expected: test baru GAGAL (validasi masih nullable).

- [x] **Step 2: Validasi required_if di controller**

`app/Http/Controllers/Admin/Spmb/CalonSiswaController.php` — ganti isi `updateVerifikasi` menjadi:

```php
    public function updateVerifikasi(Request $request, CalonSiswa $calonSiswa): RedirectResponse
    {
        $validated = $request->validate([
            'status_verifikasi' => 'required|in:menunggu,terverifikasi,ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,ditolak|nullable|string|max:1000',
        ], [
            'catatan_verifikasi.required_if' => 'Catatan wajib diisi saat menolak berkas agar calon siswa tahu apa yang perlu diperbaiki.',
        ]);

        $calonSiswa->update($validated);

        return redirect()->route('admin.calon-siswa.show', $calonSiswa)
            ->with('success', 'Status verifikasi berkas berhasil diperbarui.');
    }
```

- [x] **Step 3: Tandai catatan wajib di form admin**

`resources/views/admin/spmb/calon-siswa/show.blade.php` baris 123-127 — ganti blok catatan menjadi:

```blade
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Catatan Panitia <span class="text-red-500">(wajib jika status "Ditolak")</span>
                        </label>
                        <textarea name="catatan_verifikasi" rows="4" maxlength="1000" placeholder="Misal: Scan Kartu Keluarga buram, harap perbarui..."
                            class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('catatan_verifikasi') border-red-500 @enderror">{{ old('catatan_verifikasi', $calonSiswa->catatan_verifikasi) }}</textarea>
                        @error('catatan_verifikasi')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
```

- [x] **Step 4: Tampilkan status & catatan ke calon siswa**

`resources/views/spmb/dashboard/verifikasi.blade.php` — sisipkan kartu berikut sebagai elemen **pertama** di dalam `<div class="max-w-4xl flex flex-col gap-6">` (sebelum kartu "Data Biodata"):

```blade
        <div class="dash-card">
            <p class="text-xs font-bold tracking-wide text-slate-500 uppercase mb-3">Status Verifikasi Berkas</p>

            @php
                $status = $calonSiswa->status_verifikasi ?? 'menunggu';
                $statusLabels = [
                    'menunggu' => ['Menunggu Verifikasi', 'bg-amber-100 text-amber-800'],
                    'terverifikasi' => ['Terverifikasi — Lengkap & Valid', 'bg-emerald-100 text-emerald-800'],
                    'ditolak' => ['Ditolak — Perlu Perbaikan', 'bg-red-100 text-red-800'],
                ];
                [$statusLabel, $statusClass] = $statusLabels[$status] ?? $statusLabels['menunggu'];
            @endphp

            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $statusClass }}">
                {{ $statusLabel }}
            </span>

            @if ($status === 'ditolak')
                @if ($calonSiswa->catatan_verifikasi)
                    <div class="mt-3 rounded-lg bg-red-50 border border-red-200 p-3">
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wide mb-1">Catatan Panitia</p>
                        <p class="text-sm font-medium text-red-800 whitespace-pre-line">{{ $calonSiswa->catatan_verifikasi }}</p>
                    </div>
                @else
                    <p class="mt-3 text-xs font-medium text-red-600">
                        Hubungi panitia untuk keterangan lebih lanjut.
                    </p>
                @endif
            @elseif ($status === 'terverifikasi')
                <p class="mt-3 text-xs font-medium text-emerald-700">
                    Selamat! Berkas Anda telah dinyatakan lengkap dan valid.
                </p>
            @else
                <p class="mt-3 text-xs font-medium text-slate-500">
                    Berkas Anda sedang dalam proses pemeriksaan panitia.
                </p>
            @endif
        </div>
```

- [x] **Step 5: Jalankan test**

Run: `php artisan test tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php`
Expected: semua PASS.

- [x] **Step 6: Commit**

```bash
git add app/Http/Controllers/Admin/Spmb/CalonSiswaController.php resources/views/admin/spmb/calon-siswa/show.blade.php resources/views/spmb/dashboard/verifikasi.blade.php tests/Feature/Admin/Spmb/CalonSiswaAdminTest.php
git commit -m "feat: require verification note when rejecting and show status to applicant"
```

---

### Task 4: Mitra DUDI — error validasi informatif di semua field (Error #9)

Hanya field `name` yang punya `@error` di `admin/bkk/mitra/create.blade.php` — 15+ field lain tak menampilkan pesan & tak ada highlight merah. Fix: pesan Indonesia di Store/UpdateMitraRequest + `@error` di semua field create & edit.

**Files:**
- Modify: `app/Http/Requests/Admin/Bkk/StoreMitraRequest.php`
- Modify: `app/Http/Requests/Admin/Bkk/UpdateMitraRequest.php`
- Modify: `resources/views/admin/bkk/mitra/create.blade.php`
- Modify: `resources/views/admin/bkk/mitra/edit.blade.php`
- Test: `tests/Feature/Admin/Bkk/MitraCrudTest.php`

- [x] **Step 1: Tulis test pesan error Indonesia**

Tambahkan di `tests/Feature/Admin/Bkk/MitraCrudTest.php`:

```php
    public function test_store_with_invalid_data_shows_field_errors(): void
    {
        $bkk = \App\Models\User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->post(route('admin.mitra.store'), [
            'name' => 'PT Uji Validasi',
            'short_name' => str_repeat('X', 60),
            'sector' => str_repeat('Y', 150),
            'city' => 'Surabaya',
            'website' => 'bukan-url-valid',
            'kemitraan_sejak' => 1900,
        ]);

        $response->assertSessionHasErrors(['short_name', 'sector', 'website', 'kemitraan_sejak']);

        $response = $this->actingAs($bkk)->get(route('admin.mitra.create'));
        $response->assertSee('URL tidak valid');
    }
```

Run: `php artisan test tests/Feature/Admin/Bkk/MitraCrudTest.php`
Expected: test baru GAGAL (pesan custom belum ada).

- [x] **Step 2: Tambah messages() di kedua Request**

`app/Http/Requests/Admin/Bkk/StoreMitraRequest.php` — tambahkan setelah `rules()`:

```php
    public function messages(): array
    {
        return [
            'name.required' => 'Nama perusahaan wajib diisi.',
            'name.max' => 'Nama perusahaan maksimal 255 karakter.',
            'short_name.required' => 'Nama singkat wajib diisi.',
            'short_name.max' => 'Nama singkat maksimal 50 karakter.',
            'sector.required' => 'Sektor industri wajib diisi.',
            'sector.max' => 'Sektor industri maksimal 100 karakter.',
            'city.required' => 'Kota wajib diisi.',
            'city.max' => 'Kota maksimal 100 karakter.',
            'website.url' => 'URL tidak valid — gunakan format https://contoh.com',
            'website.max' => 'URL website maksimal 255 karakter.',
            'logo_color.max' => 'Warna logo maksimal 20 karakter.',
            'logo_text.max' => 'Teks logo maksimal 10 karakter.',
            'mou_until.date' => 'Tanggal berlaku MoU tidak valid.',
            'kemitraan_sejak.integer' => 'Tahun kemitraan harus berupa angka.',
            'kemitraan_sejak.min' => 'Tahun kemitraan minimal 1950.',
            'kemitraan_sejak.max' => 'Tahun kemitraan maksimal tahun depan.',
            'narahubung_nama.max' => 'Nama narahubung maksimal 255 karakter.',
            'narahubung_jabatan.max' => 'Jabatan narahubung maksimal 100 karakter.',
            'narahubung_wa.max' => 'Nomor WhatsApp narahubung maksimal 30 karakter.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Format logo harus PNG, JPG, atau WEBP.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ];
    }
```

`app/Http/Requests/Admin/Bkk/UpdateMitraRequest.php` — salin method `messages()` yang sama persis.

- [x] **Step 3: @error + highlight di create.blade.php**

Di `resources/views/admin/bkk/mitra/create.blade.php`, untuk SETIAP field kecuali `name` (sudah ada): (1) sisipkan `@error('FIELD') border-red-500 @enderror` di akhir atribut class input; (2) tambahkan pesan di bawah input. Contoh hasil untuk `short_name`:

```blade
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Nama Singkat *</label>
                    <input type="text" name="short_name" value="{{ old('short_name') }}" required maxlength="50"
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none @error('short_name') border-red-500 @enderror">
                    @error('short_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
```

Terapkan pola identik (beserta `maxlength` sesuai rule: sector/city 100, website 255, logo_color 20, logo_text 10, mou_until date, kemitraan_sejak number min 1950, narahubung_nama 255, narahubung_jabatan 100, narahubung_wa 30) untuk: `sector`, `city`, `website`, `description`, `address`, `mou_until`, `kemitraan_sejak`, `programs`, `narahubung_nama`, `narahubung_jabatan`, `narahubung_wa`, dan pesan `logo` di bawah input file. Select `is_mou_active` cukup pesan tanpa border.

- [x] **Step 4: Sinkronkan edit.blade.php**

Terapkan perubahan sama di `resources/views/admin/bkk/mitra/edit.blade.php` (value memakai `old('x', $mitra->x)` yang sudah ada). Daftar `@error` dan `maxlength` harus sama persis dengan create.

- [x] **Step 5: Jalankan test mitra**

Run: `php artisan test tests/Feature/Admin/Bkk/MitraCrudTest.php`
Expected: semua PASS termasuk test baru.

- [x] **Step 6: Commit**

```bash
git add app/Http/Requests/Admin/Bkk/StoreMitraRequest.php app/Http/Requests/Admin/Bkk/UpdateMitraRequest.php resources/views/admin/bkk/mitra/
git commit -m "feat: per-field Indonesian validation messages and error highlighting for mitra DUDI forms"
```

---

### Task 5: Lowongan — hapus field durasi_pelaksanaan (Error #10)

Form punya `duration` dan `durasi_pelaksanaan` yang membingungkan; view publik hanya memakai `duration`. Keputusan user: hapus `durasi_pelaksanaan` dari alur input. Kolom DB dibiarkan (nullable) agar data lama aman.

**Files:**
- Create: `database/migrations/2026_10_02_300002_make_durasi_pelaksanaan_nullable.php`
- Modify: `app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php` (hapus baris 32)
- Modify: `app/Http/Requests/Admin/Bkk/UpdateLowonganRequest.php` (hapus baris 32)
- Modify: `app/Models/Lowongan.php` (hapus `'durasi_pelaksanaan',` dari `$fillable`, baris 31)
- Modify: `resources/views/admin/bkk/lowongan/create.blade.php` (hapus blok baris 95-99; perjelas label baris 86)
- Modify: `resources/views/admin/bkk/lowongan/edit.blade.php` (blok setara ~baris 95-104)
- Modify: `database/factories/LowonganFactory.php` (hapus baris 38)
- Modify: `database/seeders/LowonganSeeder.php` (hapus 8 baris: 51, 99, 146, 193, 247, 300, 352, 405)
- Test: `tests/Feature/Admin/Bkk/LowonganCrudTest.php`

- [x] **Step 1: Test memastikan field hilang dari form**

Di `tests/Feature/Admin/Bkk/LowonganCrudTest.php`: (1) hapus baris `'durasi_pelaksanaan' => '6 Bulan',` dari `test_bkk_user_can_create_lowongan_with_auto_slug_and_logo`; (2) tambahkan:

```php
    public function test_create_form_has_no_durasi_pelaksanaan_field(): void
    {
        $bkk = User::factory()->bkk()->create();

        $response = $this->actingAs($bkk)->get(route('admin.lowongan.create'));

        $response->assertOk();
        $response->assertDontSee('name="durasi_pelaksanaan"', false);
        $response->assertSee('name="duration"', false);
    }
```

Run: `php artisan test tests/Feature/Admin/Bkk/LowonganCrudTest.php`
Expected: test baru GAGAL (form masih punya field).

- [x] **Step 2: Migrasi nullable**

Buat `database/migrations/2026_10_02_300002_make_durasi_pelaksanaan_nullable.php`:

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
            $table->string('durasi_pelaksanaan')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Data lama bisa berisi NULL; pengembalian ke NOT NULL memerlukan backfill.
    }
};
```

- [x] **Step 3: Hapus rule dari kedua Request**

Di `app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php` dan `UpdateLowonganRequest.php` hapus baris:

```php
            'durasi_pelaksanaan' => ['required', 'string', 'max:100'],
```

- [x] **Step 4: Hapus dari fillable model**

Di `app/Models/Lowongan.php` hapus baris `'durasi_pelaksanaan',` dari `$fillable`.

- [x] **Step 5: Hapus field dari form create & edit**

`resources/views/admin/bkk/lowongan/create.blade.php` — hapus blok (baris 95-99):

```blade
                <div>
                    <label class="mb-1 block text-xs font-bold text-slate-600">Durasi Pelaksanaan *</label>
                    <input type="text" name="durasi_pelaksanaan" value="{{ old('durasi_pelaksanaan') }}" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>
```

dan ganti label `duration` (baris 86) menjadi:

```blade
                    <label class="mb-1 block text-xs font-bold text-slate-600">Durasi Magang/Kerja * <span class="font-normal text-slate-400">(mis. 6 Bulan (Jan–Jun))</span></label>
```

Terapkan kedua perubahan yang sama di `resources/views/admin/bkk/lowongan/edit.blade.php` (blok dengan value `old('durasi_pelaksanaan', $lowongan->durasi_pelaksanaan)`).

- [x] **Step 6: Bersihkan factory & seeder**

- `database/factories/LowonganFactory.php` — hapus baris 38: `'durasi_pelaksanaan' => '6 Bulan',`
- `database/seeders/LowonganSeeder.php` — hapus 8 baris `'durasi_pelaksanaan' => ...` (baris 51, 99, 146, 193, 247, 300, 352, 405).

- [x] **Step 7: Jalankan test BKK**

Run: `php artisan test tests/Feature/Admin/Bkk`
Expected: semua PASS.

- [x] **Step 8: Migrasi (dengan konfirmasi user) & commit**

Run: `php artisan migrate`
Expected: migrasi baru DONE.

```bash
git add database/migrations/2026_10_02_300002_make_durasi_pelaksanaan_nullable.php app/Http/Requests/Admin/Bkk/StoreLowonganRequest.php app/Http/Requests/Admin/Bkk/UpdateLowonganRequest.php app/Models/Lowongan.php resources/views/admin/bkk/lowongan/ database/factories/LowonganFactory.php database/seeders/LowonganSeeder.php tests/Feature/Admin/Bkk/LowonganCrudTest.php
git commit -m "refactor: remove confusing durasi_pelaksanaan input; single duration field"
```

### Task 6: Chip nama user di topbar admin (Error #12)

`admin/layout.blade.php:242-247` me-render `{{ auth()->user()->name }}` di `.adm-userchip` **tanpa batas lebar** — nama panjang mendorong tombol "Keluar" keluar layar sehingga user tidak bisa logout (dilaporkan: "nggak bisa login apapun lagi"). Fix: batasi lebar + `truncate`. Sekalian batasi panjang nama user saat dibuat (`max:100`).

**Files:**
- Modify: `resources/views/admin/layout.blade.php` (baris 242-247)
- Modify: `app/Http/Requests/Admin/StoreUserRequest.php` (rule `name`)
- Modify: `app/Http/Requests/Admin/UpdateUserRequest.php` (rule `name`)
- Test: `tests/Feature/Admin/UserCrudTest.php`

- [x] **Step 1: Test batas nama user**

Tambahkan di `tests/Feature/Admin/UserCrudTest.php`:

```php
    public function test_user_name_has_max_length(): void
    {
        $admin = \App\Models\User::factory()->create(['role' => \App\Models\User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.users.store'), [
            'name' => str_repeat('N', 120),
            'email' => 'namapnjg@example.com',
            'password' => 'password123',
            'role' => 'bkk',
        ]);

        $response->assertSessionHasErrors('name');
    }
```

Run: `php artisan test tests/Feature/Admin/UserCrudTest.php`
Expected: test baru GAGAL (rule masih `max:255`).

- [x] **Step 2: Perketat rule nama user**

`app/Http/Requests/Admin/StoreUserRequest.php` — ganti rule `name` menjadi:

```php
            'name' => 'required|string|max:100',
```

Cek `app/Http/Requests/Admin/UpdateUserRequest.php` dan ganti rule `name` menjadi `'required|string|max:100'` (pertahankan clause `unique:users,email` yang ada pada rule email-nya; jangan ubah rule lain).

- [x] **Step 3: Truncate chip user di layout admin**

`resources/views/admin/layout.blade.php` baris 241-247 — ganti blok userchip menjadi:

```blade
            <div class="flex items-center gap-3 min-w-0">
                <span class="adm-userchip min-w-0">
                    <span class="max-w-[10rem] truncate">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-semibold text-blue-200 shrink-0">
                        ({{ auth()->user()->roleLabel() }})
                    </span>
                </span>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-red-600 transition shrink-0">
                        <x-lucide-log-out class="w-4 h-4" />
                        Keluar
                    </button>
                </form>
            </div>
```

Catatan: `min-w-0` pada parent + `truncate` pada nama memastikan nama panjang dipotong dengan ellipsis, tombol "Keluar" selalu terlihat.

- [x] **Step 4: Jalankan test users**

Run: `php artisan test tests/Feature/Admin/UserCrudTest.php`
Expected: semua PASS termasuk test baru.

- [x] **Step 5: Commit**

```bash
git add resources/views/admin/layout.blade.php app/Http/Requests/Admin/StoreUserRequest.php app/Http/Requests/Admin/UpdateUserRequest.php tests/Feature/Admin/UserCrudTest.php
git commit -m "fix: truncate long user name chip so logout stays reachable"
```

---

### Task 7: Bimbingan karir & tracer study — limit input + clamp teks (Error #2)

Halaman index admin sudah paginate (12/15). Isu: (a) input tanpa batas karakter pada create/edit; (b) teks panjang tanpa clamp. Di tracer, kolom nama/jurusan tanpa clamp; di bimbingan, `external_url` sudah `Str::limit(30)` (aman) tapi form masih tanpa maxlength.

**Files:**
- Modify: `resources/views/admin/bkk/bimbingan/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/bkk/tracer/alumni/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/bkk/tracer/index.blade.php` (clamp nama/jurusan)
- Test: `tests/Feature/Admin/Bkk/BimbinganCrudTest.php`

- [x] **Step 1: Tambah maxlength di form bimbingan**

Pada `resources/views/admin/bkk/bimbingan/create.blade.php` dan `edit.blade.php`:
- Input `title`: tambah `maxlength="255"`
- Input `external_url`: tambah `maxlength="255"`
- Textarea `description`: tambah `maxlength="2000"`

Contoh input title:

```blade
<input type="text" name="title" value="{{ old('title') }}" required maxlength="255" ...>
```

- [x] **Step 2: Tambah maxlength di form alumni tracer**

Pada `resources/views/admin/bkk/tracer/alumni/create.blade.php` dan `edit.blade.php`:
- Input `nisn`: tambah `maxlength="10"`
- Input `nama`: tambah `maxlength="255"`
- Input `jurusan`: tambah `maxlength="255"`
- Input `tahun_lulus`: tetap `type="number"` (tidak perlu maxlength)
- Input `angkatan`: tetap `type="number"`

- [x] **Step 3: Clamp kolom tabel tracer**

`resources/views/admin/bkk/tracer/index.blade.php` baris 77-79 — bungkus kolom nama & jurusan dengan truncate:

```blade
                                    <td class="px-5 py-3 font-mono font-bold text-slate-900">{{ $al->nisn }}</td>
                                    <td class="px-5 py-3 font-semibold text-slate-800 max-w-[12rem] truncate" title="{{ $al->nama }}">{{ $al->nama }}</td>
                                    <td class="px-5 py-3 text-slate-600 max-w-[12rem] truncate" title="{{ $al->jurusan }}">{{ $al->jurusan }}</td>
```

- [x] **Step 4: Jalankan test BKK**

Run: `php artisan test tests/Feature/Admin/Bkk`
Expected: semua PASS (perubahan hanya atribut HTML, tidak mengubah data).

- [x] **Step 5: Commit**

```bash
git add resources/views/admin/bkk/bimbingan/ resources/views/admin/bkk/tracer/
git commit -m "fix: limit character input and clamp long text in bimbingan and tracer tables"
```

---

### Task 8: Humas — artikel, guru/tendik, struktur organisasi, fasilitas (Error #3 & #5)

Semua index-nya sudah paginate 12-15; isu sama: maxlength di form + clamp di kolom tabel yang panjang.

**Files:**
- Modify: `resources/views/admin/humas/artikel/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/humas/guru/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/humas/struktur/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/humas/fasilitas/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/humas/artikel/index.blade.php` (clamp judul)
- Modify: `resources/views/admin/humas/guru/index.blade.php` (clamp nama/jabatan/mapel)
- Modify: `resources/views/admin/humas/struktur/index.blade.php` (clamp bidang/deskripsi)
- Modify: `resources/views/admin/humas/fasilitas/index.blade.php` (clamp deskripsi)

- [x] **Step 1: maxlength form humas**

Terapkan pada create & edit masing-masing modul:
- `artikel`: input `title` maxlength 255, input `kategori` maxlength 100, textarea `excerpt` maxlength 500, textarea `content` maxlength 50000, input `image_url` maxlength 500, input `reading_time` maxlength 50.
- `guru`: input `nama` maxlength 255, input `jabatan` maxlength 255, input `mapel` maxlength 255.
- `struktur`: input `nama` maxlength 255, input `jabatan` maxlength 255, input `nip` maxlength 100, input `bidang` maxlength 255, textarea `deskripsi` maxlength 2000.
- `fasilitas`: input `nama` maxlength 255, textarea `deskripsi` maxlength 2000, input `jumlah` maxlength 100.

Contoh (guru, create): input nama menjadi:

```blade
<input type="text" name="nama" value="{{ old('nama') }}" required maxlength="255" ...>
```

- [x] **Step 2: Clamp kolom tabel**

`resources/views/admin/humas/artikel/index.blade.php` baris 65-68 — bungkus judul dengan truncate:

```blade
                                    <div class="max-w-md min-w-0">
                                        <p class="font-extrabold text-slate-900 truncate" title="{{ $item->title }}">{{ $item->title }}</p>
                                        <p class="text-[11px] text-slate-400 font-mono truncate">/pusat-karir/artikel/{{ $item->slug }}</p>
                                    </div>
```

`resources/views/admin/humas/guru/index.blade.php` baris 75-77 — clamp nama:

```blade
                                    <div class="min-w-0 max-w-[14rem]">
                                        <p class="font-extrabold text-slate-900 truncate" title="{{ $item->nama }}">{{ $item->nama }}</p>
                                    </div>
```

dan kolom jabatan/mapel (baris 80-85) menjadi:

```blade
                            <td class="px-4 py-3 max-w-[12rem]">
                                <p class="font-medium text-slate-900 truncate" title="{{ $item->jabatan }}">{{ $item->jabatan }}</p>
                                @if ($item->mapel)
                                    <p class="text-[11px] text-slate-500 truncate" title="{{ $item->mapel }}">{{ $item->mapel }}</p>
                                @endif
                            </td>
```

`resources/views/admin/humas/struktur/index.blade.php` baris 51-58 (bidang) dan 109-111 (deskripsi bagian) — tambahkan `max-w-*` + `truncate` + `title`:

```blade
                                <span class="inline-flex max-w-[12rem] rounded-full bg-blue-50 px-2 py-0.5 text-[10px] font-bold text-blue-700 border border-blue-100">
                                    <span class="truncate" title="{{ $item->bidang }}">{{ $item->bidang ?: '-' }}</span>
                                </span>
```

dan:

```blade
                            <td class="px-4 py-3 text-slate-600 max-w-md">
                                <p class="truncate" title="{{ $item->deskripsi }}">{{ $item->deskripsi ?: '-' }}</p>
                            </td>
```

`resources/views/admin/humas/fasilitas/index.blade.php` baris 82-84 — kolom deskripsi menjadi:

```blade
                            <td class="px-4 py-3 text-slate-500 max-w-sm">
                                <p class="truncate" title="{{ $item->deskripsi }}">{{ $item->deskripsi }}</p>
                            </td>
```

- [x] **Step 3: Jalankan test humas**

Run: `php artisan test tests/Feature/Admin/Humas`
Expected: semua PASS.

- [x] **Step 4: Commit**

```bash
git add resources/views/admin/humas/
git commit -m "fix: limit character input and clamp long text in humas admin tables"
```

---

### Task 9: Dashboard admin — judul artikel keluar kotak (Error #6)

Widget "Artikel Terbaru" (`admin/dashboard.blade.php:88-95`) merender judul penuh tanpa clamp. Controller sudah `limit(5)` — yang perlu hanya CSS.

**Files:**
- Modify: `resources/views/admin/dashboard.blade.php` (baris 70-95)

- [x] **Step 1: Clamp judul pada ketiga widget**

Ganti blok list lowongan/artikel/calon siswa (baris 69-116) sehingga setiap judul punya `truncate`. Contoh untuk artikel (baris 87-95):

```blade
                    @foreach ($recentArticles as $artikel)
                        <li class="py-3 first:pt-0 last:pb-0">
                            <p class="text-sm font-bold text-slate-900 truncate" title="{{ $artikel->title }}">{{ $artikel->title }}</p>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">
                                {{ $artikel->kategori }} · {{ $artikel->published_at?->format('d M Y') }}
                            </p>
                        </li>
                    @endforeach
```

Lakukan pola sama pada `$lowongan->title` (baris 72) dan `$calonSiswa->nama_lengkap` (baris 108): tambahkan class `truncate` dan atribut `title="{{ ... }}"` pada elemen `<p>` judulnya. Kolom nama calon siswa juga tambahkan `truncate` pada `<p>` jurusan (baris 110) bila perlu.

- [x] **Step 2: Jalankan test dashboard**

Run: `php artisan test tests/Feature/Admin/DashboardTest.php`
Expected: semua PASS.

- [x] **Step 3: Commit**

```bash
git add resources/views/admin/dashboard.blade.php
git commit -m "fix: clamp long titles in admin dashboard widgets"
```

---

### Task 10: SPMB admin — pengumuman & FAQ (Error #8)

Index sudah paginate; kolom `judul`/`pertanyaan` belum di-clamp; form belum ada maxlength; textarea `konten`/`jawaban` tak berbatas.

**Files:**
- Modify: `resources/views/admin/spmb/pengumuman/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/spmb/faq/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/spmb/pengumuman/index.blade.php` (clamp judul, baris 42)
- Modify: `resources/views/admin/spmb/faq/index.blade.php` (clamp pertanyaan, baris 46)

- [x] **Step 1: maxlength form SPMB**

- `pengumuman/create|edit`: input `judul` maxlength 255; textarea `konten` maxlength 5000.
- `faq/create|edit`: input `pertanyaan` maxlength 255; textarea `jawaban` maxlength 5000; input `kategori` maxlength 100.

Contoh (pengumuman):

```blade
<input type="text" name="judul" value="{{ old('judul') }}" required maxlength="255" ...>
<textarea name="konten" rows="6" maxlength="5000" ...>{{ old('konten') }}</textarea>
```

- [x] **Step 2: Clamp kolom judul/pertanyaan**

`resources/views/admin/spmb/pengumuman/index.blade.php` baris 41-44 — bungkus judul:

```blade
                        <td class="px-4 py-3 max-w-sm">
                            <p class="font-bold text-slate-900 truncate" title="{{ $item->judul }}">{{ $item->judul }}</p>
                            <p class="text-xs text-slate-500 line-clamp-1">{{ Str::limit($item->konten, 90) }}</p>
                        </td>
```

`resources/views/admin/spmb/faq/index.blade.php` baris 45-48 — bungkus pertanyaan:

```blade
                        <td class="px-4 py-3">
                            <p class="font-bold text-slate-900 truncate max-w-sm" title="{{ $item->pertanyaan }}">{{ $item->pertanyaan }}</p>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-0.5">{{ $item->jawaban }}</p>
                        </td>
```

- [x] **Step 3: Jalankan test SPMB**

Run: `php artisan test tests/Feature/Admin/Spmb`
Expected: semua PASS.

- [x] **Step 4: Commit**

```bash
git add resources/views/admin/spmb/
git commit -m "fix: limit character input and clamp long text in spmb pengumuman and faq tables"
```

---

### Task 11: Pengguna sistem — limit & clamp (Error #11)

Index sudah paginate 15; nama/email panjang belum di-clamp; form create/edit belum ada maxlength.

**Files:**
- Modify: `resources/views/admin/users/create.blade.php` + `edit.blade.php` (maxlength)
- Modify: `resources/views/admin/users/index.blade.php` (clamp nama & email, baris 63-71)

- [x] **Step 1: maxlength form users**

Pada `resources/views/admin/users/create.blade.php` dan `edit.blade.php`:
- Input `name`: tambah `maxlength="100"`
- Input `email`: tambah `maxlength="255"`

- [x] **Step 2: Clamp kolom nama & email**

`resources/views/admin/users/index.blade.php` baris 63-71 — ganti menjadi:

```blade
                        <td class="px-4 py-3 max-w-[16rem]">
                            <div class="flex items-center gap-2">
                                <p class="font-bold text-slate-900 truncate" title="{{ $user->name }}">{{ $user->name }}</p>
                                @if ($user->id === auth()->id())
                                    <span class="rounded bg-slate-200 px-1.5 py-0.5 text-[10px] font-bold text-slate-700 shrink-0">Anda</span>
                                @endif
                            </div>
                            <p class="text-xs text-slate-500 truncate" title="{{ $user->email }}">{{ $user->email }}</p>
                        </td>
```

- [x] **Step 3: Jalankan test users**

Run: `php artisan test tests/Feature/Admin/UserCrudTest.php`
Expected: semua PASS.

- [x] **Step 4: Commit**

```bash
git add resources/views/admin/users/
git commit -m "fix: limit and clamp user name and email in users admin"
```

---

### Task 12: Verifikasi penuh (full test suite)

- [x] **Step 1: Jalankan seluruh test**

Run: `php artisan test`
Expected: OK — tidak ada regresi di seluruh suite.

- [x] **Step 2: Jalankan Pint (code style)**

Run: `./vendor/bin/pint --dirty`
Expected: semua file berubah rapi (auto-fixed bila perlu), lalu commit jika ada perubahan:

```bash
git add -A
git commit -m "style: apply pint to changed files"
```

- [x] **Step 3: Migrasi DB dev (setelah konfirmasi user)**

Run: `php artisan migrate`
Expected: dua migrasi baru `2026_10_02_300001_*` dan `2026_10_02_300002_*` DONE.

- [x] **Step 4: Sanity manual singkat**

Buka di browser (laragon): `/admin/lowongan/create` — field "Durasi Pelaksanaan" hilang; simpan lowongan tanpa field opsional → sukses. `/admin/webinar/create` — input waktu type=time; simpan → sukses. `/admin/spmb/calon-siswa/{id}` — tolak tanpa catatan → error inline. `/admin` — nama user panjang terpotong, tombol Keluar terlihat.

- [x] **Step 5: Update error-list (tandai selesai)**

Edit `error-list` di root — tambahkan prefix `[FIXED]` pada tiap baris yang diperbaiki, contoh:

```
1. [FIXED] Tambah lowongan Error waktu simpan (dokumen doesn't have default value)
```

Commit:

```bash
git add error-list
git commit -m "docs: mark error-list items as fixed"
```

