<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class StockSymbolController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => env('STOCK_API_SERVER', '')]);
    }

    public function search(Request $request, $symbol)
    {
        $response = $this->client->request('GET', 'query', [
            'query' => [
                'function' => 'SYMBOL_SEARCH',
                'keywords' => $symbol,
                'apikey' => env('STOCK_API_KEY', '')
            ]
        ]);

        return $response->getBody();
    }

    public function get(Request $request, $symbol)
    {
        $response = $this->client->request('GET', 'query', [
            'query' => [
                'function' => 'GLOBAL_QUOTE',
                'symbol' => $symbol,
                'apikey' => env('STOCK_API_KEY', '')
            ]
        ]);

        $stock = json_decode($response->getBody(), true);

        return $response->getBody();
    }
}
