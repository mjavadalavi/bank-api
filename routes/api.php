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

Route::post('/v1/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/v1/login', [AuthController::class, 'login'])->name('login');


Route::middleware('auth:sanctum')->prefix('v1')->group(function (){

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh-token', [AuthController::class, 'refreshToken'])->name('auth.refresh-token');


    Route::get('/transaction', [TransactionController::class, 'index'])->name('transaction.index');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');

    Route::post('/transfer', [TransferController::class, 'store'])->name('transfer.store');
});
