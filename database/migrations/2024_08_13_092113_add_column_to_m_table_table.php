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
        Schema::table('m_table', function (Blueprint $table) {
            $table->string('table_type')->after('table_number');
            $table->string('status')->comment('reserved'|'available'|'unpaid')->default('available');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_table', function (Blueprint $table) {
            $table->dropColumn('table_type');
            $table->dropColumn('status');
        });
    }
};
