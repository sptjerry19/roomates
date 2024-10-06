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
        Schema::table('t_order_attr_product', function (Blueprint $table) {
            $table->string('status')->default('active')->comment('active|cancelled');
            $table->string('reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_order_attr_product', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('reason');
        });
    }
};
