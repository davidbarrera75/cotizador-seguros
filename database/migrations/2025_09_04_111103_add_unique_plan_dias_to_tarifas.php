<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tarifas', function (Blueprint $table) {
            $table->unique(['plan_id', 'dias'], 'tarifas_plan_dias_unique');
        });
    }

    public function down(): void
    {
        Schema::table('tarifas', function (Blueprint $table) {
            $table->dropUnique('tarifas_plan_dias_unique');
        });
    }
};
