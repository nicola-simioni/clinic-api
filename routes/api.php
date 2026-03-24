<?php

use App\Http\Controllers\Api\V1\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\ServiceController;
use App\Http\Controllers\Api\V1\SlotController;
use App\Http\Controllers\Api\V1\BookingController;

Route::prefix('v1')->group(function () {

    // Rotte pubbliche
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    // Rotte protette
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me',      [AuthController::class, 'me']);
        Route::apiResource('/doctors', DoctorController::class);
        Route::apiResource('/services', ServiceController::class);
        Route::apiResource('/slots', SlotController::class);
        Route::apiResource('/bookings', BookingController::class);
    });
});