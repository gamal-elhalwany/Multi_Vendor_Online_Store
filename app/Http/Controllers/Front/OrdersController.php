<?php

namespace App\Http\Controllers\Front;

use App\Models\Order;
use App\Models\OrderItem;
use App\Events\OrderCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use App\Repositories\Cart\CartRepository;

class OrdersController extends Controller
{
    public function create(CartRepository $cart, Order $order)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }

        $authID = auth()->id();
        $order = $order->where('user_id', $authID)->first();
        return view('front.checkout', [
            'cart' => $cart,
            'order' => $order,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cartRepository)
    {
        $request->validate([
            'address.billing.first_name' => ['required', 'string', 'min:3', 'max:255'],
            'address.billing.email' => ['required', 'email'],
            'address.billing.phone_number' => ['required', 'string', 'min:11'],
            'address.billing.street_address' => ['required'],
            'address.billing.city' => ['required', 'string'],
            'address.billing.country' => ['required', 'string', 'min:2'],

            'address.shipping.first_name' => ['required', 'string', 'min:3', 'max:255'],
            'address.shipping.email' => ['required', 'email'],
            'address.shipping.phone_number' => ['required', 'string', 'min:11'],
            'address.shipping.street_address' => ['required'],
            'address.shipping.city' => ['required', 'string'],
            'address.shipping.country' => ['required', 'string', 'min:2'],
        ]);

        $items = $cartRepository->get()->groupBy('product.store_id')->all();

        DB::beginTransaction(); // this function is used for checking if all the insertion processes are good, or if it will stop the whole process and roll back again and this is used when you try to make multiple insertions at various tables.
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $cartRepository->total(0),
                'payment_status' => 'pending',
                'payment_method' => 'cod',
            ]);

            foreach ($items as $store_id => $cart_items) {
                //this foreach is for every single item of the cart.
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price * $item->quantity,
                        'quantity' => $item->quantity,
                        'store_id' => $store_id,
                    ]);
                } // end foreach

                foreach ($request->post('address') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }

            // This condition is for updating the items's prices if there is a discount coupon.
            if (session('coupon_code')) {
                $coupon_code = session('coupon_code');
                if ($coupon_code->type === 'percent') {
                    foreach ($order->orderItems as $item) {
                        $item->price = $item->price - $item->price * $coupon_code->discount_amount / 100;
                        $item->save();
                    }
                } elseif (session('coupon_code')) {
                    if ($coupon_code->type === 'fixed') {
                        foreach ($order->orderItems as $item) {
                            $item->price = $item->price - $coupon_code->discount_amount;
                            $item->save();
                        }
                    }
                }
            }

            event(new OrderCreated($order));

            DB::commit(); // this function is used for making this function works:startTransaction().

        } catch (\Throwable $e) {
            DB::rollBack(); // this function is used for making the whole process rollback if there is an error.
            throw $e;
        }

        if ($request->input('action') === 'cod') {
            if (session('coupon_code')) {
                session()->forget('coupon_code');
            }
            return redirect()->route('home')->with('success', 'Your Order has Successfully Created. thanks for using our app.');
        } else {
            $authID = auth()->id();
            if ($authID == $order->user_id) {
                return redirect()->route('paypal.create', $order->id);
            }
            return redirect('/')->with('error', 'You are not allow to this action!');
        }
    }

    public function user_orders($username)
    {
        $user = auth()->user();
        if ($user && $user->name === $username) {
            $orders = Order::where('user_id', $user->id)->get();
            return view('front.orders', [
                'orders' => $orders,
            ]);
        } else {
            abort(404);
        }
    }
}