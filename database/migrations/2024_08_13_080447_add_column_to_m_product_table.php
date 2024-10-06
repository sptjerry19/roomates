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
        Schema::table('m_product', function (Blueprint $table) {
            $table->string('product_code')->after('name');
            $table->unsignedBigInteger('shop_id')->after('user_id');
            $table->decimal('vat_fee', 10, 3)->change()->nullable()->after('unit_type');
            $table->string('description')->after('image');
            $table->string('status')->comment('active|no_active')->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_product', function (Blueprint $table) {
            $table->dropColumn('product_code');
            $table->dropColumn('shop_id');
            $table->decimal('vat_fee', 8, 2)->nullable()->after('unit_type')->change();
            $table->unsignedTinyInteger('status')->default(1)->change();
            $table->dropColumn('description');
        });
    }
};
