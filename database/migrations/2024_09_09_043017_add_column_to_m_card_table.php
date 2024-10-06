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
        Schema::table('m_card_table', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('id');
            $table->bigInteger('shop_id')->unsigned()->nullable()->change();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('m_shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_card_table', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['shop_id']);

            $table->dropColumn('company_id');
            $table->bigInteger('shop_id')->unsigned()->nullable(false)->change();
        });
    }
};
