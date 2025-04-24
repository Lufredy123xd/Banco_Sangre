<?php

use App\Http\Controllers\AgendaController;
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

Route::get('/eliminar', function () {
    return view('eliminar');
})->name('eliminar');

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