<?php

namespace App\Http\Controllers\Webhook;

use App\Models\CourseOrder;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function __construct(protected XenditService $xenditService)
    {
    }

    public function __invoke(Request $request)
    {
        $callbackToken = $request->header('x-callback-token');

        if (! $this->xenditService->verifyCallback($callbackToken ?? '')) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid callback token',
            ], Response::HTTP_FORBIDDEN);
        }

        $payload = $request->all();
        $externalId = $payload['external_id'] ?? null;
        $status = $payload['status'] ?? null;

        if (!$externalId || $status !== 'SETTLED') {
            return new Response('Ignored', Response::HTTP_OK);
        }

        $order = CourseOrder::query()
            ->where('order_number', $externalId)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return new Response('Order not found or already processed', Response::HTTP_OK);
        }

        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        Log::info('Xendit webhook: Order marked as paid.', [
            'order_number' => $externalId,
            'order_id' => $order->id,
        ]);

        return new Response('Webhook handled', Response::HTTP_OK);
    }
}
