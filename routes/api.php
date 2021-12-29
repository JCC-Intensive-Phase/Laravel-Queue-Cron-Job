<?php

use Illuminate\Support\Facades\Route;

Route::prefix('transaction')->group(function () {
    Route::post('checkout', [TransactionController::class, 'checkout']);
    Route::get('history/{id}', [App\Http\Controllers\TransactionController::class, 'getHistory']);
    Route::post('pay/{id}', [App\Http\Controllers\TransactionController::class, 'payTransaction']);
});

Route::prefix('product')->group(function () {
    Route::post('/', [App\Http\Controllers\ProductController::class, 'store']);
    Route::get('/', [App\Http\Controllers\ProductController::class, 'getAll']);
});

Route::post('test', [App\Http\Controllers\ProductController::class, 'test']);
