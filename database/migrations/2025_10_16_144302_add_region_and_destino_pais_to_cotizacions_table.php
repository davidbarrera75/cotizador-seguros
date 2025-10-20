<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            // Agregar nuevos campos
            $table->foreignId('region_id')->nullable()->after('destino_id')->constrained('regions')->onDelete('set null');
            $table->foreignId('destino_pais_id')->nullable()->after('region_id')->constrained('pais')->onDelete('set null');
            $table->foreignId('origen_pais_id')->nullable()->after('destino_pais_id')->constrained('pais')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropForeign(['region_id']);
            $table->dropForeign(['destino_pais_id']);
            $table->dropForeign(['origen_pais_id']);
            $table->dropColumn(['region_id', 'destino_pais_id', 'origen_pais_id']);
        });
    }
};
