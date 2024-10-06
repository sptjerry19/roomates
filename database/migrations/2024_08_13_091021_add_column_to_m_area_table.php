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
        Schema::table('m_area', function (Blueprint $table) {
            $table->string('area_code')->after('name')->nullable();
            $table->unsignedBigInteger('shop_id')->after('user_id');
            $table->integer('stt')->after('shop_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_area', function (Blueprint $table) {
          $table->dropColumn('area_code');
          $table->dropColumn('shop_id');
          $table->dropColumn('stt');
        });
    }
};
