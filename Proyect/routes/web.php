<?php

use App\Http\Controllers\DonacionController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DiferimentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonanteController;
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


Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::resource('donante', DonanteController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->names([
        'index' => 'donante.index',
        'create' => 'donante.create',
        'store' => 'donante.store',
        'edit' => 'donante.edit',
        'update' => 'donante.update',
        'destroy' => 'donante.destroy',
    ]);

Route::resource('donacion', DonacionController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->names([
        'index' => 'donacion.index',
        'create' => 'donacion.create',
        'store' => 'donacion.store',
        'edit' => 'donacion.edit',
        'update' => 'donacion.update',
        'destroy' => 'donacion.destroy',
    ]);

// routes/web.php

Route::resource('agenda', AgendaController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
    ->names([
        'index' => 'agenda.index',
        'create' => 'agenda.create',
        'store' => 'agenda.store',
        'show' => 'agenda.show',
        'edit' => 'agenda.edit',
        'update' => 'agenda.update',
        'destroy' => 'agenda.destroy',
    ]);

Route::resource('diferimento', DiferimentoController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'])
    ->names([
        'index' => 'diferimento.index',
        'create' => 'diferimento.create',
        'store' => 'diferimento.store',
        'show' => 'diferimento.show',
        'edit' => 'diferimento.edit',
        'update' => 'diferimento.update',
        'destroy' => 'diferimento.destroy',
    ]);
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
