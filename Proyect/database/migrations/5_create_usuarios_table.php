<?php 
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
            $table->enum('tipo_usuario', ['Administrador', 'Docente', 'Estudiante', 'Funcionario']);
            $table->date('fecha_nacimiento');
            $table->string('curso_hemoterapia')->nullable();
            $table->string('user_name')->unique();
            $table->string('password');
            $table->enum('estado', ['Activo', 'Inactivo', 'Suspendido']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};