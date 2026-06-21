<?php

namespace App\Services;

class FonnteService
{
    protected string $token;

    public function __construct()
    {
        $this->token = config('services.fonnte.token') ?? '';
    }

    /**
     * Send WhatsApp message using Fonnte API.
     */
    public function sendMessage(string $target, string $message): bool
    {
        if (empty($this->token)) {
            \Illuminate\Support\Facades\Log::warning('Fonnte token is not configured.');
            return false;
        }

        if (empty($target)) {
            \Illuminate\Support\Facades\Log::warning('Fonnte target number is empty.');
            return false;
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => $this->token,
            ])->asForm()->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
            ]);

            if ($response->successful()) {
                \Illuminate\Support\Facades\Log::info('WhatsApp message sent successfully via Fonnte.', [
                    'target' => $target,
                    'response' => $response->json(),
                ]);
                return true;
            }

            \Illuminate\Support\Facades\Log::error('Fonnte API failed to send WhatsApp message.', [
                'target' => $target,
                'status' => $response->status(),
                'response' => $response->body(),
            ]);
            return false;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Fonnte API connection error.', [
                'target' => $target,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
