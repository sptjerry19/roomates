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
        Schema::table('m_order_attr_product_topping', function (Blueprint $table) {
            $table->unsignedBigInteger('order_attr_product_id')->after('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_order_attr_product_topping', function (Blueprint $table) {
            $table->dropColumn('order_attr_product_id');
        });
    }
};
