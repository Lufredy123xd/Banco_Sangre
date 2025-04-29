<?php

namespace App\Enums;

enum EstadoDonante: string
{
    case Disponible = 'Disponible';
    case No_Disponible = 'No Disponible';
    case Pendiente = 'Pendiente';
    case Notificado = 'Notificado';
    case Agendado = 'Agendado';
    case ParaActializar = 'Para Actualizar';
}
