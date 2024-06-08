<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function index(Request $request, $username)
    {
        $user = auth()->user();
        if ($user && $user->name == $username) {
            $wishlists = $user->wishlist;
            if ($wishlists->count()) {
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
        if ($user->name === $username) {
            if ($user->wishlist()->where('product_id', $request->product_id)->exists()) {
                return redirect()->back()->with('error', 'Product already exists in wishlist!');
            } else {
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                ]);
                return redirect()->back()->with('success', 'Product added to the wishlist!');
            }
        }
        return redirect()->route('home')->with('error', 'You are not Allowed to this action.');
    }

    public function update(Request $request, $username, Wishlist $wishlist)
    {
        $user = auth()->user();
        if ($user->name === $username) {
            if ($request->post('wishlist-qty')) {
                if ($user->carts()->where('product_id', $wishlist->product->id)->exists()) {
                    $cart = $user->carts()->where(
                        'product_id',
                        $wishlist->product->id
                    )->first();
                    $cart->quantity = $request->post('wishlist-qty') + $cart->quantity;
                    $cart->save();
                    $wishlist->delete();
                } else {
                    Cart::create([
                        'cookie_id' => Str::uuid(),
                        'user_id' => $user->id,
                        'product_id' => $wishlist->product_id,
                        'quantity' => $request->post('wishlist-qty'),
                    ]);
                    $wishlist->delete();
                }
                return redirect()->back()->with('success', 'Product added to the cart successfully!');
            }
            abort(404);
        }
        return redirect()->route('home')->with('error', 'You\'re not allowed to this action!');
    }

    public function destroy(Wishlist $wishlist)
    {
        $authUser = auth()->user();
        if ($authUser && $authUser->id == $wishlist->user_id) {
            $wishlist->delete();
            return ['message' => 'Wishlist item removed Sucessfully!'];
        }
        return redirect()->route('login');
    }
}
