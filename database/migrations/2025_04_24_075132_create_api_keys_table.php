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
        Schema::create('api_keys', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Ensure usernames are unique
            $table->string('password'); // Hashed password
            $table->string('api_key')->unique();
            $table->date('end_date');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->enum('category', ['web_system', 'app'])->nullable();
            $table->timestamp('last_used')->nullable()->default(null); // Ongeza last_used
            $table->unsignedInteger('number_of_requests')->default(0); // Ongeza number_of_requests
            $table->boolean('status')->default(true); // Ongeza status
            $table->json('access_history')->nullable()->default(null); // Ongeza access_history kama JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_keys');
    }
};