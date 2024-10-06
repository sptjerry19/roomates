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
            $table->boolean('status')->nullable()->default(true)->after('stt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_area', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
