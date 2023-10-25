<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    protected $baseUrl = 'https://api.exchangeratesapi.io/v1/';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert ($from, $to, $amount = 1)
    {
        $response = Http::baseUrl($this->baseUrl)->get('latest', [
            '? access_key = ' => '7875c178d16a4875c7b35a94e7e9e87e',
            '&from=' => $from,
            '&to=' => $to,
            '&amount=' => $amount,
        ]);

        $result = $response->json();
        dd($result);
        return $result * $amount;
    }
}
