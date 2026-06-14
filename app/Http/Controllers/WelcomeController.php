<?php

namespace App\Http\Controllers;

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

        return view('courses.show', compact('course'));
    }
}
