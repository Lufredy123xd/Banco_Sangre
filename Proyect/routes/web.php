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

Route::get('/administrador/homeDonante', function () {
    return view('administrador.homeDonante');
})->name('administrador.homeDonante');

Route::get('/administrador/verMas', function () {
    return view('administrador.verMas');
})->name('administrador.verMas');

// GET: muestra el formulario
Route::get('/login', function () {
    return view('login'); // o donde esté tu blade del login
})->name('login');

Route::get('/usuario', function () {
    return view('usuario.index'); // o donde esté tu blade del login
})->name('usuario.index');

// POST: procesa el formulario
Route::post('/login', [UsuarioController::class, 'authenticate'])->name('login.authenticate');

Route::get('/registrar', [DonanteController::class, 'create'])->name('registrar');

// GET: muestra el formulario
Route::get('/home', function () {
    return view('home'); // o donde esté tu blade del login
})->name('home');


// Ruta para registrar un nuevo administrador
Route::get('/administrador/registrar', [UsuarioController::class, 'create'])->name('administrador.registrar');

// Ruta para editar un administrador (redirige al formulario de edición)
Route::get('/administrador/modificar', [UsuarioController::class, 'edit'])->name('administrador.modificar');

Route::get('/administrador/home', [UsuarioController::class, 'home'])->name('administrador.home');

Route::get('/administrador/verMas/{id}', [UsuarioController::class, 'verMas'])->name('administrador.verMas');
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



Route::get('/gestionar-donante/{id}', [DonacionController::class, 'gestionarDonante'])->name('gestionarDonante');
Route::post('/donante/{id}/no-asistio', [DonanteController::class, 'noAsistio'])->name('donante.no_asistio');

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

    Route::get('/administrador/homeDonante', [DonanteController::class, 'home'])->name('administrador.homeDonante');

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

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::get('/registrar', function () {
        return view('registrar');
    })->name('registrar');

    Route::get('/modificar', function () {
        return view('modificar');
    })->name('modificar');

    Route::get('/detalle', function () {
        return view('detalle');
    })->name('detalle');

    Route::get('/gestionarDonante', function () {
        return view('gestionarDonante');
    })->name('gestionarDonante');