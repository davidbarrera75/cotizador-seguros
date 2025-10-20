<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            // Tasa de 1 USD en COP
            $table->decimal('usd_cop_rate', 12, 4)->default(4000.0000);
            $table->timestamps();
        });

        // Crea un registro inicial si no existe
        DB::table('app_settings')->insert([
            'usd_cop_rate' => 4000.0000,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('app_settings');
    }
};
