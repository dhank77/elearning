<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudentOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()->courseOrders()
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('student.orders.index', compact('orders'));
    }
}
