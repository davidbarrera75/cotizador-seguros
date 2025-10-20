<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tarifa_import_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('filename')->nullable();
            $table->unsignedInteger('processed')->default(0);
            $table->unsignedInteger('valid')->default(0);
            $table->unsignedInteger('imported')->default(0);
            $table->unsignedInteger('skipped')->default(0);
            $table->unsignedInteger('errors')->default(0);
            // Usa json si tu motor lo soporta; si usas una versión vieja de MySQL, cámbialo por text()
            $table->json('messages')->nullable();
            $table->string('status')->default('processed'); // processed | queued | failed
            $table->timestamps();

            $table->index(['plan_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifa_import_logs');
    }
};
