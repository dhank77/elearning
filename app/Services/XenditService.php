<?php

namespace App\Services;

use App\Models\CourseOrder;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\CustomerObject;

class XenditService
{
    public function __construct()
    {
        Configuration::setXenditKey(config('services.xendit.api_key'));
    }

    public function createInvoice(CourseOrder $order): array
    {
        $user = $order->user;
        $course = $order->course;

        $customer = new CustomerObject([
            'given_names' => $user->name,
            'email' => $user->email,
        ]);

        $createInvoiceRequest = new CreateInvoiceRequest([
            'external_id' => $order->order_number,
            'amount' => (float) $order->amount,
            'description' => "Payment for course: {$course->title}",
            'currency' => 'IDR',
            'invoice_duration' => 86400,
            'should_send_email' => true,
            'success_redirect_url' => route('checkout.success', $order),
            'failure_redirect_url' => route('checkout.pay', $order),
            'customer' => $customer,
            'metadata' => [
                'order_id' => $order->id,
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
        ]);

        $apiInstance = new InvoiceApi();
        $invoice = $apiInstance->createInvoice($createInvoiceRequest);

        return [
            'invoice_id' => $invoice->getId(),
            'invoice_url' => $invoice->getInvoiceUrl(),
        ];
    }

    public function verifyWebhookSignature(string $payload, string $signature): bool
    {
        $expectedSignature = hash_hmac('sha256', $payload, config('services.xendit.webhook_token'));

        return hash_equals($expectedSignature, $signature);
    }
}
