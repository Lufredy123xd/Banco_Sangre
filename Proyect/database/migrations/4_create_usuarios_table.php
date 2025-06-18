<?php

use App\Enums\Curso;
use App\Enums\EstadoUsuario;
use App\Enums\TipoUsuario;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->integer('cedula')->unique();
            $table->enum('tipo_usuario', array_column(TipoUsuario::cases(), 'value')); // Tipo de usuario: Administrador, Estudiante.
            $table->date('fecha_nacimiento');
            $table->enum('curso_hemoterapia', array_column(Curso::cases(), 'value'))->nullable(); // Curso de hemoterapia
            $table->string('user_name')->unique();
            $table->string('password');
            $table->enum('estado', array_column(EstadoUsuario::cases(), 'value')); // Estado del usuario
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};