<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agenda extends Model
{
      use HasFactory;
    protected $fillable = [
        'id_donante',
        'fechaAgenda',
        'horario',
        'asistio',
    ];

 public function donante()
{
    return $this->belongsTo(Donante::class, 'id_donante');
}

}
