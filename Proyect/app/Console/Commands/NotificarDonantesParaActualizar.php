<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Donante;
use App\Models\Notificacion;
use Carbon\Carbon;
use App\Enums\EstadoDonante;

class NotificarDonantesParaActualizar extends Command
{
    protected $signature = 'notificar:donantes-para-actualizar';
    protected $description = 'Notifica cuando un donante está en estado Para Actualizar y no tiene notificación pendiente';

    public function handle()
    {
        $donantes = Donante::where('estado', EstadoDonante::ParaActializar->value)->get();

        foreach ($donantes as $donante) {
            $yaNotificado = Notificacion::where('descripcion', 'like', "%donante {$donante->nombre} {$donante->apellido}%")
                ->where('estado', 'Pendiente')
                ->exists();

            if (!$yaNotificado) {
                Notificacion::create([
                    'titulo' => 'Donante para actualizar',
                    'descripcion' => "El donante {$donante->nombre} {$donante->apellido} está en estado Para Actualizar.",
                    'fecha' => Carbon::now()->toDateString(),
                    'hora' => Carbon::now()->toTimeString(),
                    'estado' => 'Pendiente',
                ]);
            }
        }

        $this->info('Notificaciones generadas correctamente.');
    }
}