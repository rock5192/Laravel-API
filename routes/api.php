<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;


Route::post('register',[AuthController::class,'register']);

Route::post('login',[AuthController::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::post('logout',[AuthController::class,
        'logout']);
});

Route::middleware('auth:api')->group(function(){
    Route::get('get_user',[AuthController::class,'me']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/products',ProductController::class);

Route::group(['prefix' => 'products'],function (){
   Route::apiResource('/{product}/reviews',ReviewController::class);
});
