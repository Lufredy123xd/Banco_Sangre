<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Donacion;


class Donante extends Model
{
   protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'sexo',
        'telefono',
        'fecha_nacimiento',
        'ABO',
        'RH',
        'estado',
        'observaciones',
        'ultima_modificacion',
        'modificado_por'
    ];

   

    // Relación uno a muchos con Agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    // Relación uno a muchos con Diferimiento
    public function diferimientos()
    {
        return $this->hasMany(Diferimento::class);
    }

    // Relación uno a muchos con Donacion
    public function donaciones()
    {
        return $this->hasMany(Donacion::class, 'id_donante');
    }

    // Relación muchos a uno con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'modificado_por');
    }
}
