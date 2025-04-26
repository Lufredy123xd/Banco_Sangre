<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    protected $fillable = [
        'id_donante',
        'donaciones_registradas',
        'reacciones_adversas',
        'fecha',
        'serologia',
        'anticuerpos_irregulares',
        'clase_donacion',
    ];

    // Relación con Donante
    public function donante()
    {
        return $this->belongsTo(Donante::class, 'id_donante');
    }
}
