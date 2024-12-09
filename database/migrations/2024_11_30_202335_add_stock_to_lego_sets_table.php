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
        Schema::table('lego_sets', function (Blueprint $table) {
            $table->integer('stock')->default(0)->after('discount')->comment('Количество на складе');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lego_sets', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
