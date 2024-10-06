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
        Schema::table('source_values', function (Blueprint $table) {
            $table->decimal('menu_price_increase_percentage', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('source_values', function (Blueprint $table) {
            $table->decimal('menu_price_increase_percentage', 5, 2)->nullable()->change();
        });
    }
};
