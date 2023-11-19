<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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

        // These Codes Hashed Becaus Case Changed.
        // if (!$user) {
        //     return redirect()->route('login');
        // }

        // if (!in_array($user->type, $types)) {
        //     return redirect()->route('home');
        // }

        if ($user) {
            if ($user->hasAnyRole(['owner', 'super-admin', 'admin', 'editor'])) {
                return redirect()->route('dashboard');
            }
        }
        return $next($request);
    }
}
