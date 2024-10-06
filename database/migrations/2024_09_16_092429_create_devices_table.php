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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable(); // Công ty
            $table->unsignedBigInteger('shop_id')->nullable(); // Chi nhánh
            $table->string('device_name'); // Tên thiết bị
            $table->enum('device_type', ['POS', 'PDA', 'KDS']); // Loại thiết bị
            $table->string('device_code')->nullable(); // Mã thiết bị
            $table->string('ip_address')->nullable(); // Địa chỉ IP local
            $table->string('version')->nullable(); // Phiên bản
            $table->string('machine_serial_number')->nullable(); // Mã gói gửi
            $table->timestamp('last_update')->useCurrent(); // Thời gian cập nhật
            $table->enum('machine_type', ['Server', 'Workstation'])->default('Server'); // Loại máy
            $table->enum('configure_KDS_notification', ['Not_displayed', 'Notifications_KDS_device', 'All_notifications'])->default('Not_displayed'); // Cấu hình hiện thông báo KDS
            $table->unsignedBigInteger('setting_area_id')->nullable(); // cấu hình khu vực
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('m_shop')->onDelete('cascade');
            $table->foreign('setting_area_id')->references('id')->on('setting_areas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
