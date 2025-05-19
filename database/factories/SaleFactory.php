<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'date' => $this->faker->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
        ];
    }
}
