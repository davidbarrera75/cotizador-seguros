<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->string('admin_whatsapp', 32)->nullable()->after('usd_cop_rate');
        });
    }

    public function down(): void
    {
        Schema::table('app_settings', function (Blueprint $table) {
            $table->dropColumn('admin_whatsapp');
        });
    }
};
