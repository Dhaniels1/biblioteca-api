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
foreach (['autores' => [AutorController::class, 'autor'], 'categorias' => [CategoriaController::class, 'categoria'], 'livros' => [LivroController::class, 'livro']] as $uri => [$controller, $parameter]) {
    Route::apiResource($uri, $controller)->parameters([$uri => $parameter])->only(['index', 'show']);
    Route::middleware('auth:sanctum')->group(function () use ($uri, $controller, $parameter) {
        Route::post($uri, [$controller, 'store']);
        Route::put($uri.'/{'.$parameter.'}', [$controller, 'update']);
        Route::delete($uri.'/{'.$parameter.'}', [$controller, 'destroy']);
    });
}
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});
