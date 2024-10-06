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
        Schema::create('cost_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->enum('option', ['S', 'M', 'L', 'XL', 'XXL', 'XXXL']);

            $table->unsignedBigInteger('merchandise_id');
            $table->decimal('quantity', 8, 2);
            $table->decimal('expense', 8, 2);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('m_product')->onDelete('cascade');
            $table->foreign('merchandise_id')->references('id')->on('merchandises')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cost_products');
    }
};
