<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\ProductController;

Route::group([
    'as'     => 'api.',
    'prefix' => 'v1',
], function () {
    Route::group([
    ], function () {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
    });

    Route::apiResource('product', ProductController::class)->only(['index', 'show']);

    Route::group([
        'middleware' => request()->header('Authorization') ? 'auth:sanctum' : [],
    ], function () {
        Route::group([
            'prefix' => 'basket',
            'as'     => 'basket.',
        ], function () {
            Route::get('/', [BasketController::class, 'index']);
            Route::post('/add-item/{product}', [BasketController::class, 'store']);
            Route::delete('/remove-item/{item}', [BasketController::class, 'destroy']);
            Route::patch('/change-quantity/{item}/{quantity}', [BasketController::class, 'updateQuantity']);
        });

        Route::post('/checkout/{basket}', [OrderController::class, 'checkout'])->name('order.checkout');
    });

    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('order.index');

        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
