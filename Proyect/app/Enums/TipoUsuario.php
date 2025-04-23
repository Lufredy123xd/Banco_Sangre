<?php

namespace App\Enums;

enum TipoUsuario: string
{
    case Administrador = 'Administrador';
    case Docente = 'Docente';
    case Estudiante = 'Estudiante';
    case Funcionario = 'Funcionario';
}
