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
        Schema::table('m_topping_attr', function (Blueprint $table) {
            $table->renameColumn('value', 'name');
            $table->string('image')->after('price')->nullable();
            $table->dropColumn('topping_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('m_topping_attr', function (Blueprint $table) {
            $table->renameColumn('name', 'value');
            $table->dropColumn('image');
            $table->unsignedBigInteger('topping_id');
        });
    }
};
