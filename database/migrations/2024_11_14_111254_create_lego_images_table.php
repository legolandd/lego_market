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
        Schema::create('lego_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lego_set_id')->constrained('lego_sets')->onDelete('cascade');
            $table->string('image_url')->comment('Путь к изображению');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lego_images');
    }
};
