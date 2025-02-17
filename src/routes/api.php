<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TravelOrderController;
use App\Http\Middleware\JwtMiddleware;

Route::withoutMiddleware('jwtAuth')->group(function () {
    Route::post('/auth', [AuthController::class, 'auth']);
});

Route::middleware([JwtMiddleware::class])->group(function () {
    Route::apiResource('/travel-order', TravelOrderController::class);
    Route::post('/travel-order/{id}/status', [TravelOrderController::class, 'updateStatus'])->name('updateOrderStatus');
    Route::post('/travel-order/{id}/cancel', [TravelOrderController::class, 'cancel'])->name('cancelOrder');
});
