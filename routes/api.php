<?php

use App\Http\Controllers\Api\V1\HealthCheckController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/health', [HealthCheckController::class, '__invoke'])->name('health.check');

    // Categories
    Route::apiResource('categories', CategoryController::class);
});
