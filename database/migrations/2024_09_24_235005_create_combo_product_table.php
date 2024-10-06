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
        Schema::create('combo_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('combo_id');
            $table->unsignedBigInteger('product_id');

            $table->decimal('price', 10, 2)->nullable();
            $table->integer('quanlity')->default(1);
            $table->json('options')->nullable();
            $table->json('toppings')->nullable();

            $table->foreign('combo_id')->references('id')->on('combos')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('m_product')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combo_product');
    }
};
