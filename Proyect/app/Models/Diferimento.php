<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diferimento extends Model
{

    protected $fillable = [
        'id_donante',
        'motivo',
        'fecha_diferimiento',
        'tipo',
        'tiempo_en_meses',
    ];

    public function donantes()
    {
        return $this->belongsTo(Donante::class, 'id_donante');
    }

}
