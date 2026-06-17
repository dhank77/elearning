<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseOrder;
use App\Services\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseOrderController extends Controller
{
    public function __construct(protected XenditService $xenditService) {}

    public function store(Request $request, Course $course)
    {
        $request->validate([
            'payment_method' => 'required|in:manual_transfer,xendit',
        ]);

        if ($course->status !== 'published') {
            abort(404, 'Course not available for purchase.');
        }

        $existingOrder = CourseOrder::query()
            ->where('user_id', $request->user()->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingOrder) {
            if ($existingOrder->status === 'paid') {
                return redirect()->route('dashboard')
                    ->with('info', 'You are already enrolled in this course.');
            }

            return redirect()->route('checkout.pay', $existingOrder);
        }

        $order = CourseOrder::create([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
            'order_number' => $this->generateOrderNumber(),
            'amount' => $course->price,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('checkout.pay', $order);
    }

    public function pay(CourseOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'paid') {
            return redirect()->route('dashboard')
                ->with('info', 'This course is already paid.');
        }

        if ($order->payment_method === 'xendit' && ! $order->xendit_invoice_id) {
            $invoiceData = $this->xenditService->createInvoice($order);

            $order->update([
                'xendit_invoice_id' => $invoiceData['invoice_id'],
                'xendit_payment_url' => $invoiceData['invoice_url'],
            ]);
        }

        if ($order->payment_method === 'xendit' && $order->xendit_payment_url) {
            return redirect($order->xendit_payment_url);
        }

        return view('checkout.pay', compact('order'));
    }

    public function success(Request $request, CourseOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status === 'paid') {
            return redirect()->route('dashboard')
                ->with('success', 'Payment confirmed! The course has been added to "My Courses".');
        }

        if ($order->payment_method === 'xendit') {
            return redirect()->route('checkout.pay', $order)
                ->with('info', 'Your payment is being processed. Please wait for confirmation.');
        }

        return redirect()->route('dashboard')
            ->with('info', 'Your order is still pending. Please complete your payment.');
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-'.strtoupper(Str::random(8));
    }
}
