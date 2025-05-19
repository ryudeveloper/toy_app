<?php

namespace App\Services;

use App\DTOs\ClientDTO;
use App\Models\Client;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientService
{
    public function __construct(protected ClientRepositoryInterface $repository)
    {
    }
    public function create(ClientDTO $dto): Client
    {
        return $this->repository->create($dto);
    }
    public function list(array $filters = []): Collection
    {
        return $this->repository->all($filters);
    }
    public function update(Client $client, ClientDTO $dto): Client
    {
        return $this->repository->update($client, $dto);
    }
    public function delete(Client $client): void
    {
        $this->repository->delete($client);
    }
}
