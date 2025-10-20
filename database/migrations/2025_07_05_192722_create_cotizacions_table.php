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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destino_id')->constrained();
            $table->foreignId('tipo_viaje_id')->constrained('tipo_viajes'); // <- corregido
            $table->string('origen');
            $table->date('fecha_salida');
            $table->date('fecha_regreso');
            $table->string('correo_contacto');
            $table->string('telefono_contacto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacions');
    }
};
