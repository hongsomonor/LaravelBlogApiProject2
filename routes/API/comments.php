<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

// comment
Route::post('posts/{post}/comment',[CommentController::class, 'store'])->middleware('auth:api');
Route::get('comments',[CommentController::class,'index']);
