<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donantes', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('apellido');
            $table->integer('cedula')->unique();
            $table->enum('sexo', ['M', 'F']); // Sexo: Masculino (M) o Femenino (F)
            $table->string('telefono');
            $table->date('fecha_nacimiento');
            $table->string('ABO'); // Grupo sanguíneo (A, B, AB, O)
            $table->string('RH'); // Factor RH (+ o -)
            $table->string('estado'); // Estado del donante (activo, inactivo, etc.)
            $table->text('observaciones')->nullable(); // Observaciones adicionales
            $table->timestamp('ultima_modificacion')->nullable(); // Última modificación
            //$table->foreignId('modificado_por')->nullable()->constrained('usuarios')->onDelete('set null'); // Relación con Usuario

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donantes');
    }
};
