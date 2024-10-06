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
        Schema::table('m_option', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('name');
            $table->unsignedBigInteger('shop_id')->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_option', function (Blueprint $table) {
           $table->dropColumn('shop_id');
        });
    }
};
