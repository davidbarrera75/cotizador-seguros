<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            // Ya debe existir 'descuento' (decimal 5,2). Si no, créalo antes.
            $table->decimal('rating', 2, 1)->nullable()->after('descuento');
            $table->string('cobertura_pdf_path')->nullable()->after('rating');
            $table->longText('cobertura')->nullable()->after('cobertura_pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['rating', 'cobertura_pdf_path', 'cobertura']);
        });
    }
};
