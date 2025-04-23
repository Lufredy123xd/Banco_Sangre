<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    // Atributos de la clase Agenda
    private \DateTime $fechaAgenda;
    private string $horario;
    private bool $asistio;

    /**
     * Constructor vacío.
     */
    public function __construct()
    {
        //
    }

    // Getters y Setters

    public function getFechaAgenda(): \DateTime
    {
        return $this->fechaAgenda;
    }

    public function setFechaAgenda(\DateTime $fechaAgenda): void
    {
        $this->fechaAgenda = $fechaAgenda;
    }

    public function getHorario(): string
    {
        return $this->horario;
    }

    public function setHorario(string $horario): void
    {
        $this->horario = $horario;
    }

    public function getAsistio(): bool
    {
        return $this->asistio;
    }

    public function setAsistio(bool $asistio): void
    {
        $this->asistio = $asistio;
    }

    // Relación inversa con Donante
    public function donante()
    {
        return $this->belongsTo(Donante::class);
    }
}
