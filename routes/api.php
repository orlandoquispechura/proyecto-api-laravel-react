<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/v1/auth')->group(function () {

    Route::post('/registro', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/perfil', [AuthController::class, 'miPerfil']);
        Route::post('/salir', [AuthController::class, 'salir']);
    });
});

Route::apiResource('/categoria', CategoriaController::class);
Route::apiResource('/producto', ProductoController::class);
Route::apiResource('/cliente', ClienteController::class);
Route::apiResource('/usuario', UsuarioController::class);
