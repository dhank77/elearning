<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class CourseSettingsController extends Controller
{
    public function __invoke(): View
    {
        return view('teacher.course-settings');
    }
}
