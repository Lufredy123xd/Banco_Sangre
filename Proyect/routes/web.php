<?php

use App\Http\Controllers\DonacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonanteController;

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
