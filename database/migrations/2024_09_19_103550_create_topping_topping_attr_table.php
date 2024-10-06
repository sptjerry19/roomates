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
        Schema::create('topping_topping_attr', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('topping_id');
            $table->unsignedBigInteger('topping_attr_id');

            $table->foreign('topping_id')->references('id')->on('m_topping')->onDelete('cascade');
            $table->foreign('topping_attr_id')->references('id')->on('m_topping_attr')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topping_topping_attr');
    }
};
