
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
        // Pivot table for excluded origin countries
        Schema::create('plan_pais_origen_excluido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->foreignId('pais_id')->constrained('pais')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['plan_id', 'pais_id']);
        });

        // Pivot table for excluded destination countries
        Schema::create('plan_pais_destino_excluido', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->onDelete('cascade');
            $table->foreignId('pais_id')->constrained('pais')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['plan_id', 'pais_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_pais_origen_excluido');
        Schema::dropIfExists('plan_pais_destino_excluido');
    }
};
