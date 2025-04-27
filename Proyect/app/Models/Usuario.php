<?php

namespace App\Models;

use App\Enums\TipoUsuario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'rol',
        'password',
    ];
    

    // Relación uno a muchos con Donante
    public function donantes()
    {
        return $this->hasMany(Donante::class, 'modificado_por');
    }
}