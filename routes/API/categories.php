<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// categories
Route::get('categories',[CategoryController::class,'index']);
Route::post('category',[CategoryController::class,'store']);
Route::get('category/{id}',[CategoryController::class,'show']);
Route::post('category/{id}',[CategoryController::class,'update']);
Route::delete('category/{id}',[CategoryController::class,'destroy']);
