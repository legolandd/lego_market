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
        Schema::create('lego_sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->comment('Описание LEGO набора');
            $table->foreignId('series_id')->constrained('lego_series')->onDelete('cascade');
            $table->decimal('price', 8, 2);
            $table->integer('recommended_age')->comment('Рекомендуемый возраст');
            $table->integer('piece_count')->comment('Количество деталей');
            $table->boolean('is_new')->default(true)->comment('Флаг новинки');
            $table->boolean('is_sale')->default(false)->comment('Флаг распродажи');
            $table->integer('discount')->nullable()->comment('Процент скидки');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lego_sets');
    }
};
