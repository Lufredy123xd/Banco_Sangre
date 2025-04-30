<?php

namespace App\Enums;

enum EstadoDonante: string
{
    case Disponible = 'Disponible';
    case No_Disponible = 'No Disponible'; //No diferido cambia a este estado
    case Pendiente = 'Pendiente';
    case Notificado = 'Notificado';
    case Agendado = 'Agendado';
    case ParaActializar = 'Para Actualizar';
}
