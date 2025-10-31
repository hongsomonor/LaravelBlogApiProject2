<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::post('posts/{post}/comment', [CommentController::class, 'store']);
    Route::get('comments', [CommentController::class, 'index']);
    Route::get('comments/{comment}',[CommentController::class,'show']);
    Route::post('posts/{post}/comment/{comment}',[CommentController::class,'update']);
});
