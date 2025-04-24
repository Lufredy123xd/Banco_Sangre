<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diferimento extends Model
{
    private string $motivo;
    private \DateTime $fechaDiferimiento;
    private string $tipo; // tipoDiferimiento
    private int $tiempoEnMeses;

}
