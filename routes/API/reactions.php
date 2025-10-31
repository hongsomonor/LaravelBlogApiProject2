<?php

use App\Http\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;

// reaction
Route::get('reactions',[ReactionController::class,'index']);
Route::post('posts/{post}/reaction',[ReactionController::class,'store'])->middleware('auth:api');
