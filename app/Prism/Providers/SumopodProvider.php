<?php

namespace App\Prism\Providers;

use Generator;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response as ClientResponse;
use Prism\Prism\Concerns\InitializesClient;
use Prism\Prism\Enums\FinishReason;
use Prism\Prism\Exceptions\PrismRateLimitedException;
use Prism\Prism\Exceptions\PrismRequestTooLargeException;
use Prism\Prism\Exceptions\PrismStreamDecodeException;
use Prism\Prism\Providers\Provider;
use Prism\Prism\Streaming\EventID;
use Prism\Prism\Streaming\Events\StepFinishEvent;
use Prism\Prism\Streaming\Events\StepStartEvent;
use Prism\Prism\Streaming\Events\StreamEndEvent;
use Prism\Prism\Streaming\Events\StreamStartEvent;
use Prism\Prism\Streaming\Events\TextCompleteEvent;
use Prism\Prism\Streaming\Events\TextDeltaEvent;
use Prism\Prism\Streaming\Events\TextStartEvent;
use Prism\Prism\Text\Request as TextRequest;
use Prism\Prism\Text\Response as TextResponse;
use Prism\Prism\Text\Step;
use Prism\Prism\ValueObjects\Messages\AssistantMessage;
use Prism\Prism\ValueObjects\Messages\SystemMessage;
use Prism\Prism\ValueObjects\Meta;
use Prism\Prism\ValueObjects\ProviderRateLimit;
use Prism\Prism\ValueObjects\Usage;

class SumopodProvider extends Provider
{
    use InitializesClient;

    public function __construct(
        public readonly string $apiKey,
        public readonly string $url,
    ) {}

    public function text(TextRequest $request): TextResponse
    {
        $client = $this->client($request->clientOptions(), $request->clientRetry());

        $payload = [
            'model' => $request->model(),
            'messages' => $this->buildMessages($request),
        ];

        if ($request->maxTokens() !== null) {
            $payload['max_tokens'] = $request->maxTokens();
        }

        if ($request->temperature() !== null) {
            $payload['temperature'] = $request->temperature();
        }

        if ($request->topP() !== null) {
            $payload['top_p'] = $request->topP();
        }

        $response = $client->post('chat/completions', $payload);

        $data = $response->json();
        $content = data_get($data, 'choices.0.message.content', '');

        $usage = new Usage(
            promptTokens: data_get($data, 'usage.prompt_tokens', 0),
            completionTokens: data_get($data, 'usage.completion_tokens', 0),
            cacheReadInputTokens: null,
            thoughtTokens: null,
        );

        $meta = new Meta(
            id: data_get($data, 'id'),
            model: data_get($data, 'model'),
            rateLimits: $this->processRateLimits($response),
            serviceTier: null,
        );

        $step = new Step(
            text: $content,
            finishReason: FinishReason::Stop,
            toolCalls: [],
            toolResults: [],
            providerToolCalls: [],
            usage: $usage,
            meta: $meta,
            messages: $request->messages(),
            systemPrompts: $request->systemPrompts(),
            additionalContent: [],
            raw: $data,
        );

        return new TextResponse(
            steps: collect([$step]),
            text: $content,
            finishReason: FinishReason::Stop,
            toolCalls: [],
            toolResults: [],
            usage: $usage,
            meta: $meta,
            messages: collect($request->messages()),
            additionalContent: [],
            raw: $data,
        );
    }

    public function stream(TextRequest $request): Generator
    {
        $client = $this->client($request->clientOptions(), $request->clientRetry());

        $payload = [
            'model' => $request->model(),
            'messages' => $this->buildMessages($request),
            'stream' => true,
        ];

        if ($request->maxTokens() !== null) {
            $payload['max_tokens'] = $request->maxTokens();
        }

        if ($request->temperature() !== null) {
            $payload['temperature'] = $request->temperature();
        }

        if ($request->topP() !== null) {
            $payload['top_p'] = $request->topP();
        }

        $response = $client->withOptions(['stream' => true])->post('chat/completions', $payload);

        $this->handleRequestException($request->model(), $response);

        $messageId = EventID::generate();
        $model = $request->model();

        yield new StreamStartEvent(
            id: EventID::generate(),
            timestamp: time(),
            model: $model,
            provider: 'sumopod',
        );

        yield new StepStartEvent(
            id: EventID::generate(),
            timestamp: time(),
        );

        yield new TextStartEvent(
            id: EventID::generate(),
            timestamp: time(),
            messageId: $messageId,
        );

        $fullText = '';
        $usage = new Usage(0, 0);

        while (! $response->getBody()->eof()) {
            $line = $this->readLine($response->getBody());

            if (! str_starts_with($line, 'data: ')) {
                continue;
            }

            $data = trim(substr($line, 6));

            if ($data === '[DONE]') {
                break;
            }

            try {
                $parsed = json_decode($data, true, flags: JSON_THROW_ON_ERROR);
            } catch (\Throwable $e) {
                throw new PrismStreamDecodeException('Sumopod', $e);
            }

            $delta = data_get($parsed, 'choices.0.delta.content', '');

            if ($delta !== null && $delta !== '') {
                $fullText .= $delta;

                yield new TextDeltaEvent(
                    id: EventID::generate(),
                    timestamp: time(),
                    delta: $delta,
                    messageId: $messageId,
                );
            }

            if (data_get($parsed, 'choices.0.finish_reason') === 'stop') {
                $usage = new Usage(
                    promptTokens: data_get($parsed, 'usage.prompt_tokens', 0),
                    completionTokens: data_get($parsed, 'usage.completion_tokens', 0),
                    cacheReadInputTokens: null,
                    thoughtTokens: null,
                );
            }
        }

        yield new TextCompleteEvent(
            id: EventID::generate(),
            timestamp: time(),
            messageId: $messageId,
        );

        yield new StepFinishEvent(
            id: EventID::generate(),
            timestamp: time(),
        );

        yield new StreamEndEvent(
            id: EventID::generate(),
            timestamp: time(),
            finishReason: FinishReason::Stop,
            usage: $usage,
            additionalContent: [],
        );
    }

    protected function buildMessages(TextRequest $request): array
    {
        $messages = [];

        foreach ($request->systemPrompts() as $systemPrompt) {
            $messages[] = ['role' => 'system', 'content' => $systemPrompt->content];
        }

        foreach ($request->messages() as $message) {
            if ($message instanceof SystemMessage) {
                $messages[] = ['role' => 'system', 'content' => $message->content];
            } elseif ($message instanceof AssistantMessage) {
                $messages[] = ['role' => 'assistant', 'content' => $message->content];
            } else {
                $messages[] = ['role' => 'user', 'content' => $message->text() ?? ''];
            }
        }

        return $messages;
    }

    protected function client(array $options = [], array $retry = []): PendingRequest
    {
        return $this->baseClient()
            ->withHeader('Authorization', 'Bearer '.$this->apiKey)
            ->withOptions($options)
            ->when($retry !== [], fn ($client) => $client->retry(...$retry))
            ->baseUrl($this->url);
    }

    /** @return ProviderRateLimit[] */
    protected function processRateLimits(ClientResponse $response): array
    {
        return [];
    }

    public function handleRequestException(string $model, RequestException $e): never
    {
        match ($e->response->getStatusCode()) {
            429 => throw new PrismRateLimitedException([]),
            413 => throw PrismRequestTooLargeException::make('Sumopod'),
            default => parent::handleRequestException($model, $e),
        };
    }

    protected function readLine($stream): string
    {
        $buffer = '';

        while (! $stream->eof()) {
            $byte = $stream->read(1);

            if ($byte === '') {
                return $buffer;
            }

            $buffer .= $byte;

            if ($byte === "\n") {
                break;
            }
        }

        return $buffer;
    }
}
