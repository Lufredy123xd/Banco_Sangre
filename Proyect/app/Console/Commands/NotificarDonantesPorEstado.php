<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Donante;
use App\Models\Notificacion;
use Carbon\Carbon;

class NotificarDonantesPorEstado extends Command
{
    protected $signature = 'notificar:donantes-por-estado {--estados=* : Lista de estados a notificar (ej: "Para Actualizar" "Pendiente")}';
    protected $description = 'Notifica cuando un donante está en uno o varios estados y no tiene notificación pendiente';

    public function handle()
    {
        $estados = $this->option('estados');

        if (empty($estados)) {
            $this->error('Debes especificar al menos un estado con la opción --estados=');
            return;
        }

        $donantes = Donante::whereIn('estado', $estados)->get();

        foreach ($donantes as $donante) {
            $yaNotificado = Notificacion::where('descripcion', 'like', "%donante {$donante->nombre} {$donante->apellido}%")
                ->where('estado', 'Pendiente')
                ->exists();

            if (!$yaNotificado) {
                Notificacion::create([
                    'titulo' => 'Donante para notificar',
                    'descripcion' => "El donante {$donante->nombre} {$donante->apellido} está en estado {$donante->estado}.",
                    'fecha' => Carbon::now()->toDateString(),
                    'hora' => Carbon::now()->toTimeString(),
                    'estado' => 'Pendiente',
                ]);
            }
        }

        $this->info('Notificaciones generadas correctamente para los estados: ' . implode(', ', $estados));
    }
}