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
        Schema::table('m_order_dine_in', function (Blueprint $table) {
            $table->unsignedBigInteger('card_table_id')->after('table_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable()->change();
            $table->unsignedBigInteger('table_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_order_dine_in', function (Blueprint $table) {
            $table->dropColumn('card_table_id');
            $table->unsignedBigInteger('area_id')->change();
            $table->unsignedBigInteger('table_id')->change();
        });
    }
};
