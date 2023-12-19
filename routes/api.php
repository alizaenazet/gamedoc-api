<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GamerController;

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

Route::get('/gamers', [GamerController::class,'index']);
