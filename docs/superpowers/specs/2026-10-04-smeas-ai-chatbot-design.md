# Design Document: Smeas.Ai School Chatbot (Pivot from RAG to Prompt-Stuffed LLM)

- **Date:** 2026-10-04
- **Project:** SMKN 1 Surabaya (JHIC-Smeas)
- **Status:** Approved for Implementation

---

## 1. Executive Summary & Background

Website SMKN 1 Surabaya membutuhkan asisten virtual interaktif (**Smeas.Ai**) untuk mempermudah calon siswa baru, masyarakat umum, siswa aktif, dan guru dalam mencari informasi sekolah (profil, 9 keahlian/jurusan, alur SPMB/PPDB, fasilitas, lowongan kerja/magang, dan kontak).

Awalnya sistem ini direncanakan menggunakan pipeline RAG (Retrieval-Augmented Generation) berbasis vector database dan embedding. Namun, dengan tenggat waktu pengembangan yang ketat (*waktu develop tidak nutut*), dilakukan **pivot arsitektur** ke pendekatan **Prompt-Stuffed LLM** dengan **Google Gemini Flash API**.

Pendekatan ini mengeliminasi *overhead* kompleksitas setup database vektor dan embedding retriever, tetapi tetap mempertahankan kualitas percakapan alami, kecerdasan konteks, dan akurasi tinggi.

---

## 2. Pivot Architecture & Trade-Offs

### 2.1 Trade-Off Analysis
| Aspek | RAG Penuh | Opsi Pivot: Prompt-Stuffed LLM |
|---|---|---|
| **Waktu Pengerjaan** | 1–2 minggu (butuh vector DB, chunker, indexer) | 1–2 hari kerja |
| **Infrastruktur** | Butuh Vector DB (Chroma/pgvector) & Background Worker | Cukup Laravel backend standar + HTTP Client |
| **Akurasi Fakta** | Tergantung efektivitas semantic chunking | Sangat tinggi, seluruh dokumen sekolah disuapkan langsung |
| **Token per Request** | Kecil (hanya chunks terambil) | ~10k – 20k token context (sangat murah/free di Gemini Flash) |
| **Latency** | 2 tahap (Vector Search + LLM Generation) | 1 tahap panggilan langsung ke Gemini API |

---

## 3. System Architecture & Data Flow

```
+-------------------------------------------------------------------------+
|                              Web Browser                                |
|  - Floating Action Button (Robot Avatar)                                |
|  - Smeas.Ai Chat Widget (Card Popup / Fullscreen Mobile Sheet)          |
|  - Quick-Prompt Suggestion Chips & Message Input                        |
+-------------------------------------------------------------------------+
                                    │
                                    │ POST /api/chatbot/message (AJAX Fetch)
                                    ▼
+-------------------------------------------------------------------------+
|                            Laravel Backend                              |
|                                                                         |
| 1. Route & Middleware                                                   |
|    - Route::post('/api/chatbot/message')                                |
|    - Throttle: 15 request/minute/IP                                     |
|                                                                         |
| 2. ChatbotController                                                    |
|    - Request validation: message (string, max 500 chars)                |
|    - Session management: retrieve last 5 dialogue turns                 |
|                                                                         |
| 3. KnowledgeManager Service                                             |
|    - Load static: resources/knowledge/smeas-knowledge.md                |
|    - Append dynamic:                                                    |
|        * 5 Active Job/Internship Vacancies (Lowongan model)             |
|        * 3 Recent Announcements (Pengumuman model)                      |
|    - Cached via Cache::remember() for 15-30 minutes                     |
|                                                                         |
| 4. GeminiService                                                        |
|    - Compose systemInstruction (Persona + Strict Guardrails + Context)  |
|    - Build message history (multi-turn) + new user prompt               |
|    - Send HTTP request to Google Gemini Flash endpoint                  |
|                                                                         |
| 5. Response Formatter                                                   |
|    - Format reply text (clean markdown)                                 |
|    - Update session conversation history                                |
+-------------------------------------------------------------------------+
                                    │
                                    │ HTTP JSON Payload
                                    ▼
+-------------------------------------------------------------------------+
|                   Google Gemini API (Gemini 2.5/1.5 Flash)              |
|                   - Free-tier quota support                             |
|                   - 1M+ token context window capability                 |
+-------------------------------------------------------------------------+
```

---

## 4. Detailed Component Specifications

### 4.1 Backend Architecture

#### A. File Configuration & Environment
- Tambahkan konfigurasi di `.env`:
  ```env
  GEMINI_API_KEY=your_gemini_api_key_here
  GEMINI_MODEL=gemini-1.5-flash
  ```
- Tambahkan entry di `config/services.php`:
  ```php
  'gemini' => [
      'api_key' => env('GEMINI_API_KEY'),
      'model' => env('GEMINI_MODEL', 'gemini-1.5-flash'),
      'base_url' => 'https://generativelanguage.googleapis.com/v1beta',
  ],
  ```

#### B. KnowledgeManager Service (`App\Services\Chatbot\KnowledgeManager.php`)
- **Fungsi:** Menggabungkan static knowledge sekolah dan data dinamis dari database.
- **Cache Strategy:** Hasil kompilasi context disimpan dalam cache selama 15 menit menggunakan `Cache::remember('smeas_ai_full_context', 900, ...)`.
- **Sumber Data:**
  - `resources/knowledge/smeas-knowledge.md`:
    - Profil Singkat SMKN 1 Surabaya (alamat, visi, misi, akreditasi).
    - Daftar Lengkap 9 Konsentrasi Keahlian (RPL, TKJ, DMM, AKL, BDP, OTKP, dll) berserta prospek karir dan keunggulan.
    - Panduan SPMB / PPDB (jadwal umum, jalur pendaftaran, berkas).
    - Fasilitas & Ekstrakurikuler.
    - Jam operasional dan kontak resmi sekolah.
  - Data Dinamis:
    - Judul & perusahaan lowongan kerja/magang aktif (`Lowongan::where('is_published', true)->latest()->take(5)`).
    - Pengumuman terbaru (`Pengumuman::latest()->take(3)`).

#### C. GeminiService (`App\Services\Chatbot\GeminiService.php`)
- Memanggil API endpoint:
  `POST https://generativelanguage.googleapis.com/v1beta/models/{model}:generateContent?key={api_key}`
- Payload mencakup:
  - `system_instruction`: Persona Smeas.Ai, instruksi kesopanan, larangan halusinasi, dan dokumen knowledge base.
  - `contents`: Array percakapan riwayat (user & model) + input user terbaru.
  - `generationConfig`: `temperature: 0.4`, `maxOutputTokens: 800`.

#### D. ChatbotController (`App\Http\Controllers\ChatbotController.php`)
- `POST /api/chatbot/message`:
  - Request: `{ message: string }`.
  - Response sukses: `{ success: true, reply: string }`.
  - Response error: `{ success: false, message: string }`.
- `POST /api/chatbot/reset`:
  - Menghapus session `smeas_ai_chat_history`.
  - Response: `{ success: true, message: "Percakapan berhasil direset." }`.

---

### 4.2 Frontend Widget & UI Design

Komponen Blade: `resources/views/components/chatbot-widget.blade.php`.

#### A. Visual Structure (Sesuai Mockup Smeas.Ai)
1. **Floating Trigger Button:**
   - Posisi: Pojok kanan bawah (`fixed bottom-6 right-6 z-50`).
   - Tampilan: Tombol bulat dengan border halus, bayangan elegan, dan ikon avatar robot Smeas.Ai berwarna biru.
   - Indikator: Titik hijau status aktif / ripple effect.
2. **Chat Window Popup:**
   - Ukuran: Lebar 380px, tinggi 560px, rounded-2xl, shadow-2xl.
   - Header:
     - Background: Navy khas SMKN 1 (`#1e3a5f` / `#024089`).
     - Badge identitas putih (card melengkung): Ikon robot, teks **Smeas.Ai**, indikator hijau **Online**.
     - Action icons: Tombol reset percakapan (refresh icon) dan tombol tutup (close icon).
3. **Chat Message Area:**
   - Message list dengan auto-scroll ke bawah saat pesan baru masuk.
   - Pesan Bot: Bubble biru solid (`#007BFF` / `#024089`) dengan teks putih di kiri.
   - Pesan User: Bubble biru muda (`#93C5FD` / `#E0F2FE`) dengan teks gelap di kanan.
   - Markdown parser ringan: Mendukung `**teks tebal**`, bullet points, dan clickable links (`[teks](url)`).
   - Typing indicator: Bubble abu-abu dengan animasi 3 titik bouncing saat menunggu balasan Gemini.
4. **Quick Prompt Chips:**
   - Tombol shortcut responsif di atas input bar:
     - `[Tanya Jurusan]`
     - `[Tempat Magang]`
     - `[Alur SPMB]`
     - `[Kontak Sekolah]`
   - Klik chip langsung mengirim pertanyaan ke chatbot.
5. **Input Bar:**
   - Bar bawah berwarna navy.
   - Input pill rounded-full dengan background terang, placeholder `"Ketik pertanyaanmu..."`.
   - Tombol kirim berbentuk pesawat kertas (paper airplane).
   - State disabled & loading spinner saat request berlangsung.

---

## 5. Persona, Guardrails & Anti-Halusinasi

### 5.1 System Prompt Formulation
```markdown
Kamu adalah Smeas.Ai, asisten AI resmi SMKN 1 Surabaya (SMEAS).
Karakter: Ramah, santun, cerdas, energik, dan solutif bagi calon siswa, siswa, wali murid, dan guru.

Aturan Utama:
1. Jawablah hanya berdasarkan DOKUMEN PENGETAHUAN SEKOLAH yang disediakan di bawah ini.
2. Jika informasi tidak ada di dalam dokumen, katakan dengan sopan bahwa kamu belum memiliki informasi tersebut dan sarankan untuk menghubungi kontak resmi sekolah.
3. JANGAN PERNAH berhalusinasi atau mengarang info yang tidak terverifikasi (jadwal, biaya, syarat, dll).
4. Jika pengguna bercanda, halu, atau melontarkan topik di luar sekolah, responlah dengan ramah dan santai (misal: "Hehe, itu di luar info sekolah nih!"), lalu arahkan kembali ke topik sekolah dengan bersahabat.
5. Gunakan bahasa Indonesia yang baik, ramah, dan mudah dipahami.
6. Bila menyarankan halaman website, berikan markdown link yang valid (misal: /jurusan, /pusat-karir/magang, /spmb).
```

---

## 6. Security, Rate Limiting & Error Handling

1. **Rate Limiting:**
   - Middleware `throttle:15,1` diterapkan pada endpoint chatbot untuk mencegah brute force dan spam token.
2. **Input Sanitization:**
   - Validasi ketat `message => ['required', 'string', 'max:500']`.
   - Stripping script injection / XSS sebelum dirender di UI.
3. **Graceful Degradation (Fallback):**
   - Jika koneksi ke Gemini API gagal (timeout/quota limit):
     Kembalikan pesan fallback bersahabat:
     *"Mohon maaf, Smeas.Ai sedang mengalami gangguan koneksi. Silakan hubungi kami via WhatsApp resmi SMKN 1 Surabaya atau cek menu informasi website."*

---

## 7. Testing Strategy

1. **Feature Tests (`tests/Feature/ChatbotTest.php`):**
   - Test endpoint `/api/chatbot/message` mengembalikan status 200 dan respon JSON yang valid menggunakan `Http::fake()`.
   - Test penolakan input kosong dan input lebih dari 500 karakter (status 422).
   - Test throttling setelah 15 request dalam 1 menit (status 429).
   - Test endpoint `/api/chatbot/reset` berhasil membersihkan session.
2. **Manual UI Verification:**
   - Memastikan widget responsif di mobile dan desktop.
   - Memastikan transisi buka/tutup lancar.
   - Memastikan quick prompt chips berfungsi mengirim pesan instan.
   - Memastikan render markdown (bold, list, link) terlihat rapi.
