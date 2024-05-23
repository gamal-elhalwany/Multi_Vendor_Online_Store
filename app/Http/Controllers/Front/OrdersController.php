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
        // $request->validate([
        //     'address.billing.first_name' => ['required', 'string', 'min:3', 'max:255'],
        //     'address.billing.email' => ['required', 'email'],
        //     'address.billing.phone_number' => ['required', 'string', 'min:11'],
        //     'address.billing.city' => ['required'],
        //     'address.billing.country' => ['required'],
        // ]);

        $items = $cartRepository->get()->groupBy('product.store_id')->all();

        DB::beginTransaction(); // this function is used for checking if all the insertion processes are good, or if it will stop the whole process and roll back again and this is used when you try to make multiple insertions at various tables.
        try {
            $action = $request->post('action');
            $payment_method = '';
            $payment_status = '';

            if ($action === 'cod') {
                $payment_method = 'cod';
                $payment_status = 'pending';
            } elseif ($action === 'with_paypal') {
                $payment_method = 'PayPal';
                $payment_status = 'paid';
            } else {
                $payment_method = 'Other';
                $payment_status = 'failed';
            }

            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'total' => $cartRepository->total(0),
                    'payment_status' => $payment_status,
                    'payment_method' => $payment_method,
                ]);

                //this foreach is for every single item of the cart.
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price * $item->quantity,
                        'quantity' => $item->quantity,
                    ]);
                } // end foreach

                foreach ($request->post('address') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }
            event(new OrderCreated($order));

            DB::commit(); // this function is used for making this function works:startTransaction().

        } catch (\Throwable $e) {
            DB::rollBack(); // this function is used for making the whole process rollback if there is an error.
            throw $e;
        }

        if ($request->input('action') === 'cod') {
            return redirect()->route('home')->with('success', 'Your Order has Successfully Created. thanks for using our app.');
        } else {
            $authID = auth()->id();
            if ($authID == $order->user_id) {
                return redirect()->route('paypal.create', $order->id);
            }
            return redirect('/')->with('error', 'You are not allow to this action!');
        }
    }
}