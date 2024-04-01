<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
            return view('dashboard.index');
        } else {
            return redirect()->route('home');
        }
    }
}