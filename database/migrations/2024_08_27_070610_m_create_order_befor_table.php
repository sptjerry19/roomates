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
        Schema::create('m_order_befor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name_customer');
            $table->string('phone_customer');
            $table->string('number');
            $table->string('deposit')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->date('date');
            $table->dateTime('arrival_date_time');
            $table->text('note')->nullable();
            $table->string('status')->comment('received|no_received')->default('no_received');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_order_befor');
    }
};
