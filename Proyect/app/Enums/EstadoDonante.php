<?php

namespace App\Enums;

enum EstadoDonante: string
{
    case Activo = 'Activo';
    case Inactivo = 'Inactivo';
    case Suspendido = 'Suspendido';
}
