<?php

namespace Tests\Feature;

use App\Services\Chatbot\GeminiService;
use Mockery;
use Tests\TestCase;

class ChatbotTest extends TestCase
{
    public function test_chatbot_message_endpoint_returns_successful_reply(): void
    {
        $this->mock(GeminiService::class, function ($mock) {
            $mock->shouldReceive('ask')
                ->once()
                ->with('Berapa jurusan di SMEAS?', Mockery::any())
                ->andReturn('Ada 9 konsentrasi keahlian di SMKN 1 Surabaya.');
        });

        $this->postJson('/api/chatbot/message', ['message' => 'Berapa jurusan di SMEAS?'])
            ->assertOk()
            ->assertJson([
                'success' => true,
                'reply' => 'Ada 9 konsentrasi keahlian di SMKN 1 Surabaya.',
            ]);
    }

    public function test_chatbot_message_validation_rejects_empty_input(): void
    {
        $this->postJson('/api/chatbot/message', ['message' => ''])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['message']);
    }

    public function test_chatbot_reset_clears_session(): void
    {
        $this->withSession(['smeas_chat_history' => [['sender' => 'user', 'text' => 'Halo']]])
            ->postJson('/api/chatbot/reset')
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEmpty(session('smeas_chat_history', []));
    }
}
