<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

// categories
Route::get('categories',[CategoryController::class,'index']);
Route::post('category',[CategoryController::class,'store']);
Route::get('category/{id}',[CategoryController::class,'show']);
Route::post('category/{id}',[CategoryController::class,'update']);
Route::delete('category/{id}',[CategoryController::class,'destroy']);

Route::get('posts',[PostController::class,'index']);
Route::post('post',[PostController::class,'store'])->middleware('auth:api');

// comment
Route::post('posts/{post}/comment',[CommentController::class, 'store'])->middleware('auth:api');
Route::get('comments',[CommentController::class,'index']);

// reaction
Route::get('reactions',[ReactionController::class,'index']);
Route::post('posts/{post}/reaction',[ReactionController::class,'store'])->middleware('auth:api');
