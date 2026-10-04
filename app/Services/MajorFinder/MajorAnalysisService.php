<?php

namespace App\Services\MajorFinder;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MajorAnalysisService
{
    /**
     * @param  array{name: string, score: numeric}  $topMajor
     * @param  array<int, array{name: string, score: numeric}>  $alternatives
     * @param  array<int, string>  $highlights
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
