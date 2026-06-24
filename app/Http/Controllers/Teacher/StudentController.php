<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of students enrolled.
     */
    public function index(Request $request): View
    {
        $teacher = $request->user();

        $students = User::whereHas('courseOrders', function ($query) use ($teacher) {
            $query->where('status', 'paid')
                ->whereIn('course_id', $teacher->courses()->pluck('id'));
        })
            ->with(['courseOrders' => function ($query) use ($teacher) {
                $query->where('status', 'paid')
                    ->whereIn('course_id', $teacher->courses()->pluck('id'))
                    ->with('course');
            }])
            ->orderBy('name')
            ->get();

        return view('teacher.students', compact('students'));
    }
}
