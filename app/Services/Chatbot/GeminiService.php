<?php

namespace App\Services\Chatbot;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

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
            return 'Mohon maaf, API Key Smeas.Ai belum dikonfigurasi di server. Silakan hubungi admin sekolah.';
        }

        try {
            $response = Http::timeout(15)
                ->withHeaders(['x-goog-api-key' => $apiKey])
                ->post("{$baseUrl}/models/{$model}:generateContent", [
                    'system_instruction' => [
                        'parts' => [['text' => $this->buildSystemPrompt()]],
                    ],
                    'contents' => $this->buildContentsPayload($message, $history),
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 800,
                    ],
                ]);

            if ($response->successful()) {
                $reply = $response->json('candidates.0.content.parts.0.text');
                if ($reply) {
                    return trim($reply);
                }
            }

            Log::error('Gemini API Error: '.$response->body());
        } catch (Throwable $e) {
            Log::error('Gemini API Exception: '.$e->getMessage());
        }

        return 'Mohon maaf, Smeas.Ai sedang mengalami gangguan koneksi ke server AI. Kamu bisa menghubungi WhatsApp resmi SMKN 1 Surabaya atau menjelajahi menu website.';
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
6. Bila menyarankan halaman website, berikan markdown link yang valid (misal: [Jurusan](/jurusan), [Magang](/pusat-karir/magang), [SPMB](/spmb)).

DOKUMEN PENGETAHUAN SEKOLAH:
{$knowledge}
PROMPT;
    }

    protected function buildContentsPayload(string $newMessage, array $history): array
    {
        $contents = [];

        foreach (array_slice($history, -10) as $turn) {
            $contents[] = [
                'role' => ($turn['sender'] ?? 'user') === 'user' ? 'user' : 'model',
                'parts' => [['text' => $turn['text'] ?? '']],
            ];
        }

        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $newMessage]],
        ];

        return $contents;
    }
}
