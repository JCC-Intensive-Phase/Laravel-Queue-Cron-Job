<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

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



Route::get('/transaction/{id}',[TransactionController::class,'index']);
Route::post('/transaction',[TransactionController::class,'store']);
Route::put('/transaction/{transaction}',[TransactionController::class,'update']);

Route::get('/test',[MailController::class,'test']);


Route::get('/product',[ProductController::class,'index']);
Route::get('/product/{product}',[ProductController::class,'show']);
Route::post('/product',[ProductController::class,'store']);
Route::put('/product/{product}',[ProductController::class,'update']);
Route::delete('/product/{product}',[ProductController::class,'destroy']);
