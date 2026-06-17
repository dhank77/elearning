<?php

use Prism\Prism\Facades\Prism;
use Prism\Prism\Enums\FinishReason;
use Prism\Prism\Text\Response as TextResponse;
use Prism\Prism\ValueObjects\Meta;
use Prism\Prism\ValueObjects\Usage;

beforeEach(function () {
    $fakeResponse = new TextResponse(
        steps: collect([]),
        text: 'Halo! Saya adalah asisten virtual. Ada yang bisa saya bantu?',
        finishReason: FinishReason::Stop,
        toolCalls: [],
        toolResults: [],
        usage: new Usage(10, 20),
        meta: new Meta(
            id: 'test-completion-id',
            model: 'MiniMax-M2.7-highspeed',
        ),
        messages: collect([]),
        additionalContent: [],
    );

    Prism::fake([$fakeResponse]);
});

test('welcome page renders with chatbot', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Chatbot AI');
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
    $response->assertHeader('Content-Type', 'text/event-stream');
});

test('chatbot endpoints reject short questions', function () {
    $this->post('/chatbot/ask', ['question' => 'hi'])
        ->assertStatus(302);

    $this->post('/chatbot/stream', ['question' => 'hi'])
        ->assertStatus(302);
});
