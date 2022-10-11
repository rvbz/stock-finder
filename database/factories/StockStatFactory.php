<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockStat>
 */
class StockStatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'symbol' => Str::random(7),
            'high' => fake()->randomFloat(4, 0, 9999999999),
            'low' => fake()->randomFloat(4, 0, 9999999999),
            'price' => fake()->randomFloat(4, 0, 9999999999)
        ];
    }
}
