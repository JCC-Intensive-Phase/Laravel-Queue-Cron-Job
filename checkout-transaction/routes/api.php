<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'transaction'], function () {
    Route::get('/history/{id}', [TransactionController::class, 'history']);
    Route::post('/checkout', [TransactionController::class, 'store']);
    Route::put('/payment/{id}', [TransactionController::class, 'pay']);
});

Route::group(['prefix' => 'product'], function () {
    Route::post('/create', [ProductController::class, 'store']);
});
