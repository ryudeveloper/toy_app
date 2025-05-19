<?php

namespace App\Repositories\Interfaces;

use App\Models\Sale;
use Illuminate\Support\Collection;

interface SaleRepositoryInterface
{
    public function store(array $data): Sale;
    public function getSalesGroupedByDay(): Collection;
    public function getTopClientsByVolume(): Collection;
    public function getTopClientsByAverage(): Collection;
    public function getTopClientsByFrequency(): Collection;
}
