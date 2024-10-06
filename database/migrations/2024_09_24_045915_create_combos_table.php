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
        Schema::create('combos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->decimal('vat', 5, 2)->default(0);
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->date('start_date')->nullable(); // Ngày bắt đầu
            $table->date('end_date')->nullable(); // Ngày kết thúc
            $table->json('time_slots')->nullable(); // Các khung giờ bắt đầu và kết thúc dạng JSON
            $table->json('days_of_week')->nullable(); // Các ngày trong tuần áp dụng
            $table->boolean('status')->default(true); // Trạng thái combo
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('combos');
    }
};
