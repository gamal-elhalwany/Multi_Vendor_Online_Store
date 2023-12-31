<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:profile-list', ['only' => ['index']]);
        $this->middleware('permission:profile-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:profile-show', ['only' => ['show']]);
        $this->middleware('permission:profile-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:profile-delete', ['only' => ['destroy']]);
    }

    public function edit() {
        $user = Auth::user();
        return view('dashboard.profile.edit', [
            'user' => $user,
            'countries' => Countries::getNames(),
            'languages' => Languages::getNames(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_day' => 'nullable|date|before:now',
            'gender' => 'in:male,female',
            'country' => 'required|string',
        ]);

        $user = $request->user();

        $user->profile->fill($request->all())->save();
        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
