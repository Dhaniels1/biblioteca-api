<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->json(['name' => 'Biblioteca API', 'livros' => url('/api/livros')]));
