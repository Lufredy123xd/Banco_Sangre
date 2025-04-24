<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

// Rutas para el recurso Usuario
Route::apiResource('usuarios', UsuarioController::class);