<?php

namespace App\Services;

use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\Collection;

class StatisticsService
{
    public function __construct(protected SaleRepositoryInterface $repository)
    {
    }

    public function getSalesPerDay(): Collection
    {
        return $this->repository->getSalesGroupedByDay();
    }

    public function getTopClients(): array
    {
        $topVolume = $this->repository->getTopClientsByVolume()->first();
        $topAverage = $this->repository->getTopClientsByAverage()->first();
        $topFrequency = $this->repository->getTopClientsByFrequency()->first();

        return [
            'top_volume' => [
                'client' => $topVolume['client'] ?? null,
                'total' => $topVolume['total'] ?? 0,
            ],
            'top_average' => [
                'client' => $topAverage['client'] ?? null,
                'average' => $topAverage['average'] ?? 0,
            ],
            'top_frequency' => [
                'client' => $topFrequency['client'] ?? null,
                'days' => $topFrequency['days'] ?? 0,
            ],
        ];
    }
}
