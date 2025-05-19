<?php

namespace App\Repositories\Eloquent;

use App\DTOs\ClientDTO;
use App\Models\Client;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientRepository implements ClientRepositoryInterface
{
    public function create(ClientDTO $dto): Client
    {
        return Client::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'birthdate' => $dto->birthdate
        ]);
    }

    public function all(array $filters = []): Collection
    {
        return Client::when($filters['name'] ?? null, fn($q, $name) => $q->where('name', 'like', "%$name%"))
            ->when($filters['email'] ?? null, fn($q, $email) => $q->where('email', $email))
            ->get();
    }

    public function update(Client $client, ClientDTO $dto): Client
    {
        $client->update([
            'name' => $dto->name,
            'email' => $dto->email,
            'birthdate' => $dto->birthdate
        ]);
        return $client;
    }

    public function delete(Client $client): void
    {
        $client->delete();
    }
}
