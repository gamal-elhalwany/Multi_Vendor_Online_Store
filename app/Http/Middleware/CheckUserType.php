<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$types): Response
    {
        $user = $request->user();

        // These Codes Hashed Becaus We Used the Spatie Permissions Instead of Multi guards.
        // if (!$user) {
        //     return redirect()->route('login');
        // }

        // if (!in_array($user->type, $types)) {
        //     return redirect()->route('home');
        // }

        // if ($user && $user->hasAnyRole('Owner', 'Super-admin', 'Admin', 'Editor')) {
        //     return redirect()->route('dashboard');
        // }
        // return $next($request);
    }
}
