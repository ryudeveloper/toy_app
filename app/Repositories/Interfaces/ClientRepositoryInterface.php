<?php

namespace App\Repositories\Interfaces;

use App\DTOs\ClientDTO;
use App\Models\Client;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function create(ClientDTO $dto): Client;
    public function all(array $filters = []): Collection;
    public function update(Client $client, ClientDTO $dto): Client;
    public function delete(Client $client): void;
}
