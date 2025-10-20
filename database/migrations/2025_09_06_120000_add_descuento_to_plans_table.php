<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // porcentaje 0–100 con 2 decimales, por defecto 0.00
            $table->decimal('descuento', 5, 2)->default(0)->after('edad_maxima');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('descuento');
        });
    }
};
