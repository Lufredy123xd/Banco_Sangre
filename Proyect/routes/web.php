<?php

use Illuminate\Support\Facades\Route;

// routes/web.php
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

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
