<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Currency;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
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
        $total = $cart->total($quantity = 1);
        $user = auth()->user();
        //Comment:- By using this variable $cart you use the services container.
        $carts = $cart->get();
        if ($user) {
            if ($user->carts->count()) {
                return view('front.cart', compact('carts', 'total'));
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
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'required|int|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->post('quantity');

        $price = $quantity * $product->price;
        $cart->update($product, $quantity, $price);
        if ($request->expectsJson()) {
            return [
                'message' => 'Quantity updated successfully!',
                'product_id' => $product->id,
                'quantity' => $quantity,
            ];
        }
        return redirect()->back()->with('success', "The quantity of {$product->name} has been updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, CartRepository $cart, string $id)
    {
        $cart->delete($id);
        if ($request->expectsJson()) {
            return [
                'message' => 'item deleted!',
            ];
        }
        return redirect()->route('cart.index')->with('success', 'Cart Deleted Successfully!');
    }

    public function applyCoupon(Request $request, CartRepository $cart)
    {
        $now = Carbon::now();
        $coupon_code = Coupon::where('code', $request->coupon_code)->first();
        $total = $cart->total($quantity = 1);

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

        if ($coupon_code) {
            if ($coupon_code->type == 'fixed') {
                $currencyFormat = Currency::format($coupon_code->discount_amount);
                session()->put('fixed_amount', $currencyFormat);

                $fixedTotalPay = Currency::format($total - $coupon_code->discount_amount);
                $fixedTotalSave = Currency::format(($total) - ($total - $coupon_code->discount_amount));

                return response()->json([
                    'status' => true,
                    'message' => 'Coupon applied successfully. this message by Ajax!',
                    'coupon_code' => session()->get('coupon_code'),
                    'currencyFormat' => $currencyFormat,
                    'total' => $total,
                    'fixedTotalSave' => $fixedTotalSave,
                    'fixedTotalPay' => $fixedTotalPay,
                ]);
            } elseif ($coupon_code->type == 'percent') {
                session()->put('percent_amount', $coupon_code->discount_amount);

                $percentTotalSave = Currency::format(($total * $coupon_code->discount_amount) / 100);
                $percentTotalPay = Currency::format(($total) - ($total * $coupon_code->discount_amount) / 100);

                return response()->json([
                    'status' => true,
                    'message' => 'Coupon applied successfully. this message by Ajax!',
                    'coupon_code' => session()->get('coupon_code'),
                    'percent_amount' => $coupon_code->discount_amount,
                    'total' => $total,
                    'percentTotalSave' => $percentTotalSave,
                    'percentTotalPay' => $percentTotalPay,
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'Coupon applied successfully. this message by Ajax!',
                    'coupon_code' => session()->get('coupon_code'),
                    'total' => $total,
                ]);
            }
        }
        return ['message' => 'There is no Coupon been found. Please apply the right coupon code!'];
    }
}