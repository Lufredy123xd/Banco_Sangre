<?php

namespace App\Enums;

enum TipoSerologia: string
{
    case SinDatos = 'Sin Datos';
    case NoReactivo = 'No Reactivo';
    case Reactivo = 'Reactivo';
    
}
