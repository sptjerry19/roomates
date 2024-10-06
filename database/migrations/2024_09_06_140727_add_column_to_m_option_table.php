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
            $table->boolean('allowed_dishes')->nullable()->default(false)->after('shop_id');
            $table->integer('allow_min')->nullable()->after('allowed_dishes');
            $table->integer('allow_max')->nullable()->after('allow_min');
            $table->boolean('status')->nullable()->default(true)->after('allow_max');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_option', function (Blueprint $table) {
            $table->dropColumn('allowed_dishes');
            $table->dropColumn('allow_min');
            $table->dropColumn('allow_max');
            $table->dropColumn('status');
        });
    }
};
