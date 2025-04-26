<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    private \DateTime $fechaAgenda;
    private string $horario;
    private bool $asistio;
}
