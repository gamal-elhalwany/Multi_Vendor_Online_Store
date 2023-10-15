<?php

namespace App\Http\Middleware;

use App\Models\User as ModelsUser;
use Carbon\Carbon;
use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastAciveAt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user instanceof ModelsUser) {
            $user->forceFill([
                'last_active_at' => Carbon::now(),
            ])->save();
        }
        return $next($request);
    }
}
