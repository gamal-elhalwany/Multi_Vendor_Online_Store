<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency
{
    public static function format ($amount, $currency_code = null) {
        $formatter = new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);

        $baseCurrency = config('app.currency', 'EGP');
        if ($currency_code === null) {
            $currency_code = Session::get('currency_code', $baseCurrency);
        }

        if ($currency_code != $baseCurrency) {
            $rate = Cache::get('currency_rate_' . $currency_code, 1);
            $amount = $amount * $rate;
        }
        return $formatter->formatCurrency($amount, $currency_code);
    }
}
