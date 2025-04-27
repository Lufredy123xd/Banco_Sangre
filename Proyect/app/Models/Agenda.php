<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'id_donante',
        'fechaAgenda',
        'horario',
        'asistio',
    ];

    public function donantes()
    {
        return $this->belongsTo(Donante::class);
    }

}
