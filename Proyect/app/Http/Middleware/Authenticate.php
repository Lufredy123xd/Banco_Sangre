<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Authenticate 
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('usuario_id')) {
            return redirect()->route('login')->withErrors(['Acceso denegado.']);
        }

        return $next($request);
    }

    public function terminate($request, $response)
    {


    }
}
