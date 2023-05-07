<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1/auth')->group(function(){
    
    Route::post('/registro', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/perfil', [AuthController::class, 'miPerfil']);
        Route::post('/salir', [AuthController::class, 'salir']);
    });
});


Route::get("/articles", [ArticleController::class, "index"]);