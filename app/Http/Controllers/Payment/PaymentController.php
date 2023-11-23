<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    private $gateway;
    public $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(config('services.paypal.client_id'));
        $this->gateway->setSecret(config('services.paypal.client_secret'));
        $this->gateway->setTestMode(true);
    }

    public function pay()
    {
        try {
            $response = $this->gateway->purchase([
                'amount' => '1000.00',
                'currency' => 'USD',
                'returnUrl' => url('success'),
                'cancelUrl' => url('error'),
            ])->send();

            if ($response->isRedirect()) {
                // redirect to offsite payment gateway
                $response->redirect();
            } else {
                // payment failed: display message to customer
                return $response->getMessage();
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function success(Request $request, Order $order)
    {
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
            if ($response->isSuccessful()) {
                dd($response->isSuccessful());
                $arr = $response->getData();
                // $order->payment_status = 'paid';
                // $order->save();
                // return redirect()->route('home')->with('success', 'Your Payment Operation Done Successfully!');
                return "Payment is Successful. Your Transaction Id is " . $arr['id'];
            } else {
                dd($response->getMessage());
            }
        } else {
            return "Payment is Declined!!";
        }
    }

    public function cancel(Order $order)
    {
        // $order->update([
        //     'payment_status' => 'paid',
        // ]);
        // $order->save();
        return redirect()->route('home')->with('error', 'You have Canceled the Payment Operation!');
    }
}
