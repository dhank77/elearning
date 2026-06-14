<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('categories.index');
        }

        if ($user->role === 'teacher') {
            $courses = $user->courses()->withCount('modules')->orderByDesc('created_at')->get();
            $activeCoursesCount = $user->courses()->where('status', 'published')->count();
            $totalStudentsCount = User::where('role', 'student')->count();
            $pendingAssignmentsCount = 0;

            return view('teacher-dashboard', compact(
                'courses',
                'activeCoursesCount',
                'totalStudentsCount',
                'pendingAssignmentsCount',
            ));
        }

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

        $recommendedCourses = Course::where('status', 'published')
            ->whereNotIn('id', $enrolledCourses->pluck('id'))
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'enrolledCourses',
            'paidOrders',
            'totalSpent',
            'recommendedCourses',
        ));
    }
}
