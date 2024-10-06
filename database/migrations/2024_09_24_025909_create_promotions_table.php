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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name'); // Tên chương trình KM
            $table->unsignedTinyInteger('discount'); // Phần trăm giảm giá hoặc tiền giảm giá
            $table->date('start_date'); // Ngày bắt đầu
            $table->date('end_date')->nullable(); // Ngày kết thúc
            $table->json('time_slots')->nullable(); // Các khung giờ bắt đầu và kết thúc dạng JSON
            $table->json('days_of_week')->nullable(); // Các ngày trong tuần áp dụng
            $table->enum('status', ['active', 'inactive'])->default('active'); // Trạng thái
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
