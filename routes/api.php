<?php

use App\Http\Controllers\API\User\AuthController;
use App\Http\Controllers\API\User\RegisterController;
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
Route::prefix('users')->group(function () {
    Route::post('register', RegisterController::class)
        ->name('register');
    Route::post('login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('logout', [AuthController::class, 'logout'])
        ->middleware('auth:sanctum')
        ->name('logout');
});

