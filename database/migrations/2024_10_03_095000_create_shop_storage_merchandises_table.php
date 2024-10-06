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
        Schema::create('shop_storage_merchandises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchandise_id');
            $table->unsignedBigInteger('storage_id');
            $table->decimal('quantity', 8, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();

            $table->foreign('merchandise_id')->references('id')->on('merchandises')->onDelete('cascade');
            $table->foreign('storage_id')->references('id')->on('m_shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_storage_merchandises');
    }
};
