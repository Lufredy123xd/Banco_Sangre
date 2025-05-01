<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    // Middlewares de grupo, globales, etc.

    protected $routeMiddleware = [
        // otros middlewares...

        'auth.usuario' => \App\Http\Middleware\Authenticate::class, // ← este es tu middleware personalizado
        'admin' => \App\Http\Middleware\VerificarAdministrador::class,
    ];
}