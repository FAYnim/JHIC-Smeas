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

        session()->put('smeas_chat_history', array_slice($history, -10));

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
