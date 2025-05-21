<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Enums\TipoABO;
use App\Enums\TipoRH;
use App\Enums\EstadoDonante;
use Carbon\Carbon;

class DonantesSeeder extends Seeder
{
    public function run(): void
    {
        $nombres = ['Juan', 'María', 'Pedro', 'Lucía', 'Carlos', 'Ana', 'Luis', 'Sofía', 'Diego', 'Camila'];
        $apellidos = ['González', 'Rodríguez', 'Pérez', 'Fernández', 'López', 'Martínez', 'Gómez', 'Sánchez', 'Díaz', 'Torres'];

        for ($i = 0; $i < 20; $i++) {
            DB::table('donantes')->insert([
                'nombre' => $nombres[array_rand($nombres)],
                'apellido' => $apellidos[array_rand($apellidos)],
                'cedula' => rand(10000000, 99999999),
                'sexo' => rand(0, 1) ? 'M' : 'F',
                'telefono' => '09' . rand(1000000, 9999999),
                'fecha_nacimiento' => Carbon::now()->subYears(rand(18, 60))->subDays(rand(0, 365)),
                'ABO' => TipoABO::cases()[array_rand(TipoABO::cases())]->value,
                'RH' => TipoRH::cases()[array_rand(TipoRH::cases())]->value,
                'estado' => EstadoDonante::cases()[array_rand(EstadoDonante::cases())]->value,
                'observaciones' => rand(0, 1) ? 'Ninguna observación' : null,
                'ultima_modificacion' => now(),
                'modificado_por' => null, // Puedes cambiar esto si tienes usuarios
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
