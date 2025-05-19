<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\JsonResponse;

class StatisticsController extends Controller
{
    public function __construct(protected StatisticsService $service)
    {
    }

    public function dailySales(): JsonResponse
    {
        return response()->json($this->service->getSalesPerDay());
    }

    public function topClients(): JsonResponse
    {
        return response()->json($this->service->getTopClients());
    }
}
