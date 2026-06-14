<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentCourseController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $enrolledCourses = $user->enrolledCourses()
            ->with(['teacher', 'modules'])
            ->withCount('modules')
            ->orderByDesc('course_orders.paid_at')
            ->get();

        $paidOrders = $user->courseOrders()
            ->where('status', 'paid')
            ->with('course')
            ->orderByDesc('paid_at')
            ->get();

        $totalSpent = $paidOrders->sum('amount');

        return view('student.my-courses', compact(
            'enrolledCourses',
            'paidOrders',
            'totalSpent',
        ));
    }
}
