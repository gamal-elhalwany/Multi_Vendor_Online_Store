<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

// The Main Controller of Payment That I'm using.
class PayPalController extends Controller
{
    public function create(Order $order)
    {
        $auth_user = auth()->id();
        $userOrders = Order::where('user_id', $auth_user)->first();

        if (auth()->id() == $order->user_id) {
            if ($order->payment_status == 'paid') {
                // abort(404);
                return $order->payments;
            }

            $client = app('paypal.client');

            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => $order->id,
                    "amount" => [
                        "value" => '1000',
                        "currency_code" => "USD"
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

                return redirect('/')->with('success', 'Payment Successfully Done. thanks for using our app ♥');
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
