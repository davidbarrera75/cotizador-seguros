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
        Schema::table('cotizacions', function (Blueprint $table) {
            // Esta línea añade la columna 'origen' de tipo texto.
            $table->string('origen')->nullable()->after('pais_origen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            // Esto es para poder revertir el cambio si es necesario.
            $table->dropColumn('origen');
        });
    }
};
