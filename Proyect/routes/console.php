<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Comando programado genérico para notificar donantes por estado(s)
Artisan::command('schedule:donantes-por-estado', function () {
    // Puedes cambiar los estados aquí según lo que necesites notificar automáticamente
    $this->call('notificar:donantes-por-estado', [
        '--estados' => ['Para Actualizar', 'Pendiente'] // Ejemplo: notifica ambos estados
    ]);
})->purpose('Notifica donantes en los estados definidos');

app(Schedule::class)
    ->command('notificar:donantes-por-estado', ['--estados' => ['Para Actualizar', 'Pendiente']])
    ->everyMinute();