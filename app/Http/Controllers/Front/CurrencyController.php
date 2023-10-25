<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function exchange_currency(Request $request)
    {
        // // set API Endpoint, access key, required parameters
        // $endpoint = 'convert';
        // $access_key = '7875c178d16a4875c7b35a94e7e9e87e';

        // $from = 'USD';
        // $to = 'EGP';
        // $amount = 10;

        // // initialize CURL:
        // $ch = curl_init('https://api.exchangeratesapi.io/v1/' . $endpoint . '?access_key=' . $access_key . '&from=' . $from . '&to=' . $to . '&amount=' . $amount . '');

        // dd($ch);

        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // // get the JSON data:
        // $json = curl_exec($ch);
        // curl_close($ch);

        // // Decode JSON response:
        // $conversionResult = json_decode($json, true);

        // // access the conversion result
        // return $conversionResult['result'];

        $currency_code = $request->input('currency_code');
        Session::put('currency_code', $currency_code);

        $baseCurrencyCode = config('app.currency');

        // $converter = new CurrencyConverter(config('services.currency_converter_api_key.api_key'));

        $apiKey = '7875c178d16a4875c7b35a94e7e9e87e';
        $converter = new CurrencyConverter($apiKey);

        $rate = $converter->convert($baseCurrencyCode, $currency_code);

        return redirect()->back();
    }
}
