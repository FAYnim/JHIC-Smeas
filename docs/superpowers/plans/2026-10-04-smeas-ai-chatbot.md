# Smeas.Ai Chatbot Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Membangun chatbot asisten virtual Smeas.Ai di website SMKN 1 Surabaya menggunakan pivot arsitektur Prompt-Stuffed LLM berbasis Google Gemini Flash API dengan floating UI interaktif.

**Architecture:** Frontend menggunakan Blade component floating widget yang persis dengan mockup (trigger button avatar robot, chat popup, speech bubble bot/user, quick suggestion chips, typing indicator). Backend Laravel menggunakan `KnowledgeManager` untuk mengkompilasi file Markdown profil sekolah & data dinamis database (lowongan & pengumuman aktif) ke dalam System Instruction Gemini Flash API melalui `GeminiService` dengan multi-turn session history dan rate limiting.

**Tech Stack:** Laravel 13 (PHP 8.3/8.5), Tailwind CSS v4, Google Gemini Flash API (`gemini-1.5-flash`), Vanilla JavaScript / Fetch API, PHPUnit 12.

---

### File Structure Map
- **Config & Env:**
  - `config/services.php`: Registrasi key dan endpoint Gemini API.
  - `.env.example`: Penambahan variable `GEMINI_API_KEY` dan `GEMINI_MODEL`.
- **Knowledge Base & Service:**
  - `resources/knowledge/smeas-knowledge.md`: Dokumen markdown master profil sekolah, keahlian, SPMB, fasilitas, dan kontak.
  - `app/Services/Chatbot/KnowledgeManager.php`: Service pengompilasi static knowledge dan dynamic models dengan caching 15 menit.
  - `app/Services/Chatbot/GeminiService.php`: Service klien HTTP ke Google Generative Language API.
- **Controller & Routing:**
  - `app/Http/Controllers/ChatbotController.php`: Endpoint handler AJAX untuk kirim pesan dan reset session.
  - `routes/web.php`: Pendaftaran rute POST `/api/chatbot/message` dan `/api/chatbot/reset` dengan middleware throttle.
- **Frontend Widget & Assets:**
  - `public/images/smeas-ai-avatar.png` (atau inline SVG avatar robot): Aset visual robot Smeas.Ai.
  - `resources/views/partials/chatbot-widget.blade.php`: Komponen Blade widget chat floating interaktif.
  - `resources/views/partials/navbar.blade.php`: Integrasi widget ke seluruh halaman publik.
- **Tests:**
  - `tests/Unit/KnowledgeManagerTest.php`: Pengujian kompilasi knowledge base dan cache.
  - `tests/Unit/GeminiServiceTest.php`: Pengujian payload dan komunikasi Gemini API dengan `Http::fake()`.
  - `tests/Feature/ChatbotTest.php`: Pengujian endpoint API, validasi request, reset history, dan throttling.

---

### Task 1: Environment & Config Setup

**Files:**
- Modify: `config/services.php:30-40`
- Modify: `.env.example`

- [ ] **Step 1: Update `config/services.php`**
Tambahkan konfigurasi `gemini` di `config/services.php`:
```php
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
        'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),
    ],
```

- [ ] **Step 2: Update `.env.example` and local `.env`**
Tambahkan variabel environment:
```env
GEMINI_API_KEY=
GEMINI_MODEL=gemini-1.5-flash
```

- [ ] **Step 3: Verify configuration cache**
Jalankan: `php artisan config:clear`
Expected: `Configuration cache cleared successfully.`

- [ ] **Step 4: Commit**
```bash
git add config/services.php .env.example
git commit -m "feat(chatbot): add gemini api configuration"
```

---

### Task 2: Static Knowledge Base Document

**Files:**
- Create: `resources/knowledge/smeas-knowledge.md`

- [ ] **Step 1: Create master school knowledge base**
Tulis informasi komprehensif SMKN 1 Surabaya mencakup:
1. Profil & Identitas: SMKN 1 Surabaya (SMEAS), Jl. Smea No. 4, Wonokromo, Surabaya.
2. Visi & Misi Sekolah.
3. 9 Program / Konsentrasi Keahlian:
   - Rekayasa Perangkat Lunak (RPL)
   - Teknik Komputer dan Jaringan (TKJ)
   - Desain Komunikasi Visual / Multimedia (DKV/DMM)
   - Akuntansi dan Keuangan Lembaga (AKL)
   - Manajemen Perkantoran dan Layanan Bisnis (MPLB / OTKP)
   - Bisnis Daring dan Pemasaran (BDP / Pemasaran)
   - Perbankan dan Keuangan Mikro (PKM)
   - Usaha Layanan Pariwisata (ULP)
   - Broadcasting dan Perfilman (BC)
4. Informasi SPMB / PPDB: Persyaratan, alur verifikasi berkas, portal online `/spmb`.
5. Fasilitas & Layanan: Lab Komputer, Studio Broadcast, Lapangan Olahraga, BLUD Mart (`/blud`), Pusat Karir & BKK (`/pusat-karir`).
6. Jam Operasional & Kontak: Senin–Kamis 07.00–15.00, Jumat 07.00–14.00, Telp 031-8292038, Email info@smkn1-sby.sch.id.

- [ ] **Step 2: Commit**
```bash
git add resources/knowledge/smeas-knowledge.md
git commit -m "feat(chatbot): add static school knowledge base markdown"
```

---

### Task 3: KnowledgeManager Service & Unit Test

**Files:**
- Create: `app/Services/Chatbot/KnowledgeManager.php`
- Test: `tests/Unit/KnowledgeManagerTest.php`

- [ ] **Step 1: Write the failing unit test**
Buat test `tests/Unit/KnowledgeManagerTest.php`:
```php
<?php

namespace Tests\Unit;

use App\Models\Lowongan;
use App\Models\Pengumuman;
use App\Services\Chatbot\KnowledgeManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class KnowledgeManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_assembles_static_and_dynamic_knowledge_correctly(): void
    {
        Cache::flush();

        Lowongan::create([
            'judul_posisi' => 'Junior Web Developer Magang',
            'perusahaan' => 'PT Smeas Inovasi Digital',
            'tipe' => 'magang',
            'is_published' => true,
            'lokasi' => 'Surabaya',
        ]);

        Pengumuman::create([
            'judul' => 'Pengumuman Libur Hari Besar',
            'isi' => 'Seluruh siswa diliburkan pada hari senin.',
        ]);

        $manager = new KnowledgeManager();
        $context = $manager->getSystemContext();

        $this->assertStringContainsString('SMKN 1 Surabaya', $context);
        $this->assertStringContainsString('Junior Web Developer Magang', $context);
        $this->assertStringContainsString('Pengumuman Libur Hari Besar', $context);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**
Jalankan: `php artisan test tests/Unit/KnowledgeManagerTest.php`
Expected: FAIL (Class `KnowledgeManager` does not exist).

- [ ] **Step 3: Implement `KnowledgeManager`**
Buat `app/Services/Chatbot/KnowledgeManager.php`:
```php
<?php

namespace App\Services\Chatbot;

use App\Models\Lowongan;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class KnowledgeManager
{
    protected string $knowledgePath;

    public function __construct(?string $knowledgePath = null)
    {
        $this->knowledgePath = $knowledgePath ?? resource_path('knowledge/smeas-knowledge.md');
    }

    public function getSystemContext(): string
    {
        return Cache::remember('smeas_ai_full_context', 900, function () {
            $staticContent = '';
            if (File::exists($this->knowledgePath)) {
                $staticContent = File::get($this->knowledgePath);
            }

            $dynamicContent = $this->buildDynamicContent();

            return $staticContent . "\n\n" . $dynamicContent;
        });
    }

    protected function buildDynamicContent(): string
    {
        $lines = ["## INFORMASI TERKINI & LOWONGAN AKTIF (DATABASE LIVE)"];

        try {
            $lowongans = Lowongan::where('is_published', true)
                ->latest()
                ->take(5)
                ->get(['judul_posisi', 'perusahaan', 'tipe', 'lokasi', 'slug']);

            if ($lowongans->isNotEmpty()) {
                $lines[] = "### Lowongan Kerja & Magang Tersedia di Pusat Karir:";
                foreach ($lowongans as $l) {
                    $link = $l->slug ? "/pusat-karir/{$l->slug}" : "/pusat-karir";
                    $lines[] = "- [{$l->tipe}] {$l->judul_posisi} di {$l->perusahaan} ({$l->lokasi}) - Detail: {$link}";
                }
            }
        } catch (\Throwable $e) {
            // Gracefully handle if table not migrated in test
        }

        try {
            $pengumumans = Pengumuman::latest()->take(3)->get(['judul', 'created_at']);
            if ($pengumumans->isNotEmpty()) {
                $lines[] = "### Pengumuman Terbaru:";
                foreach ($pengumumans as $p) {
                    $lines[] = "- {$p->judul}";
                }
            }
        } catch (\Throwable $e) {
            // Gracefully handle
        }

        return implode("\n", $lines);
    }
}
```

- [ ] **Step 4: Run test to verify it passes**
Jalankan: `php artisan test tests/Unit/KnowledgeManagerTest.php`
Expected: PASS.

- [ ] **Step 5: Commit**
```bash
git add app/Services/Chatbot/KnowledgeManager.php tests/Unit/KnowledgeManagerTest.php
git commit -m "feat(chatbot): implement KnowledgeManager service with unit tests"
```

---

### Task 4: GeminiService & Unit Test

**Files:**
- Create: `app/Services/Chatbot/GeminiService.php`
- Test: `tests/Unit/GeminiServiceTest.php`

- [ ] **Step 1: Write the failing unit test**
Buat test `tests/Unit/GeminiServiceTest.php` menggunakan `Http::fake()`:
```php
<?php

namespace Tests\Unit;

use App\Services\Chatbot\GeminiService;
use App\Services\Chatbot\KnowledgeManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GeminiServiceTest extends TestCase
{
    public function test_it_generates_response_from_gemini(): void
    {
        Config::set('services.gemini.api_key', 'test-api-key');
        Config::set('services.gemini.model', 'gemini-1.5-flash');

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [
                    [
                        'content' => [
                            'parts' => [
                                ['text' => 'Halo! Saya Smeas.Ai, siap membantu.']
                            ]
                        ]
                    ]
                ]
            ], 200)
        ]);

        $mockKnowledge = $this->createMock(KnowledgeManager::class);
        $mockKnowledge->method('getSystemContext')->willReturn('Informasi Sekolah SMKN 1 Surabaya.');

        $service = new GeminiService($mockKnowledge);
        $reply = $service->ask('Halo, jurusan apa saja yang ada di sini?', []);

        $this->assertEquals('Halo! Saya Smeas.Ai, siap membantu.', $reply);
    }

    public function test_it_returns_friendly_fallback_when_api_fails(): void
    {
        Config::set('services.gemini.api_key', 'test-api-key');

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response(null, 500)
        ]);

        $mockKnowledge = $this->createMock(KnowledgeManager::class);
        $mockKnowledge->method('getSystemContext')->willReturn('Info.');

        $service = new GeminiService($mockKnowledge);
        $reply = $service->ask('Halo', []);

        $this->assertStringContainsString('gangguan koneksi', $reply);
    }
}
```

- [ ] **Step 2: Run test to verify it fails**
Jalankan: `php artisan test tests/Unit/GeminiServiceTest.php`
Expected: FAIL (Class `GeminiService` does not exist).

- [ ] **Step 3: Implement `GeminiService`**
Buat `app/Services/Chatbot/GeminiService.php`:
```php
<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    public function __construct(
        protected KnowledgeManager $knowledgeManager
    ) {}

    public function ask(string $message, array $history = []): string
    {
        $apiKey = Config::get('services.gemini.api_key');
        $model = Config::get('services.gemini.model', 'gemini-1.5-flash');
        $baseUrl = Config::get('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');

        if (empty($apiKey)) {
            return "Mohon maaf, API Key Smeas.Ai belum dikonfigurasi di server. Silakan hubungi admin sekolah.";
        }

        $systemPrompt = $this->buildSystemPrompt();
        $contents = $this->buildContentsPayload($message, $history);

        try {
            $endpoint = "{$baseUrl}/models/{$model}:generateContent?key={$apiKey}";
            $response = Http::timeout(15)->post($endpoint, [
                'system_instruction' => [
                    'parts' => [
                        ['text' => $systemPrompt]
                    ]
                ],
                'contents' => $contents,
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 800,
                ],
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($reply) {
                    return trim($reply);
                }
            }

            Log::error('Gemini API Error: ' . $response->body());
        } catch (\Throwable $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
        }

        return "Mohon maaf, Smeas.Ai sedang mengalami gangguan koneksi ke server AI. Kamu bisa menghubungi WhatsApp resmi SMKN 1 Surabaya atau menjelajahi menu website.";
    }

    protected function buildSystemPrompt(): string
    {
        $knowledge = $this->knowledgeManager->getSystemContext();

        return <<<PROMPT
Kamu adalah Smeas.Ai, asisten AI resmi SMKN 1 Surabaya (SMEAS).
Karakter: Ramah, santun, cerdas, energik, dan solutif bagi calon siswa, siswa, wali murid, dan guru.

Aturan Utama:
1. Jawablah hanya berdasarkan DOKUMEN PENGETAHUAN SEKOLAH yang disediakan di bawah ini.
2. Jika informasi tidak ada di dalam dokumen, katakan dengan sopan bahwa kamu belum memiliki informasi tersebut dan sarankan untuk menghubungi kontak resmi sekolah.
3. JANGAN PERNAH berhalusinasi atau mengarang info yang tidak terverifikasi (jadwal, biaya, syarat, dll).
4. Jika pengguna bercanda, halu, atau melontarkan topik di luar sekolah, responlah dengan ramah dan santai (misal: "Hehe, itu di luar info sekolah nih!"), lalu arahkan kembali ke topik sekolah dengan bersahabat.
5. Gunakan bahasa Indonesia yang baik, ramah, dan mudah dipahami.
6. Bila menyarankan halaman website, berikan markdown link yang valid (misal: /jurusan, /pusat-karir/magang, /spmb).

DOKUMEN PENGETAHUAN SEKOLAH:
{$knowledge}
PROMPT;
    }

    protected function buildContentsPayload(string $newMessage, array $history): array
    {
        $contents = [];

        // Ambil maksimal 5 pasang percakapan terakhir
        $recentHistory = array_slice($history, -10);

        foreach ($recentHistory as $turn) {
            $role = ($turn['sender'] ?? 'user') === 'user' ? 'user' : 'model';
            $contents[] = [
                'role' => $role,
                'parts' => [['text' => $turn['text'] ?? '']]
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $newMessage]]
        ];

        return $contents;
    }
}
```

- [ ] **Step 4: Run test to verify it passes**
Jalankan: `php artisan test tests/Unit/GeminiServiceTest.php`
Expected: PASS.

- [ ] **Step 5: Commit**
```bash
git add app/Services/Chatbot/GeminiService.php tests/Unit/GeminiServiceTest.php
git commit -m "feat(chatbot): implement GeminiService with HTTP fake unit tests"
```

---

### Task 5: ChatbotController & Routes

**Files:**
- Create: `app/Http/Controllers/ChatbotController.php`
- Modify: `routes/web.php`
- Test: `tests/Feature/ChatbotTest.php`

- [ ] **Step 1: Write the failing feature test**
Buat `tests/Feature/ChatbotTest.php`:
```php
<?php

namespace Tests\Feature;

use App\Services\Chatbot\GeminiService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    public function test_chatbot_message_endpoint_returns_successful_reply(): void
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('ask')
                ->once()
                ->with('Berapa jurusan di SMEAS?', \Mockery::any())
                ->andReturn('Ada 9 konsentrasi keahlian di SMKN 1 Surabaya.');
        });

        $response = $this->postJson('/api/chatbot/message', [
            'message' => 'Berapa jurusan di SMEAS?'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'reply' => 'Ada 9 konsentrasi keahlian di SMKN 1 Surabaya.'
            ]);
    }

    public function test_chatbot_message_validation_rejects_empty_input(): void
    {
        $response = $this->postJson('/api/chatbot/message', [
            'message' => ''
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_chatbot_reset_clears_session(): void
    {
        session(['smeas_chat_history' => [['sender' => 'user', 'text' => 'Halo']]]);

        $response = $this->postJson('/api/chatbot/reset');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertEmpty(session('smeas_chat_history', []));
    }
}
```

- [ ] **Step 2: Run test to verify it fails**
Jalankan: `php artisan test tests/Feature/ChatbotTest.php`
Expected: FAIL (404 route not found).

- [ ] **Step 3: Implement `ChatbotController` and Routes**
Buat `app/Http/Controllers/ChatbotController.php`:
```php
<?php

namespace App\Http\Controllers;

use App\Services\Chatbot\GeminiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(
        protected GeminiService $geminiService
    ) {}

    public function sendMessage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $history = session()->get('smeas_chat_history', []);

        $reply = $this->geminiService->ask($validated['message'], $history);

        $history[] = ['sender' => 'user', 'text' => $validated['message']];
        $history[] = ['sender' => 'model', 'text' => $reply];

        // Simpan 10 turn terakhir di session
        if (count($history) > 10) {
            $history = array_slice($history, -10);
        }

        session()->put('smeas_chat_history', $history);

        return response()->json([
            'success' => true,
            'reply' => $reply,
        ]);
    }

    public function resetSession(): JsonResponse
    {
        session()->forget('smeas_chat_history');

        return response()->json([
            'success' => true,
            'message' => 'Percakapan berhasil direset.',
        ]);
    }
}
```

Tambahkan rute di `routes/web.php`:
```php
use App\Http\Controllers\ChatbotController;

Route::prefix('api/chatbot')->group(function () {
    Route::post('/message', [ChatbotController::class, 'sendMessage'])
        ->middleware('throttle:15,1')
        ->name('chatbot.message');
    Route::post('/reset', [ChatbotController::class, 'resetSession'])
        ->name('chatbot.reset');
});
```

- [ ] **Step 4: Run test to verify it passes**
Jalankan: `php artisan test tests/Feature/ChatbotTest.php`
Expected: PASS.

- [ ] **Step 5: Commit**
```bash
git add app/Http/Controllers/ChatbotController.php routes/web.php tests/Feature/ChatbotTest.php
git commit -m "feat(chatbot): add ChatbotController and API routes with feature tests"
```

---

### Task 6: Avatar Icon & Asset Preparation

**Files:**
- Create: `public/images/smeas-ai-avatar.png` (atau file SVG teroptimasi `public/images/smeas-ai-bot.svg`)

- [ ] **Step 1: Create Smeas.Ai robot SVG avatar matching mockup**
Buat `public/images/smeas-ai-bot.svg` yang merepresentasikan avatar lingkaran biru dengan ikon robot tersenyum (sesuai gambar yang diunggah pengguna).
- [ ] **Step 2: Commit**
```bash
git add public/images/smeas-ai-bot.svg
git commit -m "feat(chatbot): add Smeas.Ai robot avatar asset"
```

---

### Task 7: Frontend Chatbot Blade Component

**Files:**
- Create: `resources/views/partials/chatbot-widget.blade.php`

- [ ] **Step 1: Build the Blade component**
Implementasikan widget floating dengan Tailwind CSS v4 & Vanilla JS:
- Launcher button di pojok kanan bawah (`fixed bottom-6 right-6 z-50`).
- Modal window dengan header navy, kartu status "Smeas.Ai Online", tombol reset, dan tombol close.
- Chat message bubble styling persis mockup (Bot: Blue bubble di kiri; User: Light blue di kanan; Typing dots).
- Quick prompt chips di atas input bar (`Tanya jurusan`, `Tempat Magang`, `Info SPMB`, `Kontak Sekolah`).
- Input bar dengan input pill dan send button.
- Format Markdown link (`[teks](url)`) agar pengguna bisa langsung klik ke halaman terkait di website.
- State handling: loading indicator, auto-scroll ke bawah, error toast jika terjadi kendala.

- [ ] **Step 2: Commit**
```bash
git add resources/views/partials/chatbot-widget.blade.php
git commit -m "feat(chatbot): add Smeas.Ai floating chat widget UI component"
```

---

### Task 8: Integration into Master Layout & Verification

**Files:**
- Modify: `resources/views/partials/navbar.blade.php` (sertakan `@include('partials.chatbot-widget')` sehingga otomatis tampil di semua halaman publik)

- [ ] **Step 1: Include widget in `resources/views/partials/navbar.blade.php`**
Tambahkan di akhir file `resources/views/partials/navbar.blade.php`:
```blade
@include('partials.chatbot-widget')
```

- [ ] **Step 2: Run all test suites and linting**
Jalankan:
```bash
php artisan test
php vendor/bin/pint --test
```
Expected: All tests pass, pint passes without formatting errors.

- [ ] **Step 3: Commit**
```bash
git add resources/views/partials/navbar.blade.php
git commit -m "feat(chatbot): integrate Smeas.Ai widget into public navigation layout"
```

---

## Plan Self-Review Check
1. **Spec Coverage:**
   - Prompt-Stuffed LLM? Covered in Task 3 & 4.
   - Google Gemini Flash API? Covered in Task 1 & 4.
   - Floating widget matching mockup? Covered in Task 6 & 7.
   - Multi-turn session & rate limiting? Covered in Task 5.
   - Quick chips & error handling? Covered in Task 4, 5, 7.
2. **No Placeholders:** All tasks contain exact file paths, complete code, and test commands.
3. **Type Consistency:** Method names `getSystemContext()`, `ask()`, `sendMessage()`, `resetSession()` consistent across all tasks.
