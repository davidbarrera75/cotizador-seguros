<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('slider_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');              // ruta en storage
            $table->string('title')->nullable();  // opcional (caption)
            $table->string('alt')->nullable();    // texto alternativo
            $table->unsignedTinyInteger('sort')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_images');
    }
};
