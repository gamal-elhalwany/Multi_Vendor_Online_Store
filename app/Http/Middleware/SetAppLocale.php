<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class SetAppLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // this middleware use only when native localization without any packages.
        $locale = request('locale', Cookie::get('locale', config('app.locale')));
        \App::setLocale($locale);
        Cookie::queue(Cookie::make('locale', $locale, 60 * 60 * 24 * 365));

        // This for forgetting this parameter.
        Route::current()->forgetParameter('locale');

        // This for giving the routes a default parameter like langs parameters.
        URL::defaults([
            'locale' => $locale,
        ]);

        return $next($request);
    }
}
