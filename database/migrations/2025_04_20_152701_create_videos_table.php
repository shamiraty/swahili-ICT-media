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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->date('uploadedDate')->default(now());
            $table->string('lengthHours')->nullable();
            $table->string('headingTitle')->nullable();
            $table->string('video')->nullable();
            $table->string('targetAudience')->nullable();
            $table->text('comment')->nullable();
            $table->string('Author')->nullable();
            $table->string('References')->nullable();
            $table->string('uploaded_by')->default('sameer');
            $table->string('thumbnail')->nullable();
            $table->integer('size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};