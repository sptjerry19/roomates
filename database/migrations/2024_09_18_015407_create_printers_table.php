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
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('vendor_id');
            $table->enum('connection_type', ['USB', 'LAN', 'Sunmi', 'KDS'])->default('USB');
            $table->string('printer_type')->default('In hóa đơn');
            $table->integer('copies')->default(1);
            $table->integer('paper_size');
            $table->boolean('slip_printing')->default(false);
            $table->timestamps();

            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('printers');
    }
};
