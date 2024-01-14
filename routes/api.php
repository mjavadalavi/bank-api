<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\TransactionController;
use App\Http\Controllers\API\v1\TransferController;
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

Route::get('/v1/login', [AuthController::class, 'login'])->name('auth.login');


Route::middleware('auth:sanctum')->prefix('v1')->group(function (){

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh-token', [AuthController::class, 'refreshToken'])->name('auth.refresh-token');

    Route::resource('transaction', TransactionController::class)->only(['index', 'store']);
    Route::resource('transfer', TransferController::class)->only(['store']);
});
