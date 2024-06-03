<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index(Request $request, $username)
    {
        $user = auth()->user();
        if ($user && $user->name == $username) {
            $wishlists = $user->wishlist;
            if ($wishlists) {
                foreach ($wishlists as $item) {
                    dd($item);
                }
                return view('front.user.wishlist', compact('wishlists'));
            } else {
                return redirect()->route('home')->with('error', 'You have no products in the wishlist!');
            }
        } else {
            return redirect()->route('login')->with('error', 'Login to continue.');
        }
    }

    public function store(Request $request, $username)
    {
        $user = auth()->user();
        if ($user->name == $username) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $request->product_id,
            ]);
            return redirect()->back()->with('success', 'Product added to the wishlist!');
        } else {
            return redirect()->route('home')->with('error', 'You are not Allowed to this action.');
        }
    }
}