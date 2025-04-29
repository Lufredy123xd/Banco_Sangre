<?php

use App\Http\Controllers\DonacionController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DiferimentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonanteController;
use App\Http\Controllers\UsuarioController;

// routes/web.php


// Ruta para el inicio del administrador
Route::get('/administrador/home', function () {
return view('administrador.home');
})->name('administrador.home');

// Ruta para registrar un nuevo administrador
Route::get('/administrador/registrar', [UsuarioController::class, 'create'])->name('administrador.registrar');

// Ruta para editar un administrador (redirige al formulario de edición)
Route::get('/administrador/modificar', [UsuarioController::class, 'edit'])->name('administrador.modificar');

//route administrador
Route::resource('administrador', UsuarioController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->names([
        'index' => 'administrador.index',
        'create' => 'administrador.create',
        'store' => 'administrador.store',
        'edit' => 'administrador.edit',
        'update' => 'administrador.update',
        'destroy' => 'administrador.destroy',
    ]);



//route donante
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

//route donacion
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
// Route para mostrar la lista de agendas
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

// Route para mostrar la lista de diferimientos
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
Route::resource('usuario', UsuarioController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    ->names([
        'index' => 'usuario.index',
        'create' => 'usuario.create',
        'store' => 'usuario.store',
        'edit' => 'usuario.edit',
        'update' => 'usuario.update',
        'destroy' => 'usuario.destroy',
    ]);
