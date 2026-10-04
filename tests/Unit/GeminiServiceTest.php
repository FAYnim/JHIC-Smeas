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
                    ['content' => ['parts' => [['text' => 'Halo! Saya Smeas.Ai, siap membantu.']]]],
                ],
            ], 200),
        ]);

        $mockKnowledge = $this->createMock(KnowledgeManager::class);
        $mockKnowledge->method('getSystemContext')->willReturn('Informasi Sekolah SMKN 1 Surabaya.');

        $reply = (new GeminiService($mockKnowledge))->ask('Halo, jurusan apa saja yang ada di sini?', []);

        $this->assertEquals('Halo! Saya Smeas.Ai, siap membantu.', $reply);
    }

    public function test_it_returns_friendly_fallback_when_api_fails(): void
    {
        Config::set('services.gemini.api_key', 'test-api-key');

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response(null, 500),
        ]);

        $mockKnowledge = $this->createMock(KnowledgeManager::class);
        $mockKnowledge->method('getSystemContext')->willReturn('Info.');

        $reply = (new GeminiService($mockKnowledge))->ask('Halo', []);

        $this->assertStringContainsString('gangguan koneksi', $reply);
    }
}
