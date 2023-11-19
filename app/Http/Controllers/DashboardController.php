<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index () {
        $user = Auth::user();
        if ($user->hasAnyRole('admin', 'super-admin', 'owner', 'editor')) {
            return view('dashboard.index');
        }
        return redirect()->route('home');
    }
}
