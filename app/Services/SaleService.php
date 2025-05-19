<?php

namespace App\Services;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use App\Models\Sale;
use Illuminate\Support\Collection;

class SaleService
{
    public function __construct(protected SaleRepositoryInterface $repository)
    {
    }
    public function store(array $data): Sale
    {
        return $this->repository->store($data);
    }
}
