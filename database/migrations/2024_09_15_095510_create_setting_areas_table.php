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
        Schema::create('setting_areas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('columns')->nullable();
            $table->boolean('area_management')->default(true);
            $table->boolean('activate_screen_2')->default(true);
            $table->boolean('display_button_POS')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting_areas');
    }
};
