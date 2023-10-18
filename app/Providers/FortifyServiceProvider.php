<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Here I told it that if it found a route that begins with the keyword (admin) to start using the guard admin and check its credentials.
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
            Config::set('fortify.home', 'admin/dashboard');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // This is how you can define which views will the Fortify package be used for the authentication process.
        Fortify::viewPrefix('auth.');

        // if (Config::get('fortify.guard') == 'admin') {
        //     Fortify::viewPrefix('auth.');
        // } else {
        //     Fortify::viewPrefix('front.');
        // }

        if (Config::get('fortify.guard') == 'admin') {
            Fortify::authenticateUsing([new AuthenticateUser, 'authenticateAdmin']);
            Fortify::loginView('auth.login');
        } else {
            Fortify::authenticateUsing([new AuthenticateUser, 'authenticateNormalUser']);
            Fortify::loginView('auth.custom-login');
        }

    }
}
