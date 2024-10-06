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
        Schema::table('m_order', function (Blueprint $table) {
            $table->unsignedBigInteger('shipper_id')->after('customer_id')->nullable();
            $table->string('phone_customer')->nullable()->after('shipper_id');
            $table->string('name_customer')->nullable()->after('phone_customer');
            $table->string('address')->nullable()->after('name_customer');
            $table->string('note')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_order', function (Blueprint $table) {
            $table->dropColumn('shipper_id');
            $table->dropColumn('phone_customer');
            $table->dropColumn('name_customer');
            $table->dropColumn('address');
            $table->dropColumn('note');
        });
    }
};
