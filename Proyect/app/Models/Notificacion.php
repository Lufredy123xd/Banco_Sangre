<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    protected $table = 'notificaciones';
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha',
        'hora',
        'estado',
    ];
}
