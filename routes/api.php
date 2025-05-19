<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('clients', ClientController::class);
    Route::post('sales', [SaleController::class, 'store']);
    Route::get('statistics/daily-sales', [StatisticsController::class, 'dailySales']);
    Route::get('statistics/top-clients', [StatisticsController::class, 'topClients']);
});
