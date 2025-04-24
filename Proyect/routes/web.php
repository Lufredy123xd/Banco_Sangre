<?php

use Illuminate\Support\Facades\Route;

// routes/web.php
Route::get('/', function () {
    return view('administrador.home');
})->name('administrador.home');

Route::get('/registrar', function () {
    return view('registrar');
})->name('registrar');

Route::get('/modificar', function () {
    return view('modificar');
})->name('modificar');

Route::get('/detalle', function () {
    return view('detalle');
})->name('detalle');

Route::get('/gestionar', function () {
    return view('gestionarDonante');
})->name('gestionarDonante');


Route::get('/registrar', function () {
    return view('administrador.registrar');
})->name('administrador.registrar');

Route::get('/editar', function () {
    return view('administrador.editar');
})->name('administrador.editar');