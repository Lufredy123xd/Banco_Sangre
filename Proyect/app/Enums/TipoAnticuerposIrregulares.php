<?php

namespace App\Enums;

enum TipoAnticuerposIrregulares: string
{
    case SinDatos = 'Sin Datos';
    case anticuerpoNegativo = 'Negativo';
    case anticuerpoPositivo = 'Positivo';
    
}
