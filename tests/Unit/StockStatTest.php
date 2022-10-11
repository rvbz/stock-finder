<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use App\Models\StockStat;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockStatTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_connection_to_api()
    {
        $client = new Client(['base_uri' => env('STOCK_API_SERVER', '')]);
        $response = $client->request('GET', 'query', [
            'query' => [
                'function' => 'SYMBOL_SEARCH',
                'keywords' => Str::random(7),
                'apikey' => env('STOCK_API_KEY', '')
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('bestMatches', $data);
    }

    public function test_only_authenticated_users_can_request()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();

        $response = $this->get('/api/stock-symbol/search/' . Str::random(7));
        $response->assertStatus(200);
    }
}
