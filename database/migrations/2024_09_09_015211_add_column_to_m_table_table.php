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
            $table->unsignedInteger('quanlity')->default(1)->after('table_number');
            $table->enum('status', ['available', 'reserved', 'unpaid', 'locked'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_table', function (Blueprint $table) {
            $table->dropColumn('quanlity');
            $table->enum('status', ['available', 'reserved', 'unpaid'])->change();
        });
    }
};
