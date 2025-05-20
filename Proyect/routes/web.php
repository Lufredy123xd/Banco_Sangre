<?php

use App\Http\Controllers\DonacionController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DiferimentoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonanteController;
use App\Http\Controllers\UsuarioController;

Route::get('/donantes/export/pdf', [DonanteController::class, 'exportPdf'])->name('donantes.export.pdf');


// routes/web.php

Route::get('/', function () {
    return view('login');
})->name('login');

// POST: procesa el formulario
Route::post('/login', [UsuarioController::class, 'authenticate'])->name('login.authenticate');

Route::get('/logout', [UsuarioController::class, 'logout'])->name('logout');

// Mostrar formulario de recuperación
Route::get('/reset', [UsuarioController::class, 'showResetForm'])->name('password.form');

// Procesar solicitud de nueva contraseña
Route::post('/reset', [UsuarioController::class, 'resetPassword'])->name('password.reset');

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
    // Ruta para mostrar detalles de donaciones
    Route::get('/donante/{id}', [DonanteController::class, 'getDetails']);
    
/*
    Route::get('/registrar', function () {
        return view('registrar');
    })->name('registrar');

    Route::get('/modificar', function () {
        return view('modificar');
    })->name('modificar');

    Route::get('/detalle', function () {
        return view('detalle');
    })->name('detalle');
*/