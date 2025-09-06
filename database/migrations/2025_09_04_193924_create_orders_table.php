<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cotizacion_id')->constrained('cotizacions')->cascadeOnDelete();
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();
            $table->foreignId('aseguradora_id')->nullable()->constrained('aseguradoras')->nullOnDelete();

            $table->string('estado', 20)->default('creada'); // creada | enviada_wa | pagada | cancelada (lo que uses)
            $table->string('moneda', 3)->default('COP');     // COP | USD
            $table->decimal('precio', 12, 2)->nullable();
            $table->decimal('tasa_usd_cop', 12, 4)->nullable();

            $table->string('admin_whatsapp', 32)->nullable();

            // Snapshot de datos útiles
            $table->string('cliente_nombre')->nullable();
            $table->string('cliente_email')->nullable();
            $table->string('cliente_telefono')->nullable();

            $table->string('destino')->nullable();
            $table->string('tipo_viaje')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->date('fecha_regreso')->nullable();
            $table->unsignedInteger('pasajeros_count')->default(0);

            $table->json('pasajeros_payload')->nullable();   // guarda lo que enviaste en el checkout (opcional)
            $table->text('whatsapp_message')->nullable();
            $table->timestamp('sent_to_whatsapp_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
