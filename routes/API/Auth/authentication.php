<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('user/profile', [AuthController::class, 'viewProfile']);
    Route::post('user/profile', [AuthController::class, 'update']);
    Route::post('user/logout',[AuthController::class,'logout']);
    Route::delete('user',[AuthController::class,'deleteAccount']);
});
