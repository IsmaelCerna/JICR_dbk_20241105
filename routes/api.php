<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/nuevousuario',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:sanctum')->post('/usuario',[AuthController::class,'getUserDetails']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
