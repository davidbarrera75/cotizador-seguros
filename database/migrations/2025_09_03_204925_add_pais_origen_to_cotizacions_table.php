<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            if (!Schema::hasColumn('cotizacions', 'pais_origen')) {
                $table->string('pais_origen', 2)
                      ->default('CO')
                      ->after('tipo_viaje_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            if (Schema::hasColumn('cotizacions', 'pais_origen')) {
                $table->dropColumn('pais_origen');
            }
        });
    }
};
