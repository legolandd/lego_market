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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lego_set_id')->constrained('lego_sets')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('pros')->nullable()->comment('Достоинства');
            $table->text('cons')->nullable()->comment('Недостатки');
            $table->text('comment')->nullable()->comment('Комментарий пользователя');
            $table->unsignedTinyInteger('rating')->comment('Рейтинг от 1 до 5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
