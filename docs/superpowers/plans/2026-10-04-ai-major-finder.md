# AI Major Finder Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Mengubah section "Temukan Jurusanmu" di beranda utama menjadi showcase card interaktif dan membangun fitur baru AI Major Finder kuesioner 15 pertanyaan pada rute `/temukan-jurusan` berbasis probabilitas matriks 9 jurusan SMKN 1 Surabaya dengan analisis personal Google Gemini AI.

**Architecture:** Client-side interactive wizard untuk pengalaman pengisian instan tanpa reload, dipadukan dengan penghitungan skor deterministik matriks 9 jurusan di browser/controller, dan pemanggilan asinkron AJAX ke `POST /temukan-jurusan/analisis` yang menggunakan `GeminiService` (didukung fallback cerdas tanpa kegagalan).

**Tech Stack:** Laravel 13, PHP 8.5, Blade, Tailwind CSS v4, Vanilla JS / Alpine.js, Google Gemini API (`gemini-1.5-flash`), PHPUnit.

---

### Task 1: Routes & MajorFinderController Scaffold with Feature Tests

**Files:**
- Create: `app/Http/Controllers/MajorFinderController.php`
- Modify: `routes/web.php`
- Create: `tests/Feature/MajorFinderTest.php`

- [ ] **Step 1: Write the failing feature test**

Create `tests/Feature/MajorFinderTest.php`:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class MajorFinderTest extends TestCase
{
    public function test_major_finder_page_is_accessible(): void
    {
        $response = $this->get(route('temukan-jurusan'));

        $response->assertStatus(200);
        $response->assertSee('Smeas AI Major Finder');
    }

    public function test_major_finder_analysis_endpoint_validates_payload(): void
    {
        $response = $this->postJson(route('temukan-jurusan.analisis'), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['top_major.name', 'top_major.score']);
    }

    public function test_major_finder_analysis_endpoint_returns_json_response(): void
    {
        $payload = [
            'nama' => 'Ahmad',
            'top_major' => [
                'name' => 'Rekayasa Perangkat Lunak',
                'score' => 94,
            ],
            'alternatives' => [
                ['name' => 'Teknik Komputer dan Jaringan', 'score' => 82],
                ['name' => 'Desain Komunikasi Visual', 'score' => 68],
            ],
            'highlights' => ['coding', 'debugging'],
        ];

        $response = $this->postJson(route('temukan-jurusan.analisis'), $payload);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'analysis',
        ]);
        $this->assertTrue($response->json('success'));
        $this->assertNotEmpty($response->json('analysis'));
    }
}
```

- [ ] **Step 2: Run test to verify it fails**

Run:
```bash
php artisan test --filter=MajorFinderTest
```
Expected: FAIL (route `temukan-jurusan` not defined, Controller missing).

- [ ] **Step 3: Implement Routes & Controller scaffold**

Modify `routes/web.php` (tambahkan rute di bawah rute jurusan):
```php
use App\Http\Controllers\MajorFinderController;

// AI Major Finder Routes
Route::get('/temukan-jurusan', [MajorFinderController::class, 'index'])->name('temukan-jurusan');
Route::post('/temukan-jurusan/analisis', [MajorFinderController::class, 'analisis'])
    ->middleware('throttle:20,1')
    ->name('temukan-jurusan.analisis');
```

Create `app/Http/Controllers/MajorFinderController.php`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MajorFinderController extends Controller
{
    public function index(): View
    {
        $questions = $this->getQuestions();
        $majors = $this->getMajors();

        return view('temukan-jurusan', compact('questions', 'majors'));
    }

    public function analisis(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['nullable', 'string', 'max:50'],
            'top_major' => ['required', 'array'],
            'top_major.name' => ['required', 'string', 'max:100'],
            'top_major.score' => ['required', 'numeric', 'min:0', 'max:100'],
            'alternatives' => ['nullable', 'array'],
            'highlights' => ['nullable', 'array'],
        ]);

        $nama = ! empty($validated['nama']) ? trim($validated['nama']) : 'Sobat SMEAS';
        $topName = $validated['top_major']['name'];
        $topScore = $validated['top_major']['score'];

        $fallbackText = "Halo {$nama}! Berdasarkan analisis minat dan gaya berpikirmu, kamu memiliki potensi luar biasa pada bidang {$topName} dengan tingkat kecocokan mencapai {$topScore}%. Kemampuan logika, ketelitian, dan motivasimu sangat sejalan dengan kurikulum vokasi unggulan di SMKN 1 Surabaya. Jangan ragu untuk memperdalam potensimu dan jadilah profesional muda berprestasi bersama kami!";

        return response()->json([
            'success' => true,
            'analysis' => $fallbackText,
        ]);
    }

    /**
     * @return array<int, array{id: int, text: string, primary: string, secondary: ?string}>
     */
    protected function getQuestions(): array
    {
        return [
            [
                'id' => 1,
                'text' => 'Saya sangat menikmati aktivitas yang melibatkan analisis angka, pencatatan data keuangan, atau audit laporan secara teliti.',
                'primary' => 'akuntansi',
                'secondary' => 'manajemen-perkantoran',
            ],
            [
                'id' => 2,
                'text' => 'Saya suka berinteraksi dengan banyak orang, melakukan tawar-menawar, negosiasi, atau menyusun strategi jualan.',
                'primary' => 'bisnis-daring-dan-pemasaran',
                'secondary' => 'perhotelan',
            ],
            [
                'id' => 3,
                'text' => 'Saya adalah orang yang sangat terorganisir, suka merapikan arsip/dokumen, dan menjaga ketepatan jadwal serta agenda kerja.',
                'primary' => 'manajemen-perkantoran',
                'secondary' => 'manajemen-logistik',
            ],
            [
                'id' => 4,
                'text' => 'Saya tertarik memahami alur rantai pasok, tata kelola barang di gudang, dan efisiensi jalur distribusi logistik.',
                'primary' => 'manajemen-logistik',
                'secondary' => null,
            ],
            [
                'id' => 5,
                'text' => 'Saya sangat antusias dengan dunia coding, menulis baris kode program, dan membangun sebuah aplikasi atau website dari nol.',
                'primary' => 'rekayasa-perangkat-lunak',
                'secondary' => null,
            ],
            [
                'id' => 6,
                'text' => 'Saya penasaran dengan cara kerja perangkat keras komputer, perakitan komponen PC, serta konfigurasi jaringan internet/router.',
                'primary' => 'teknik-komputer-dan-jaringan',
                'secondary' => null,
            ],
            [
                'id' => 7,
                'text' => 'Saya memiliki kepekaan estetika yang tinggi, senang menggambar, membuat ilustrasi digital, atau mendesain konten grafis.',
                'primary' => 'desain-komunikasi-visual',
                'secondary' => null,
            ],
            [
                'id' => 8,
                'text' => 'Saya tertarik bekerja di balik layar produksi video, penyiaran televisi/radio, penyusunan naskah, atau penyutradaraan film pendek.',
                'primary' => 'produksi-siaran-program-pertelevisian',
                'secondary' => null,
            ],
            [
                'id' => 9,
                'text' => 'Saya memiliki kepribadian yang ramah, berpenampilan rapi, sabar, dan senang melayani kenyamanan tamu atau pelanggan secara langsung.',
                'primary' => 'perhotelan',
                'secondary' => 'manajemen-perkantoran',
            ],
            [
                'id' => 10,
                'text' => 'Saya lebih menyukai tugas yang menuntut akurasi perhitungan tinggi, kepatuhan pada aturan formal, dan minim ruang kesalahan.',
                'primary' => 'akuntansi',
                'secondary' => 'manajemen-logistik',
            ],
            [
                'id' => 11,
                'text' => 'Saya suka mencari tren terbaru di media sosial, membuat materi promosi, atau mengelola toko online/marketplace.',
                'primary' => 'bisnis-daring-dan-pemasaran',
                'secondary' => 'desain-komunikasi-visual',
            ],
            [
                'id' => 12,
                'text' => 'Saya merasa nyaman dan teliti saat harus mengelola surat-menyurat resmi, notulen rapat, serta layanan komunikasi perkantoran.',
                'primary' => 'manajemen-perkantoran',
                'secondary' => null,
            ],
            [
                'id' => 13,
                'text' => 'Saya memiliki pola pikir logis-sistematis yang kuat untuk mencari letak kesalahan (debugging) pada suatu sistem atau alur kerja yang macet.',
                'primary' => 'rekayasa-perangkat-lunak',
                'secondary' => 'teknik-komputer-dan-jaringan',
            ],
            [
                'id' => 14,
                'text' => 'Saya menyukai tantangan teknis lapangan yang membutuhkan ketahanan fisik, ketelitian tinggi, dan penyelesaian masalah jaringan secara cepat.',
                'primary' => 'teknik-komputer-dan-jaringan',
                'secondary' => null,
            ],
            [
                'id' => 15,
                'text' => 'Saya senang mengekspresikan ide-ide kreatif yang unik ke dalam bentuk visual bergerak, fotografi profesional, atau identitas merek (branding).',
                'primary' => 'desain-komunikasi-visual',
                'secondary' => 'produksi-siaran-program-pertelevisian',
            ],
        ];
    }

    /**
     * @return array<string, array{name: string, code: string, slug: string, career: string, icon: string}>
     */
    protected function getMajors(): array
    {
        return [
            'rekayasa-perangkat-lunak' => [
                'name' => 'Rekayasa Perangkat Lunak',
                'code' => 'RPL',
                'slug' => 'rekayasa-perangkat-lunak',
                'career' => 'Software Developer, Web Engineer, Mobile App Creator',
                'icon' => 'code',
            ],
            'teknik-komputer-dan-jaringan' => [
                'name' => 'Teknik Komputer dan Jaringan',
                'code' => 'TKJ',
                'slug' => 'teknik-komputer-dan-jaringan',
                'career' => 'Network Administrator, Cloud Technician, System Support',
                'icon' => 'network',
            ],
            'desain-komunikasi-visual' => [
                'name' => 'Desain Komunikasi Visual',
                'code' => 'DKV',
                'slug' => 'desain-komunikasi-visual',
                'career' => 'Graphic Designer, UI/UX Specialist, Digital Illustrator',
                'icon' => 'palette',
            ],
            'akuntansi' => [
                'name' => 'Akuntansi dan Keuangan Lembaga',
                'code' => 'AK',
                'slug' => 'akuntansi',
                'career' => 'Junior Auditor, Financial Staff, Tax Administration',
                'icon' => 'calculator',
            ],
            'bisnis-daring-dan-pemasaran' => [
                'name' => 'Bisnis Daring dan Pemasaran',
                'code' => 'BDP',
                'slug' => 'bisnis-daring-dan-pemasaran',
                'career' => 'Digital Marketer, E-Commerce Specialist, Business Development',
                'icon' => 'trending-up',
            ],
            'manajemen-perkantoran' => [
                'name' => 'Manajemen Perkantoran',
                'code' => 'MP',
                'slug' => 'manajemen-perkantoran',
                'career' => 'Executive Secretary, Document Controller, Office Administrator',
                'icon' => 'file-text',
            ],
            'manajemen-logistik' => [
                'name' => 'Manajemen Logistik',
                'code' => 'MLOG',
                'slug' => 'manajemen-logistik',
                'career' => 'Supply Chain Officer, Warehouse Coordinator, Inventory Analyst',
                'icon' => 'box',
            ],
            'perhotelan' => [
                'name' => 'Perhotelan',
                'code' => 'PH',
                'slug' => 'perhotelan',
                'career' => 'Front Office Leader, Hospitality Officer, Food & Beverage Lead',
                'icon' => 'home',
            ],
            'produksi-siaran-program-pertelevisian' => [
                'name' => 'Produksi Siaran Pertelevisian',
                'code' => 'PSPT',
                'slug' => 'produksi-siaran-program-pertelevisian',
                'career' => 'Broadcast Director, Video Editor, Scriptwriter, Cameraperson',
                'icon' => 'video',
            ],
        ];
    }
}
```

Create view placeholder `resources/views/temukan-jurusan.blade.php`:
```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Smeas AI Major Finder - SMKN 1 Surabaya</title>
</head>
<body>
    <h1>Smeas AI Major Finder</h1>
</body>
</html>
```

- [ ] **Step 4: Run test to verify it passes**

Run:
```bash
php artisan test --filter=MajorFinderTest
```
Expected: PASS (3 tests, 3 assertions passed).

- [ ] **Step 5: Commit**

```bash
git add routes/web.php app/Http/Controllers/MajorFinderController.php resources/views/temukan-jurusan.blade.php tests/Feature/MajorFinderTest.php
git commit -m "feat(major-finder): scaffold controller, routes and initial tests"
```

---

### Task 2: Dedicated AI Career Counselor Service with Gemini Integration

**Files:**
- Create: `app/Services/MajorFinder/MajorAnalysisService.php`
- Modify: `app/Http/Controllers/MajorFinderController.php`
- Modify: `tests/Feature/MajorFinderTest.php`

- [ ] **Step 1: Write test for MajorAnalysisService**

Tambahkan method pengujian ke `tests/Feature/MajorFinderTest.php`:
```php
    public function test_service_generates_personalized_analysis(): void
    {
        $service = app(\App\Services\MajorFinder\MajorAnalysisService::class);
        $analysis = $service->generate(
            nama: 'Budi',
            topMajor: ['name' => 'Rekayasa Perangkat Lunak', 'score' => 95],
            alternatives: [['name' => 'Teknik Komputer dan Jaringan', 'score' => 80]],
            highlights: ['coding', 'debugging']
        );

        $this->assertNotEmpty($analysis);
        $this->assertStringContainsString('Budi', $analysis);
        $this->assertStringContainsString('Rekayasa Perangkat Lunak', $analysis);
    }
```

- [ ] **Step 2: Run test to verify it fails**

Run:
```bash
php artisan test --filter=MajorFinderTest
```
Expected: FAIL (Class `App\Services\MajorFinder\MajorAnalysisService` does not exist).

- [ ] **Step 3: Implement MajorAnalysisService**

Create `app/Services/MajorFinder/MajorAnalysisService.php`:
```php
<?php

namespace App\Services\MajorFinder;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MajorAnalysisService
{
    /**
     * @param array{name: string, score: numeric} $topMajor
     * @param array<int, array{name: string, score: numeric}> $alternatives
     * @param array<int, string> $highlights
     */
    public function generate(string $nama, array $topMajor, array $alternatives = [], array $highlights = []): string
    {
        $nama = ! empty(trim($nama)) ? trim($nama) : 'Sobat SMEAS';
        $topName = $topMajor['name'] ?? 'Pilihan Kejuruan';
        $topScore = $topMajor['score'] ?? 90;

        $altNames = collect($alternatives)->pluck('name')->filter()->take(2)->implode(', ');
        $highlightStr = ! empty($highlights) ? implode(', ', $highlights) : 'minat teknologi dan analisa';

        $apiKey = Config::get('services.gemini.api_key');
        $model = Config::get('services.gemini.model', 'gemini-1.5-flash');
        $baseUrl = Config::get('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');

        if (! empty($apiKey)) {
            try {
                $prompt = <<<PROMPT
Kamu adalah AI Career Counselor & Guru Bimbingan Karir resmi SMKN 1 Surabaya (SMEAS).
Berikan analisis personal yang memotivasi, inspiratif, dan hangat untuk calon siswa baru yang baru saja menyelesaikan tes kuesioner minat bakat.

Data Siswa:
- Nama: {$nama}
- Jurusan Teratas: {$topName} (Kecocokan {$topScore}%)
- Jurusan Alternatif: {$altNames}
- Minat yang Menonjol: {$highlightStr}

Panduan Penulisan:
1. Sapa {$nama} dengan ramah dan suportif di awal.
2. Jelaskan dalam 2-3 paragraf ringkas (total sekitar 120-160 kata) mengapa pola pikir dan minatnya sangat cocok dengan jurusan {$topName}, bagaimana peluang karirnya di masa depan, dan sebutkan jurusan alternatif sebagai opsi pelengkap.
3. Berikan kalimat penutup yang menyemangati untuk meraih cita-cita di SMKN 1 Surabaya.
4. Gunakan bahasa Indonesia yang santun, energik, dan mudah dimengerti remaja/calon siswa. Jangan gunakan format poin-poin panjang, buatlah narasi paragraf mengalir yang enak dibaca.
PROMPT;

                $response = Http::timeout(12)
                    ->withHeaders(['x-goog-api-key' => $apiKey])
                    ->post("{$baseUrl}/models/{$model}:generateContent", [
                        'contents' => [
                            ['role' => 'user', 'parts' => [['text' => $prompt]]],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.6,
                            'maxOutputTokens' => 600,
                        ],
                    ]);

                if ($response->successful()) {
                    $text = $response->json('candidates.0.content.parts.0.text');
                    if (! empty($text)) {
                        return trim($text);
                    }
                }
            } catch (Throwable $e) {
                Log::warning('MajorAnalysisService Gemini exception: '.$e->getMessage());
            }
        }

        return $this->getSmartFallback($nama, $topName, $topScore, $altNames);
    }

    protected function getSmartFallback(string $nama, string $topName, mixed $topScore, string $altNames): string
    {
        $altText = ! empty($altNames) ? " Selain itu, kamu juga memiliki potensi pendukung yang kuat di bidang {$altNames}." : '';

        return "Halo {$nama}! Berdasarkan hasil kuesioner probabilitas minat dan bakatmu, kamu menunjukkan kecocokan yang sangat tinggi pada bidang {$topName} dengan skor mencapai {$topScore}%. Karakteristik berpikirmu yang sistematis, tekun, dan penuh rasa ingin tahu adalah modal utama yang sangat dihargai di industri modern saat ini.{$altText} SMKN 1 Surabaya siap menjadi wadah terbaikmu dalam mengembangkan keterampilan vokasi nyata menuju karir masa depan yang gemilang!";
    }
}
```

Inject `MajorAnalysisService` into `MajorFinderController`:
Modify `app/Http/Controllers/MajorFinderController.php`:
```php
    public function __construct(
        protected \App\Services\MajorFinder\MajorAnalysisService $analysisService
    ) {}

    public function analisis(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => ['nullable', 'string', 'max:50'],
            'top_major' => ['required', 'array'],
            'top_major.name' => ['required', 'string', 'max:100'],
            'top_major.score' => ['required', 'numeric', 'min:0', 'max:100'],
            'alternatives' => ['nullable', 'array'],
            'highlights' => ['nullable', 'array'],
        ]);

        $analysis = $this->analysisService->generate(
            nama: $validated['nama'] ?? '',
            topMajor: $validated['top_major'],
            alternatives: $validated['alternatives'] ?? [],
            highlights: $validated['highlights'] ?? []
        );

        return response()->json([
            'success' => true,
            'analysis' => $analysis,
        ]);
    }
```

- [ ] **Step 4: Run test to verify it passes**

Run:
```bash
php artisan test --filter=MajorFinderTest
```
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add app/Services/MajorFinder/MajorAnalysisService.php app/Http/Controllers/MajorFinderController.php tests/Feature/MajorFinderTest.php
git commit -m "feat(major-finder): implement MajorAnalysisService with Gemini and smart fallback"
```

---

### Task 3: Interactive Blade View for Major Finder (Wizard & Dashboard)

**Files:**
- Modify: `resources/views/temukan-jurusan.blade.php`
- Modify: `tests/Feature/MajorFinderTest.php`

- [ ] **Step 1: Write test verifying view components**

Tambahkan method pengujian ke `tests/Feature/MajorFinderTest.php`:
```php
    public function test_view_renders_questions_and_majors_data(): void
    {
        $response = $this->get(route('temukan-jurusan'));

        $response->assertStatus(200);
        $response->assertSee('Saya sangat menikmati aktivitas yang melibatkan analisis angka');
        $response->assertSee('Rekayasa Perangkat Lunak');
        $response->assertSee('Teknik Komputer dan Jaringan');
        $response->assertSee('Desain Komunikasi Visual');
    }
```

- [ ] **Step 2: Run test to verify it fails**

Run:
```bash
php artisan test --filter=MajorFinderTest
```
Expected: FAIL (view placeholder does not contain questions/majors).

- [ ] **Step 3: Implement `resources/views/temukan-jurusan.blade.php`**

Implementasikan view lengkap dengan:
1. Header navigasi resmi SMEAS (logo & link kembali ke beranda).
2. **State 1: Intro Card**
   - Title: "Smeas AI Major Finder"
   - Subtitle: "Simulasi Kuis Probabilitas 9 Kejuruan SMKN 1 Surabaya"
   - Input nama panggilan (opsional).
   - Tombol "Mulai Kuesioner (15 Soal) →".
3. **State 2: Interactive Stepper Wizard**
   - Progress bar dinamis (misal 1/15 s.d. 15/15).
   - Teks pertanyaan yang jelas.
   - 5 tombol pilihan Likert (SS, S, N, TS, STS) dengan efek hover/active dan auto-advance 200ms.
   - Tombol navigasi "← Sebelumnya" untuk revisi.
4. **State 3: Calculating Transition**
   - Animasi radar/pulse kalkulasi probabilitas AI (~600ms).
5. **State 4: Rich Career Dashboard (Hasil)**
   - Top Match Card (#1): Jurusan Utama dengan persentase kecocokan besar, prospek karir, dan tombol langsung ke `route('jurusan.detail', $slug)`.
   - AI Insight Card: Narasi analisis personal dari Gemini AI dengan skeleton loading saat AJAX request berlangsung.
   - Ranked Breakdown: 9 progress bars horizontal berurutan dari ranking tertinggi ke terendah, lengkap dengan persentase dan link eksplorasi.
   - Action & Sharing:
     - Tombol "Bagikan ke WhatsApp" (`https://api.whatsapp.com/send?text=...`)
     - Tombol "Salin Tautan" dengan toast feedback.
     - Tombol "Daftar SPMB Sekarang" (`route('spmb.index')`).
     - Tombol "Ulangi Kuis".
6. Standalone Vanilla JS state machine yang rapi, responsive, mobile-first, dan tanpa ketergantungan library luar yang berat.

- [ ] **Step 4: Run test to verify it passes**

Run:
```bash
php artisan test --filter=MajorFinderTest
```
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add resources/views/temukan-jurusan.blade.php tests/Feature/MajorFinderTest.php
git commit -m "feat(major-finder): build interactive wizard and career dashboard view"
```

---

### Task 4: Revamp Landing Page Section "Temukan Jurusanmu"

**Files:**
- Modify: `resources/views/index.blade.php:953-1001`
- Modify: `tests/Feature/MajorFinderTest.php`

- [ ] **Step 1: Write test verifying landing page links to Major Finder**

Tambahkan method pengujian ke `tests/Feature/MajorFinderTest.php`:
```php
    public function test_landing_page_displays_ai_major_finder_showcase(): void
    {
        $response = $this->get(route('beranda'));

        $response->assertStatus(200);
        $response->assertSee(route('temukan-jurusan'));
        $response->assertSee('AI-Powered Recommendation');
        $response->assertSee('Mulai Tes Minat & Bakat');
    }
```

- [ ] **Step 2: Run test to verify it fails**

Run:
```bash
php artisan test --filter=test_landing_page_displays_ai_major_finder_showcase
```
Expected: FAIL (landing page still contains old search input without `AI-Powered Recommendation` and link to `temukan-jurusan`).

- [ ] **Step 3: Update `resources/views/index.blade.php` Section**

Ganti section baris 953–1001 di `resources/views/index.blade.php` dengan Hero Showcase Banner:
```blade
        {{-- ==================== TEMUKAN JURUSANMU (AI MAJOR FINDER) ==================== --}}
        <section style="padding:64px 0 80px;background:#f8fafc;">
            <div style="max-width:1280px;margin:0 auto;padding:0 16px;">
                <div class="fade-up" style="background:linear-gradient(135deg, #024089 0%, #001938 100%);border-radius:24px;padding:48px 32px;color:#fff;box-shadow:0 20px 40px -15px rgba(2,64,137,0.3);position:relative;overflow:hidden;">
                    {{-- Decorative background glow --}}
                    <div style="position:absolute;top:-60px;right:-60px;width:240px;height:240px;background:rgba(245,158,11,0.15);border-radius:50%;filter:blur(50px);pointer-events:none;"></div>
                    <div style="position:absolute;bottom:-40px;left:-40px;width:200px;height:200px;background:rgba(59,130,246,0.2);border-radius:50%;filter:blur(40px);pointer-events:none;"></div>

                    <div style="position:relative;z-index:1;max-width:760px;margin:0 auto;text-align:center;">
                        {{-- AI Badges --}}
                        <div style="display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);padding:6px 16px;border-radius:9999px;margin-bottom:20px;">
                            <span style="font-size:0.8rem;font-weight:700;color:#fde047;display:inline-flex;align-items:center;gap:6px;">
                                <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                AI-Powered Recommendation
                            </span>
                            <span style="color:rgba(255,255,255,0.4);font-size:0.75rem;">•</span>
                            <span style="color:#e2e8f0;font-size:0.8rem;">15 Pertanyaan • ±3 Menit</span>
                        </div>

                        {{-- Title & Subtitle --}}
                        <h2 style="font-size:clamp(1.75rem, 4vw, 2.5rem);font-weight:800;color:#fff;line-height:1.25;margin-bottom:16px;letter-spacing:-0.02em;">
                            Bingung Memilih Jurusan yang Tepat di SMEAS?
                        </h2>
                        <p style="font-size:clamp(0.95rem, 2vw, 1.1rem);color:#cbd5e1;line-height:1.6;margin-bottom:32px;">
                            Ikuti simulasi kuesioner probabilitas cerdas untuk memetakan bakat, minat, dan potensi karirmu secara akurat di 9 bidang keahlian vokasi SMKN 1 Surabaya.
                        </p>

                        {{-- Action Buttons --}}
                        <div style="display:flex;align-items:center;justify-content:center;gap:16px;flex-wrap:wrap;">
                            <a href="{{ route('temukan-jurusan') }}"
                                style="display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:16px 36px;font-size:1rem;font-weight:700;color:#fff;background:#f59e0b;border-radius:12px;text-decoration:none;box-shadow:0 10px 20px -5px rgba(245,158,11,0.5);transition:all 0.3s ease;"
                                onmouseover="this.style.background='#d97706';this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.background='#f59e0b';this.style.transform='translateY(0)'">
                                Mulai Tes Minat & Bakat &rarr;
                            </a>
                            <a href="{{ route('jurusan') }}"
                                style="display:inline-flex;align-items:center;justify-content:center;padding:16px 28px;font-size:0.95rem;font-weight:600;color:#fff;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.25);border-radius:12px;text-decoration:none;transition:all 0.3s ease;"
                                onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                                onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                                Direktori 9 Jurusan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
```

- [ ] **Step 4: Run test to verify it passes**

Run:
```bash
php artisan test --filter=test_landing_page_displays_ai_major_finder_showcase
```
Expected: PASS.

- [ ] **Step 5: Commit**

```bash
git add resources/views/index.blade.php tests/Feature/MajorFinderTest.php
git commit -m "feat(landing): replace search section with AI Major Finder hero showcase banner"
```

---

### Task 5: Formatting, Linting (Laravel Pint) & Full Test Verification

**Files:**
- Modified & Created repository files

- [ ] **Step 1: Run Pint code style linter**

Run:
```bash
php vendor/bin/pint --dirty
```
Expected: Pint fixes any code style inconsistencies.

- [ ] **Step 2: Run complete test suite**

Run:
```bash
php artisan test
```
Expected: All tests PASS without regressions.

- [ ] **Step 3: Commit any formatting changes**

```bash
git add -A
git commit -m "style: apply Laravel Pint formatting to AI Major Finder files"
```
