<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->string('contacto_emergencia_nombre')->nullable()->after('pais');
            $table->string('contacto_emergencia_telefono')->nullable()->after('contacto_emergencia_nombre');
            $table->string('contacto_emergencia_email')->nullable()->after('contacto_emergencia_telefono');
        });
    }

    public function down(): void
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->dropColumn([
                'contacto_emergencia_nombre',
                'contacto_emergencia_telefono',
                'contacto_emergencia_email',
            ]);
        });
    }
};
