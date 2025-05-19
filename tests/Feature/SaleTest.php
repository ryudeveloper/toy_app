<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_sale(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/sales', [
            'client_id' => $client->id,
            'date' => '2024-01-01',
            'amount' => 100.50
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('sales', ['client_id' => $client->id, 'amount' => 100.50]);
    }
}
