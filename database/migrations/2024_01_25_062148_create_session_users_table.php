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
        Schema::create('session_users', function (Blueprint $table) {
            $table->id();
            $table->string('token',500)->nullable(); 
            $table->string('refresh_token',500)->nullable(); 
            $table->string(column: 'token_expried');
            $table->string(column: 'refresh_token_expried');
            $table->bigInteger(column: 'user_id');
            $table->timestamps();
        });
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_users');
    }
};
