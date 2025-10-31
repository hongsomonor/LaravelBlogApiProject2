<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('posts', [PostController::class, 'index']);
    Route::post('post', [PostController::class, 'store']);
    Route::get('posts/{post}', [PostController::class, 'show']);
    Route::post('posts/update/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);
});
