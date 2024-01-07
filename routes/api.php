<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\GamerController;
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
// User
Route::post('/login', [UserController::class,'login'])->name('login');

// Post
Route::middleware('auth:sanctum')->post('/logout',[UserController::class,'logout']);
Route::middleware('auth:sanctum')->post('/order',[TransactionController::class,'create']);

// Payment gateway
Route::post('/order/payment-handler',[TransactionController::class,'notifHandler']);

// Group
Route::middleware('auth:sanctum')->get('/groups/{groupid}/order',[TransactionController::class,'show']);

// Doctors
Route::post('/doctors/register',[DoctorController::class,'create']);


// Gamer
Route::post('/gamers/register',[GamerController::class,'create']);
Route::middleware('auth:sanctum')->get('/gamers',[GamerController::class,'index']);

