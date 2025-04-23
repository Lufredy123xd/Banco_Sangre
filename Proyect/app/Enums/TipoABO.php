<?php

namespace App\Enums;

enum TipoABO: string
{
    case APositivo = 'A';
    case ANegativo = 'A';
    case BPositivo = 'B';
    case BNegativo = 'B';
    case ABPositivo = 'AB';
    case ABNegativo = 'AB';
    case OPositivo = 'O';
    case ONegativo = 'O';
}
