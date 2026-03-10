<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetoranController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
});

// Protected Resource Routes (JWT)
Route::middleware('auth:api')->group(function () {
    Route::get('setoran', [SetoranController.class, 'index']);
    Route::post('setoran', [SetoranController.class, 'store']);
    Route::get('setoran/{id}', [SetoranController.class, 'show']);
    Route::put('setoran/{id}', [SetoranController.class, 'update']);
    Route::delete('setoran/{id}', [SetoranController.class, 'destroy']);
    Route::post('cek-status', [SetoranController.class, 'checkByTicket']);
});
