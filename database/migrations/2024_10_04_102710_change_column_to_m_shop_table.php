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
        Schema::table('m_shop', function (Blueprint $table) {
            $table->enum('auto_change_pin', [
                'none',  // No automatic PIN change when in use
                'once',  // PIN can only be used once
                '1min',  // After 1 minute of use, change the PIN
                '2min',  // After 2 minutes of use, change the PIN
            ])->change();

            // Remove the vouncher_id column
            $table->dropColumn('voucher_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_shop', function (Blueprint $table) {
            // Reverse the auto_change_pin changes
            $table->boolean('auto_change_pin')->default(false)->change();

            // Add back the vouncher_id column
            $table->string('voucher_id')->nullable();
        });
    }
};
