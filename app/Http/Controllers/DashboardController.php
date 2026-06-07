<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function index(): RedirectResponse|View
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('categories.index');
        }

        if (auth()->user()->role === 'teacher') {
            return view('teacher-dashboard');
        }

        return view('dashboard');
    }
}
