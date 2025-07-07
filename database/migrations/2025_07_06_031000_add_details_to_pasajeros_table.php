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
        Schema::table('pasajeros', function (Blueprint $table) {
            $table->string('nombre')->nullable()->after('edad');
            $table->string('apellido')->nullable()->after('nombre');
            $table->date('fecha_nacimiento')->nullable()->after('apellido');
            $table->string('tipo_documento')->nullable()->after('fecha_nacimiento');
            $table->string('numero_documento')->nullable()->after('tipo_documento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pasajeros', function (Blueprint $table) {
            //
        });
    }
};
