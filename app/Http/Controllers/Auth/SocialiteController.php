<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
class SocialiteController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();
            $user = User::where([
                'provider' => $provider,
                'provider_id' => $provider_user->id,
            ])->first();

            if (!$user) {
                $createdUser = User::firstOrCreate([
                    'name' => $provider_user->name,
                    'email' => $provider_user->email,
                    'password' => Hash::make(Str::random(8)),
                    'phone_number' => 'null',
                    'provider' => $provider,
                    'provider_id' => $provider_user->id,
                    'provider_token' => $provider_user->token,
                ]);
                Auth::login($createdUser);
                return redirect()->route('home');
            }

            Auth::login($user);
            return redirect()->route('home');

        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Something goes wrong check it and try again!');
        }
    }
}
