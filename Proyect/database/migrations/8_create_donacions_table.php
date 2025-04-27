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
        Schema::create('donacions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_donante')->constrained('donantes'); // Relación con Donante
            $table->integer('donaciones_registradas')->default(0); // Número de donaciones registradas
            $table->boolean('reacciones_adversas')->default(false); // Reacciones adversas (sí/no)
            $table->date('fecha'); // Fecha de la donación
            $table->string('serologia'); // Serología
            $table->string('anticuerpos_irregulares'); // Anticuerpos irregulares
            $table->string('clase_donacion'); // Clase de donación (por ejemplo, sangre completa, plaquetas, etc.)
           

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donacions');
    }
};
