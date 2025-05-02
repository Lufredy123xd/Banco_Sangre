<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TipoABO;
use App\Enums\TipoRH;
use App\Enums\EstadoDonante;

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
            $table->enum('ABO', array_column(TipoABO::cases(), 'value')); // Grupo sanguíneo (A, B, AB, O)
            $table->enum('RH', array_column(TipoRH::cases(), 'value')); // Factor RH (+ o -)
            $table->enum('estado', array_column(EstadoDonante::cases(), 'value')); // Estado del donante
            $table->string('observaciones', 255)->nullable(); // Observaciones adicionales
            $table->timestamp('ultima_modificacion')->nullable(); // Última modificación
            $table->foreignId('modificado_por')->nullable()->constrained('usuarios')->onDelete('set null'); // Relación con Usuario

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
