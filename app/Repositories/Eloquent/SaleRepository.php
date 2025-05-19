<?php

namespace App\Repositories\Eloquent;

use App\Models\Sale;
use Illuminate\Support\Collection;
use App\Repositories\Interfaces\SaleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SaleRepository implements SaleRepositoryInterface
{
    public function store(array $data): Sale
    {
        return Sale::create($data);
    }

    public function getSalesGroupedByDay(): Collection
    {
        return Sale::select(DB::raw('date, SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    public function getTopClientsByVolume(): Collection
    {
        return \App\Models\Client::with('sales')
            ->get()
            ->map(function ($client) {
                return [
                    'client' => $client,
                    'total' => $client->sales->sum('amount'),
                ];
            })
            ->sortByDesc('total')
            ->take(1)
            ->values();
    }
    public function getTopClientsByAverage(): Collection
    {
        return \App\Models\Client::with('sales')
            ->get()
            ->map(function ($client) {
                return [
                    'client' => $client,
                    'average' => $client->sales->avg('amount') ?? 0,
                ];
            })
            ->sortByDesc('average')
            ->take(1)
            ->values();
    }
    public function getTopClientsByFrequency(): Collection
    {
        return \App\Models\Client::with('sales')
            ->get()
            ->map(function ($client) {
                $uniqueDays = $client->sales->pluck('date')->unique()->count();
                return [
                    'client' => $client,
                    'days' => $uniqueDays,
                ];
            })
            ->sortByDesc('days')
            ->take(1)
            ->values();
    }
}

