<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_client(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/clients', [
            'name' => 'Maria',
            'email' => 'maria@example.com',
            'birthdate' => '1990-01-01',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', ['email' => 'maria@example.com']);
    }

    public function test_authenticated_user_can_update_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->putJson("/api/clients/{$client->id}", [
            'name' => 'Updated Name',
            'email' => $client->email,
            'birthdate' => $client->birthdate,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('clients', ['name' => 'Updated Name']);
    }

    public function test_authenticated_user_can_delete_client(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->deleteJson("/api/clients/{$client->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
