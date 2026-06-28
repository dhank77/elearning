<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Course;

class WelcomeController extends Controller
{
    public function index()
    {
        $courses = Course::query()
            ->where('status', 'published')
            ->with('teacher')
            ->latest()
            ->paginate(12);

        return view('welcome', compact('courses'));
    }

    public function show(Course $course)
    {
        if ($course->status !== 'published') {
            abort(404);
        }

        $course->load(['teacher', 'modules.lessons']);

        $promoCode = request()->query('promo');
        $appliedCoupon = null;
        if ($promoCode) {
            $coupon = Coupon::where('code', $promoCode)
                ->where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')->orWhere('expires_at', '>', now());
                })
                ->first();
            if ($coupon && $course->coupon_id === $coupon->id) {
                $appliedCoupon = $coupon;
            }
        }

        return view('courses.show', compact('course', 'appliedCoupon'));
    }
}
