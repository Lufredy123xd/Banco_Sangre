<?php

namespace App\Providers;

use App\Models\Notificacion;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $notificaciones_pendientes = Notificacion::where('estado', 'Pendiente')->count();
            $view->with('notificacionesPendientes', $notificaciones_pendientes);
        });
    }
}
