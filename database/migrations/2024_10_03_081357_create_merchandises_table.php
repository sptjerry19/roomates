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
        Schema::create('merchandises', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id'); // Công ty
            $table->unsignedBigInteger('user_id'); // Người tạo
            $table->string('image')->nullable(); // Ảnh hàng hóa
            $table->string('name'); // Tên hàng hóa
            $table->string('code')->unique(); // Mã hàng hóa
            $table->enum('type', ['Raw_materials', 'Finished_product', 'Semi_finished_products', 'Direct_sale'])->default('Raw_materials'); // Loại hàng hóa
            $table->unsignedBigInteger('unit_id'); // Đơn vị tính
            $table->unsignedBigInteger('commodity_id')->nullable(); // Nhóm hàng hóa
            $table->decimal('unit_price', 15, 2)->nullable(); // Đơn giá
            $table->text('description')->nullable(); // Mô tả
            $table->boolean('tracking_status')->default(true); // Trạng thái theo dõi
            $table->boolean('status')->default(true); // Trạng thái hàng hóa

            $table->decimal('purchase_price', 15, 2)->nullable(); // Giá nhập
            $table->decimal('sale_price', 15, 2)->nullable(); // Giá bán
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchandises');
    }
};
