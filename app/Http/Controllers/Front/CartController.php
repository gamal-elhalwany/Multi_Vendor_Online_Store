<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;

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
            return  redirect('/');
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
        return redirect()->back(302)->with('success', "The quantity of {$product->name} has been updated!");
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
}
