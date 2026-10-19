<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\LivroController;
use Illuminate\Support\Facades\Route;

Route::middleware('throttle:10,1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::apiResource('autores', AutorController::class)
    ->parameters(['autores' => 'autor'])
    ->only(['index', 'show']);

Route::apiResource('categorias', CategoriaController::class)
    ->parameters(['categorias' => 'categoria'])
    ->only(['index', 'show']);

Route::apiResource('livros', LivroController::class)
    ->parameters(['livros' => 'livro'])
    ->only(['index', 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('autores', AutorController::class)
        ->parameters(['autores' => 'autor'])
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('categorias', CategoriaController::class)
        ->parameters(['categorias' => 'categoria'])
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('livros', LivroController::class)
        ->parameters(['livros' => 'livro'])
        ->only(['store', 'update', 'destroy']);

    Route::get('user', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});
