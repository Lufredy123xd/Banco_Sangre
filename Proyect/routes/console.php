<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('schedule:donantes-para-actualizar', function () {
    $this->call('notificar:donantes-para-actualizar');
})->purpose('Notifica donantes en estado ParaActualizar');

app(Schedule::class)->command('notificar:donantes-para-actualizar')->everyFiveMinutes();
