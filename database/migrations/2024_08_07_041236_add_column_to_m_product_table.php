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
            $table->string('unit_name')->after('price');
            $table->string('unit_type')->after('unit_name');
            $table->decimal('vat_fee', 8, 2)->nullable()->after('unit_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_product', function (Blueprint $table) {
            $table->dropColumn('unit_name');
            $table->dropColumn('unit_type');
            $table->dropColumn('vat_fee');
        });
    }
};
