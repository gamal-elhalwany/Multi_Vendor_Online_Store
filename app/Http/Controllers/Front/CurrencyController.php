<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function exchange_currency(Request $request)
    {
        $currency_code = $request->input('currency_code');
        $baseCurrencyCode = config('app.currency');

        $cacheKey = 'currency_rate_' . $currency_code;
        $rate = Cache::get($cacheKey, 0);

        if (!$rate) {
            $converter = new CurrencyConverter(config('services.currency_converter_api_key.api_key'));

            $rate = $converter->convert($baseCurrencyCode, $currency_code);

            Cache::put($cacheKey, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currency_code);

        return redirect()->back();
    }
}
