<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CouponController extends Controller
{
    public function index(Request $request): View
    {
        $coupons = Coupon::whereHas('courses', function ($query) use ($request) {
            $query->where('teacher_id', $request->user()->id);
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('coupons.index', compact('coupons'));
    }

    public function create(Request $request): View
    {
        $courses = $request->user()->courses()->orderBy('title')->get();

        return view('coupons.create', compact('courses'));
    }

    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $coupon = Coupon::create($request->validated());

        $course = $request->user()->courses()->findOrFail($request->validated('course_id'));
        $course->update(['coupon_id' => $coupon->id]);

        return redirect()->route('teacher.coupons.index')->with('success', 'Kupon berhasil ditambahkan.');
    }

    public function edit(Request $request, Coupon $coupon): View
    {
        abort_unless($coupon->courses()->where('teacher_id', $request->user()->id)->exists(), 403);

        $courses = $request->user()->courses()->orderBy('title')->get();

        return view('coupons.edit', compact('coupon', 'courses'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        abort_unless($coupon->courses()->where('teacher_id', $request->user()->id)->exists(), 403);

        $coupon->update($request->validated());

        // Remove association from other courses of this teacher
        $request->user()->courses()->where('coupon_id', $coupon->id)->update(['coupon_id' => null]);

        // Associate with the selected course
        $course = $request->user()->courses()->findOrFail($request->validated('course_id'));
        $course->update(['coupon_id' => $coupon->id]);

        return redirect()->route('teacher.coupons.index')->with('success', 'Kupon berhasil diperbarui.');
    }

    public function destroy(Request $request, Coupon $coupon): RedirectResponse
    {
        abort_unless($coupon->courses()->where('teacher_id', $request->user()->id)->exists(), 403);

        // Remove coupon_id from courses
        $coupon->courses()->update(['coupon_id' => null]);

        $coupon->delete();

        return redirect()->route('teacher.coupons.index')->with('success', 'Kupon berhasil dihapus.');
    }
}
