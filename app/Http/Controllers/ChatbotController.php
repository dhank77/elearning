<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function __construct(protected ChatbotService $chatbot)
    {
    }

    public function ask(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        try {
            $answer = $this->chatbot->generateResponse($validated['question']);
        } catch (\Throwable $e) {
            return response()->json(['answer' => 'Maaf, saya tidak dapat menjawab saat ini. Silakan coba beberapa saat lagi.'], 500);
        }

        return response()->json(['answer' => $answer]);
    }

    public function stream(Request $request)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        return response()->stream(function () use ($validated) {
            try {
                foreach ($this->chatbot->generateResponseStream($validated['question']) as $event) {
                    if ($event instanceof \Prism\Prism\Streaming\Events\TextDeltaEvent) {
                        echo 'data: '.json_encode(['delta' => $event->delta])."\n\n";
                    } elseif ($event instanceof \Prism\Prism\Streaming\Events\StreamEndEvent) {
                        echo "data: [DONE]\n\n";
                    }
                }
            } catch (\Throwable $e) {
                echo "data: ".json_encode(['delta' => 'Maaf, saya tidak dapat menjawab saat ini. Silakan coba beberapa saat lagi.'])."\n\n";
                echo "data: [DONE]\n\n";
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }
}

                        }
                    } catch (\Throwable $e) {
                        echo "data: ".json_encode(['delta' => 'Maaf, saya tidak dapat menjawab saat ini. Silakan coba beberapa saat lagi.'])."\n\n";
                        echo "data: [DONE]\n\n";
                    }
                }, 200, [
                    'Content-Type' => 'text/event-stream',
                    'Cache-Control' => 'no-cache',
                    'X-Accel-Buffering' => 'no',
                    'Connection' => 'keep-alive',
                ]);

                try {
                    $answer = $this->chatbot->generateResponse($validated['question']);
                } catch (\Throwable $e) {
                    return response()->json(['answer' => 'Maaf, saya tidak dapat menjawab saat ini. Silakan coba beberapa saat lagi.'], 500);
                }

                return response()->json(['answer' => $answer]);
    }

    public function stream(Request $request)
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        $key = 'chatbot-stream:'.str($validated['question']);
        $maxAttempts = 30;

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            return response()->json(['error' => 'Terlalu banyak pertanyaan. Coba lagi nanti.'], 429);
        }

        RateLimiter::hit($key, 60);

        return response()->stream(function () use ($validated) {
            foreach ($this->chatbot->generateResponseStream($validated['question']) as $event) {
                if ($event instanceof TextDeltaEvent) {
                    echo 'data: '.json_encode(['delta' => $event->delta])."\n\n";
                } elseif ($event instanceof StreamEndEvent) {
                    echo "data: [DONE]\n\n";
                }
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
            'Connection' => 'keep-alive',
        ]);
    }
}
