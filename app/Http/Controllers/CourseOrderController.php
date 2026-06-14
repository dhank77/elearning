<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseOrderController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'payment_method' => 'required|in:manual_transfer',
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

        return view('checkout.pay', compact('order'));
    }

    public function complete(Request $request, CourseOrder $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            abort(400, 'Order is not pending.');
        }

        $order->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Payment successful! The course has been added to "My Courses".');
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-'.strtoupper(Str::random(8));
    }
}
