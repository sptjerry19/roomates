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
        Schema::create('m_order', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->decimal('total_price', 10, 3);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('usage_type_id');
            $table->unsignedTinyInteger('status')->default(2)->comment('1: draft; 2: pending; 3:completed; 4:cancelled');
            $table->unsignedTinyInteger('pay_by')->comment('1: Cash; 2: Bank transfer; 3: Momo; 4:Credit card')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_order');
    }
};
