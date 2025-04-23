<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    // Atributos de la clase Usuario
    private string $nombre;
    private string $apellido;
    private int $cedula;
    private string $tipo; // tipoUser
    private \DateTime $fechaNacimiento;
    private string $cursoHemoterapia; // curso
    private string $userName;
    private string $contrasena; // contraseña
    private string $estadoUser; // estadoUser

    public function __construct()
    {
        // Constructor vacío
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

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getFechaNacimiento(): \DateTime
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTime $fechaNacimiento): void
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function getCursoHemoterapia(): string
    {
        return $this->cursoHemoterapia;
    }

    public function setCursoHemoterapia(string $cursoHemoterapia): void
    {
        $this->cursoHemoterapia = $cursoHemoterapia;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): void
    {
        $this->userName = $userName;
    }

    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    public function setContrasena(string $contrasena): void
    {
        $this->contrasena = $contrasena;
    }

    public function getEstadoUser(): string
    {
        return $this->estadoUser;
    }

    public function setEstadoUser(string $estadoUser): void
    {
        $this->estadoUser = $estadoUser;
    }

    // Relación uno a muchos con Donante
    public function donantes()
    {
        return $this->hasMany(Donante::class, 'modificado_por');
    }
}