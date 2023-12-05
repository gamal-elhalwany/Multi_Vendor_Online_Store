<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

// The Main Controller of Payment That I'm using.
class PayPalController extends Controller
{
    public function create(Order $order)
    {
        $authID = auth()->id();
        $totalPrice = 0;
        if ($authID) {
            $orders = Order::where('user_id', '=', $authID)->get();
            foreach ($orders as $order) {
                $orderTotalPrice = OrderItem::where('order_id', '=', $order->id)->sum('price');
                $totalPrice += $orderTotalPrice;
            }
        }

        if (auth()->id() == $order->user_id) {
            if ($order->payment_status == 'paid') {
                // abort(404);
                return $order->payments;
            }

            $client = app('paypal.client');

            $baseCurrency = config('app.currency', 'EUR');
            $userCurrency = Session::get('currency_code', $baseCurrency);
            $intValue = intval($totalPrice);

            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => $order->id,
                    "amount" => [
                        "value" => $intValue,
                        "currency_code" => $userCurrency,
                    ]
                ]],
                "application_context" => [
                    "cancel_url" => url(route('paypal.cancel', $order->id)),
                    "return_url" => url(route('paypal.return', $order->id))
                ]
            ];

            try {
                $response = $client->execute($request);

                if ($response->statusCode == 201) {
                    foreach ($response->result->links as $link) {
                        if ($link->rel == 'approve') {
                            return redirect()->away($link->href);
                        }
                    }
                }
            } catch (HttpException $ex) {

                $order->payment_status = 'failed';
                $order->save();
                return redirect('/')->with('error', 'Payment Cancelled!');
            }
        }
        return redirect()->route('home')->with('error', 'You are not allow for this action!');
    }

    public function callback(Request $request, Order $order)
    {
        // To make this method work right as you wish you have to create a custom accounts on PayPal Developer tool and not use the Default apps {personal or business} apps.

        if ($order->payment_status == 'paid') {
            // abort(404);
            return $order->payments;
        }

        $token = $request->query('token');
        if (!$token) {
            abort(404, 'Payment not found!');
        }

        $client = app('paypal.client');
        $request = new OrdersCaptureRequest($token);
        $request->prefer('return=representation');

        try {
            $response = $client->execute($request);
            if ($response->statusCode == 201 && $response->result->status == 'COMPLETED') {
                $order->payment_status = 'paid';
                $order->payment_method = 'PayPal';
                $order->status = 'pending';
                $order->save();

                $order->payments()->create([
                    'amount' => $response->result->purchase_units[0]->amount->value,
                    'payload' => $response->result,
                    'method' => 'PayPal',
                ]);

                return redirect('/')->with('success', 'Your Payment Operation Done Successfully. We will Proceed with your order very soon.');
            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            dd($ex->getMessage());
        }
    }

    public function cancel(Order $order)
    {
        $order->payment_status = 'failed';
        $order->status = 'canceled';
        $order->save();
        return redirect('/')->with('error', 'Payment Cancelled!');
    }
}
