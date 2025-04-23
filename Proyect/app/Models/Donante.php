<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donante extends Model
{
    use HasFactory;
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
    private Usuario $modificadoPor; // Usuario

    /**
     * Constructor vacío.
     */
    public function __construct()
    {
        //
    }

    // Getters y Setters

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getApellido(): string
    {
        return $this->apellido;
    }

    public function setApellido(string $apellido): void
    {
        $this->apellido = $apellido;
    }

    public function getCedula(): int
    {
        return $this->cedula;
    }

    public function setCedula(int $cedula): void
    {
        $this->cedula = $cedula;
    }

    public function getSexo(): string
    {
        return $this->sexo;
    }

    public function setSexo(string $sexo): void
    {
        $this->sexo = $sexo;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getFechaNacimiento(): \DateTime
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTime $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getABO(): string
    {
        return $this->ABO;
    }

    public function setABO(string $ABO): void
    {
        $this->ABO = $ABO;
    }

    public function getRH(): string
    {
        return $this->RH;
    }

    public function setRH(string $RH): void
    {
        $this->RH = $RH;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getObservaciones(): string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    public function getUltimaModificacion(): \DateTime
    {
        return $this->ultimaModificacion;
    }

    public function setUltimaModificacion(\DateTime $ultimaModificacion): void
    {
        $this->ultimaModificacion = $ultimaModificacion;
    }

    public function getModificadoPor(): Usuario
    {
        return $this->modificadoPor;
    }

    public function setModificadoPor(Usuario $modificadoPor): void
    {
        $this->modificadoPor = $modificadoPor;
    }

    // Relación uno a muchos con Agenda
    public function agendas()
    {
        return $this->hasMany(Agenda::class);
    }

    // Relación uno a muchos con Diferimiento
    public function diferimientos()
    {
        return $this->hasMany(Diferimiento::class);
    }

    // Relación uno a muchos con Donacion
    public function donaciones()
    {
        return $this->hasMany(Donacion::class);
    }

    // Relación muchos a uno con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'modificado_por');
    }
}
