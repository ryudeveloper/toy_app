<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Sale;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('123456'),
        ]);

        Client::factory(5)->create()->each(function ($client) {
            Sale::factory(rand(3, 7))->create([
                'client_id' => $client->id,
            ]);
        });
    }
}
