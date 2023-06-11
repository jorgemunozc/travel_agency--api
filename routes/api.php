<?php

declare(strict_types=1);

use App\Http\Controllers\V1\CreateUserController;
use App\Http\Controllers\V1\TourController;
use App\Http\Controllers\V1\TravelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::prefix('v1')->group(function () {
    Route::get('/travels', [TravelController::class, 'index']);
    Route::get('/travels/{travel:slug}/tours', [TourController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/users', CreateUserController::class);
        Route::post('/travels', [TravelController::class, 'store']);
        Route::put('/travels/{travel}', [TravelController::class, 'update']);
    });
});
