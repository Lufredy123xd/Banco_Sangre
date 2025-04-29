<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido',
        'cedula',
        'tipo_usuario',
        'curso_hemoterapia',
        'fecha_nacimiento',
        'user_name',
        'password',
        'estado',
    ];

    // Relación uno a muchos con Donante
    public function donantes()
    {
        return $this->hasMany(Donante::class, 'modificado_por');
    }
}