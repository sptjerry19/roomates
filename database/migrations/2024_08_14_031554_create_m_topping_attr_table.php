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
        Schema::create('m_topping_attr', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->decimal('price', 10, 3)->nullable();
            $table->unsignedBigInteger('topping_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_topping_attr');
    }
};
