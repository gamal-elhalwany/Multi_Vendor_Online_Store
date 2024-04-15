<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Carbon\Carbon;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CartRepository $cart)
    {
        $user = auth()->user();
        //Comment:- By using this variable $cart you use the services container.
        $carts = $cart->get();
        if ($user) {
            if ($user->carts->count()) {
                return view('front.cart', compact('carts'));
            }
            return redirect('/');
        }
        return redirect()->route('login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        //Comment:- By using this variable $cart you are using the services container.
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1',
        ]);

        $product = Product::findOrFail($request->post('product_id'));

        $cart->add($product, $request->post('quantity'));
        return redirect()->route('cart.index')->with('success', 'Product added to the Cart!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart)
    {
        //Comment:- By using this variable $cart you are using the services container.
        // $request->validate([
        //     'product_id' => 'required|int|exists:products,id',
        //     'quantity' => 'required|int|min:1',
        // ]);

        $product = Product::findOrFail($request->post('product_id'));
        $quantity = $request->post('quantity');

        $cart->update($product, $quantity);
        if ($request->expectsJson()) {
            return [
                'message' => 'Quantity updated successfully!',
            ];
        }
        return redirect()->back()->with('success', "The quantity of {$product->name} has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CartRepository $cart, string $id)
    {
        //Comment:- The ajax method is responsible for hitting the php or laravel method that does the action but without reloading page.
        $cart->delete($id);
        if ($request->expectsJson()) {
            return [
                'message' => 'item deleted!',
            ];
        }
        return redirect()->route('cart.index')->with('success', 'Cart Deleted Successfully!');
    }

    public function applyCoupon(Request $request)
    {
        $now = Carbon::now();
        $coupon_code = Coupon::where('code', $request->coupon_code)->first();
        if (!$coupon_code || $coupon_code == null) {
            return ['message' => 'Invalid coupon code!'];
        }

        if ($coupon_code->start_at != "") {
            $startDate = Carbon::createFromFormat("Y-m-d H:i:s", $coupon_code->start_at);
            if ($now->lt($startDate)) {
                return  ['message' => 'This coupon is not active yet!.'];
            }
        }

        if ($coupon_code->end_at != "") {
            $endDate = Carbon::createFromFormat("Y-m-d H:i:s", $coupon_code->end_at);
            if ($now->gt($endDate)) {
                return  ['message' => 'This coupon is not valid anymore!.'];
            }
        }

        session()->put('coupon_code', $coupon_code);

        if (session()->has('coupon_code')) {
            if ($request->expectsJson()) {
                return [
                    'message' => 'Coupon applied successfully!',
                    'coupon_code' => session()->get('coupon_code'),
                ];
            }
            return redirect()->route('cart.index')->with('success', 'Coupon applied successfully!');
        }
        return ['message' => 'There is no Coupon been found for the user!'];
    }
}
