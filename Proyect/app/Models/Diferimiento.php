<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diferimiento extends Model
{
    use HasFactory;
    // Atributos de la clase Diferimiento
    private string $motivo;
    private \DateTime $fechaDiferimiento;
    private string $tipo; // tipoDiferimiento
    private int $tiempoEnMeses;

    /**
     * Constructor vacío.
     */
    public function __construct()
    {
        //
    }

    // Getters y Setters

    public function getMotivo(): string
    {
        return $this->motivo;
    }

    public function setMotivo(string $motivo): void
    {
        $this->motivo = $motivo;
    }

    public function getFechaDiferimiento(): \DateTime
    {
        return $this->fechaDiferimiento;
    }

    public function setFechaDiferimiento(\DateTime $fechaDiferimiento): void
    {
        $this->fechaDiferimiento = $fechaDiferimiento;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getTiempoEnMeses(): int
    {
        return $this->tiempoEnMeses;
    }

    public function setTiempoEnMeses(int $tiempoEnMeses): void
    {
        $this->tiempoEnMeses = $tiempoEnMeses;
    }

    // Relación inversa con Donante
    public function donante()
    {
        return $this->belongsTo(Donante::class);
    }
}
