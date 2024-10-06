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
        Schema::table('m_order_befor', function (Blueprint $table) {
            $table->renameColumn('arrival_date_time', 'time');
        });

        Schema::table('m_order_befor', function (Blueprint $table) {
            $table->time('time')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_order_befor', function (Blueprint $table) {
            $table->renameColumn('time', 'arrival_date_time');
        });

        Schema::table('m_order_befor', function (Blueprint $table) {
            $table->dateTime('arrival_date_time')->change();
        });
    }
};
