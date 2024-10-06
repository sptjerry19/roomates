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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Tự động thêm cột id (bigint unsigned)
            $table->string('name', 255)->nullable()->default(null);
            $table->string('company_name', 255)->nullable()->default(null);
            $table->string('representative_name', 255)->nullable()->default(null);
            $table->string('office_name', 255)->nullable()->default(null);
            $table->string('phone', 255)->nullable()->default(null);
            $table->string('address', 255)->nullable()->default(null);
            $table->string('email', 255)->nullable()->default(null);
            $table->string('relevant_emails', 255)->nullable()->default(null);
            $table->string('position', 255)->nullable()->default(null);
            $table->string('tax_code', 255)->nullable()->default(null);
            $table->string('fax', 255)->nullable()->default(null);
            $table->string('bank_account_number', 255)->nullable()->default(null);
            $table->string('bank_account_name', 255)->nullable()->default(null);
            $table->string('bank', 255)->nullable()->default(null);
            $table->string('logo', 255)->nullable()->default(null);
            $table->string('note', 255)->nullable()->default(null);
            $table->double('commission_percent', 8, 2)->default(0.00);
            $table->decimal('balance', 20, 2)->default(0.00);
            $table->boolean('display_price')->default(true);
            $table->tinyInteger('status')->nullable()->default(null);
            $table->timestamps(); // Tạo cột created_at và updated_at với timestamp
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
