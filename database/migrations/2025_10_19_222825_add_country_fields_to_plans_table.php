
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
        Schema::table('plans', function (Blueprint $table) {
            $table->boolean('aplica_todos_paises_origen')->default(true)->after('activo');
            $table->boolean('aplica_todos_paises_destino')->default(true)->after('aplica_todos_paises_origen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['aplica_todos_paises_origen', 'aplica_todos_paises_destino']);
        });
    }
};
