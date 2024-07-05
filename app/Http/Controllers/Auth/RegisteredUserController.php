<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Store;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Symfony\Component\Intl\Countries;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'size:11', 'unique:users'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function merchant_create(): View
    {
        $countries = Countries::getNames();
        return view('auth.register-merchant', compact('countries'));
    }

    public function merchant_store(Request $request)
    {
        // dd($request->logo_image);
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'size:11', 'unique:users'],
            'first_name' => 'required|string|min:3|max:255',
            'last_name' => ['required', 'string', 'min:3', 'max:255'],
            'birth_day' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:male,female'],
            'street_address' => ['required', 'string', 'min:3', 'max:255'],
            'city' => ['required', 'string', 'min:3', 'max:255'],
            'state' => ['required', 'string', 'min:3', 'max:255'],
            'country' => ['required', 'string', 'min:3', 'max:255'],
            'postal_code' => ['required', 'numeric', 'digits_between:3,10'],
            'store_name' => 'required|string|min:5|max:255, unique:stores,name',
            'description' => 'required|string|min:100',
            'logo_image' => 'required|mimes:jpg,jpeg,png,webp',
        ]);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'birth_day' => $request->birth_day,
                'gender' => $request->gender,
                'street_address' => $request->street_address,
                'city' => $request->city,
                'state' => $request->state,
                'postal_code' => $request->postal_code,
                'country' => $request->country,
            ]);

            if ($request->file('logo_image')) {
                $logo_file = $request->logo_image;
                $logo_path = $logo_file->store('uploads/stores', 'public');
            } else {
                $logo_path = null;
            }

            if ($request->hasFile('cover_image')) {
                $cover_file = $request->file('cover_image');
                $cover_path = $cover_file->store('uploads/stores', 'public');
            } else {
                $cover_path = null;
            }

            $store = Store::create([
                'user_id' => $user->id,
                'name' => $request->store_name,
                'description' => $request->description,
                'logo_image' => $logo_path,
                'cover_image' => $cover_path,
            ]);
            Auth::login($user);
            DB::commit();

            return redirect()->route('home')->with('susccess', 'You have regitered and your store is created successfully. your account will be active within a couple of days. thanks for resgistering with us ♥');

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
