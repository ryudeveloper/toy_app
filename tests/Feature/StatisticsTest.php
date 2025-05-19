<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use App\Models\Sale;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatisticsTest extends TestCase
{
    use RefreshDatabase;

    public function test_daily_sales_returns_data(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        Sale::factory()->create(['client_id' => $client->id, 'date' => '2024-01-01', 'amount' => 150]);
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/statistics/daily-sales');
        $response->assertStatus(200)->assertJsonFragment(['date' => '2024-01-01']);
    }

    public function test_top_clients_returns_summary(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        Sale::factory()->count(3)->create(['client_id' => $client->id, 'amount' => 100]);
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/statistics/top-clients');
        $response->assertStatus(200)->assertJsonStructure([
            'top_volume',
            'top_average',
            'top_frequency'
        ]);
    }
}
