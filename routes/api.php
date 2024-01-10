<?php

<<<<<<< Updated upstream
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\GamerController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\HealthReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
=======
>>>>>>> Stashed changes
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GamerController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\TransactionController;

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
Route::post('/login', [UserController::class, 'login'])->name('login');

// Post
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/order', [TransactionController::class, 'create']);

// Payment gateway
Route::post('/order/payment-handler', [TransactionController::class, 'notifHandler']);

// Group
Route::middleware('auth:sanctum')->get('/groups/{groupid}/order', [TransactionController::class, 'show']);
Route::middleware('auth:sanctum')->post('/groups/{groupid}/profile/update', [GroupController::class, 'updateImage']);
Route::middleware('auth:sanctum')->post('/groups', [GroupController::class, 'create']);
Route::middleware('auth:sanctum')->get('/gamers/groups/preview',[GroupController::class,'showPreview']);
Route::middleware('auth:sanctum')->get('/groups/{grupid}',[GroupController::class,'show']);

// Doctors
<<<<<<< Updated upstream
Route::post('/doctors/register', [DoctorController::class, 'create']);
Route::middleware('auth:sanctum')->post('/doctors/update/image', [DoctorController::class, 'changeImage']);
Route::middleware('auth:sanctum')->put('/doctors', [DoctorController::class, 'update']);
Route::middleware('auth:sanctum')->get('/doctors', [DoctorController::class, 'index']);
Route::middleware('auth:sanctum')->get('/doctors/{doctorid}/preview', [DoctorController::class, 'show']);


// Gamer
Route::post('/gamers/register', [GamerController::class, 'create']);
Route::middleware('auth:sanctum')->get('/gamers', [GamerController::class, 'index']);
Route::middleware('auth:sanctum')->post('gamers/doctor-favorites/{doctorid}', [GamerController::class, 'addFavoriteDoctor']);
Route::middleware('auth:sanctum')->put('gamers/healt-report', [HealthReportController::class, 'updateHealthReport']);
Route::middleware('auth:sanctum')->get('/gamers/{gamerid}/health-report', [HealthReportController::class, 'GetHealthReport']);
Route::middleware('auth:sanctum')->patch('/gamers/edit/{id}', [GamerController::class, 'edit']);
=======
Route::post('/doctors/register',[DoctorController::class,'create']);

// Gamers
Route::middleware('auth:sanctum')->get('/gamers',[GamerController::class,'index']);
>>>>>>> Stashed changes
