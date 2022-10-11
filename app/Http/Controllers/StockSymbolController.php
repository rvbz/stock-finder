<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\StockStat;

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

        $stock = json_decode($response->getBody(), true)['Global Quote'];

        if (!$stock || count($stock) < 1) {
            return $stock;
        }

        // Continue storing the data before sending a response to front-end
        $stat = new StockStat();
        $stat->symbol = $stock['01. symbol'];
        $stat->high = $stock['03. high'];
        $stat->low = $stock['04. low'];
        $stat->price = $stock['05. price'];

        if (!$stat->save()) {
            throw new \Exception('Could not save stock stat');
        }

        $stockStat = StockStat::where('symbol', $symbol)->get();

        return ['current' => $stock, 'stats' => $stockStat];
    }
}
