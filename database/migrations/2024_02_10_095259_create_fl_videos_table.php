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
        Schema::create('fl_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('video_url')->nullable();
            $table->string('file_path')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_approved')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fl_videos');
    }
};
