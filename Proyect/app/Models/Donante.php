<?php

namespace App;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Donacion;


class Donante extends Model
{
    // Atributos de la clase Donante
    private string $nombre;
    private string $apellido;
    private int $cedula;
    private string $sexo; // sexos
    private string $telefono;
    private \DateTime $fechaNacimiento;
    private string $ABO; // tipoABO
    private string $RH; // tipoRH
    private string $estado; // estadoDonante
    private string $observaciones;
    private \DateTime $ultimaModificacion;
   // private Usuario $modificadoPor; // Usuario

   

    // Relación uno a muchos con Agenda
    /*public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }*/

    // Relación uno a muchos con Diferimiento
    /*public function diferimientos()
    {
        return $this->hasMany(Diferimiento::class);
    }*/

    // Relación uno a muchos con Donacion
    public function donaciones()
    {
        return $this->hasMany(Donacion::class);
    }

    // Relación muchos a uno con Usuario
   /* public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'modificado_por');
    }*/
}
