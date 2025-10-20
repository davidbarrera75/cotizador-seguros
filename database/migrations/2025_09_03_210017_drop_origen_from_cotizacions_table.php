<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            if (Schema::hasColumn('cotizacions', 'origen')) {
                $table->dropColumn('origen');
            }
        });
    }

    public function down(): void
    {
        Schema::table('cotizacions', function (Blueprint $table) {
            if (!Schema::hasColumn('cotizacions', 'origen')) {
                $table->string('origen', 100)->nullable(); // lo restauramos como nullable
            }
        });
    }
};
