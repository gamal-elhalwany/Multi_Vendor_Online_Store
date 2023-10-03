<?php

namespace App\Http\Controllers\Front;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class OrdersController extends Controller
{
    public function create (CartRepository $cart) {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames(),
        ]);
    }

    public function store (Request $request, CartRepository $cart) {
        $request->validate([

        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        DB::beginTransaction(); // this function is used for checking if all the insertion processes are good, or if it will stop the whole process and roll back again and this is used when you try to make multiple insertions at various tables.
        try {
            foreach ($items as $store_id => $cart_items)
            {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'cod',
                ]);

                //this foreach is for every single item of the cart.
                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                } // end foreach

                foreach ($request->post('address') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }
            }

            event(new OrderCreated());

            DB::commit(); // this function is used for making this function works:startTransaction().

        } catch (\Throwable $e) {
            DB::rollBack(); // this function is used for making the whole process rollback if there is an error.
            throw $e;
        }
        return redirect()->route('home');
    }
} // end of class.
