<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/token-tes', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->post('/logout',[UserController::class,'logout']);

Route::middleware('auth:sanctum')->post('/order',[TransactionController::class,'create']);

Route::post('/order/payment-handler',[TransactionController::class,'notifHandler']);

Route::middleware('auth:sanctum')->get('/groups/{groupid}/order',[TransactionController::class,'show']);