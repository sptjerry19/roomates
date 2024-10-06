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
            $table->string('status')->default('pending')->comment('draft|pending|completed|cancelled')->change();
            $table->string('pay_by_id')->comment('Cash|Bank transfer|Momo|Credit card')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_order', function (Blueprint $table) {
            $table->unsignedTinyInteger('status')->default(2)->comment('1: draft; 2: pending; 3:completed; 4:cancelled')->change();
            $table->unsignedTinyInteger('pay_by')->comment('1: Cash; 2: Bank transfer; 3: Momo; 4:Credit card')->nullable()->change();
        });
    }
};
