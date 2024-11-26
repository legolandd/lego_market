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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('delivery_method', ['courier', 'pickup'])->default('courier')->comment('Способ получения');
            $table->decimal('total_price', 10, 2)->comment('Итоговая стоимость заказа');
            $table->enum('status', ['new', 'processing', 'delivered'])->default('new')->comment('Статус заказа');
            $table->string('address')->comment('Адрес доставки');
            $table->date('delivery_date')->comment('Дата доставки');
            $table->string('delivery_time')->comment('Время доставки');
            $table->enum('payment_method', ['cash', 'card'])->comment('Способ оплаты');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
