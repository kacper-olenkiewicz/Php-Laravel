<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BookingApiController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('products', [ProductApiController::class, 'index']);

    Route::middleware('role:Customer')->prefix('customer')->group(function () {
        Route::post('bookings', [BookingApiController::class, 'store']);
        Route::get('my-bookings', [BookingApiController::class, 'myBookings']);
    });

    Route::middleware('role:RentalOwner|Employee')->prefix('rental')->group(function () {
        Route::put('bookings/{booking}/status', [BookingApiController::class, 'updateStatus']);
    });
});