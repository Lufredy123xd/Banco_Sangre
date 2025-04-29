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
        Schema::create('diferimentos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_donante')->constrained('donantes'); // Relación con Donante

            $table->string('motivo')->comment('Motivo del diferimiento');
            $table->date('fecha_diferimiento')->comment('Fecha del diferimiento');
            $table->string('tipo')->comment('Tipo de diferimiento');
            $table->integer('tiempo_en_meses')->comment('Tiempo en meses del diferimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diferimentos');
    }
};
