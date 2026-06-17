<?php

use App\Services\ChatbotService;
use Prism\Prism\Enums\FinishReason;
use Prism\Prism\Streaming\EventID;
use Prism\Prism\Streaming\Events\StreamEndEvent;
use Prism\Prism\Streaming\Events\TextDeltaEvent;
use Prism\Prism\ValueObjects\Usage;

beforeEach(function () {
    $this->mock(ChatbotService::class, function ($mock) {
        $mock->shouldReceive('generateResponse')
            ->with('Apa kursus yang tersedia?')
            ->andReturn('Halo! Saya adalah asisten virtual. Ada yang bisa saya bantu?');

        $mock->shouldReceive('generateResponseStream')
            ->with('Apa kursus yang tersedia?')
            ->andReturn(collect([
                new TextDeltaEvent(
                    id: EventID::generate(),
                    timestamp: time(),
                    delta: 'Halo! ',
                    messageId: 'msg-1',
                ),
                new TextDeltaEvent(
                    id: EventID::generate(),
                    timestamp: time(),
                    delta: 'Saya adalah asisten virtual.',
                    messageId: 'msg-1',
                ),
                new StreamEndEvent(
                    id: EventID::generate(),
                    timestamp: time(),
                    finishReason: FinishReason::Stop,
                    usage: new Usage(10, 20),
                    additionalContent: [],
                ),
            ]))->byDefault();
    });
});

test('chatbot ask endpoint returns answer', function () {
    $response = $this->post('/chatbot/ask', [
        'question' => 'Apa kursus yang tersedia?',
    ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['answer']);
    $response->assertJsonFragment(['answer' => 'Halo! Saya adalah asisten virtual. Ada yang bisa saya bantu?']);
});

test('chatbot stream endpoint returns server-sent events', function () {
    $response = $this->post('/chatbot/stream', [
        'question' => 'Apa kursus yang tersedia?',
    ]);

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/event-stream; charset=utf-8');
});

test('chatbot endpoints reject short questions', function () {
    $this->post('/chatbot/ask', ['question' => 'hi'])
        ->assertSessionHasErrors('question');

    $this->post('/chatbot/stream', ['question' => 'hi'])
        ->assertSessionHasErrors('question');
});
