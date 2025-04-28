<?php

use App\Http\Controllers\AgendaController;
use App\Http\Controllers\DiferimentoController;
use App\Models\Diferimento;
use Illuminate\Support\Facades\Route;

// routes/web.php
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/registrar', function () {
    return view('registrar');
})->name('registrar');

Route::get('/modificar', function () {
    return view('modificar');
})->name('modificar');

<<<<<<< Updated upstream
Route::get('/eliminar', function () {
    return view('eliminar');
})->name('eliminar');
=======
Route::get('/gestionar-donante', function () {
    return view('gestionarDonante');
})->name('gestionarDonante');
>>>>>>> Stashed changes

Route::get('/faq', function () {
    return view('faq');
})->name('faq');



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