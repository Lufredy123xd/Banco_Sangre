<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

// routes/web.php
Route::get('/', function () {
    return view('administrador.home');
})->name('administrador.home');

Route::get('/registrar', function () {
    return view('administrador.registrar');
})->name('administrador.registrar');

Route::get('/editar', function () {
    return view('administrador.editar');
})->name('administrador.editar');


// Ruta para mostrar la lista de usuarios
Route::get('/usuario', [UsuarioController::class, 'index'])->name('usuario.index');

// Ruta para mostrar el formulario de creación de un nuevo usuario
Route::get('/usuario/create', [UsuarioController::class, 'create'])->name('usuario.create');

// Ruta para almacenar un nuevo usuario
Route::post('/usuario', [UsuarioController::class, 'store'])->name('usuario.store');

// Ruta para mostrar el formulario de edición de un usuario existente
Route::get('/usuario/{id}/edit', [UsuarioController::class, 'edit'])->name('usuario.edit');

// Ruta para actualizar un usuario existente
Route::put('/usuario/{id}', [UsuarioController::class, 'update'])->name('usuario.update');

// Ruta para eliminar un usuario
Route::delete('/usuario/{id}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');