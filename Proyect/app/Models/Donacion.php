<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donacion extends Model
{
    use HasFactory;
    // Atributos de la clase Donacion
    private int $donacionesRegistradas;
    private bool $reaccionesAdversas;
    private \DateTime $fecha;
    private string $serologia; // tipoSerologia
    private string $anticuerposIrregulares; // tipoAnticuerposIrregulares
    private string $claseDonacion; // tipoDonacion

    /**
     * Constructor vacío.
     */
    public function __construct()
    {
        //
    }

    // Getters y Setters

    public function getDonacionesRegistradas(): int
    {
        return $this->donacionesRegistradas;
    }

    public function setDonacionesRegistradas(int $donacionesRegistradas): void
    {
        $this->donacionesRegistradas = $donacionesRegistradas;
    }

    public function getReaccionesAdversas(): bool
    {
        return $this->reaccionesAdversas;
    }

    public function setReaccionesAdversas(bool $reaccionesAdversas): void
    {
        $this->reaccionesAdversas = $reaccionesAdversas;
    }

    public function getFecha(): \DateTime
    {
        return $this->fecha;
    }

    public function setFecha(\DateTime $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function getSerologia(): string
    {
        return $this->serologia;
    }

    public function setSerologia(string $serologia): void
    {
        $this->serologia = $serologia;
    }

    public function getAnticuerposIrregulares(): string
    {
        return $this->anticuerposIrregulares;
    }

    public function setAnticuerposIrregulares(string $anticuerposIrregulares): void
    {
        $this->anticuerposIrregulares = $anticuerposIrregulares;
    }

    public function getClaseDonacion(): string
    {
        return $this->claseDonacion;
    }

    public function setClaseDonacion(string $claseDonacion): void
    {
        $this->claseDonacion = $claseDonacion;
    }

    // Relación inversa con Donante
    public function donante()
    {
        return $this->belongsTo(Donante::class);
    }
}
