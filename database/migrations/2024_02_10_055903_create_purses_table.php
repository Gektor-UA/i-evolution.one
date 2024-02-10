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
        Schema::create('purses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('amount', 17, 8)->default(0);
            $table->string('walletID', 255)->default('');
            $table->string('wallet', 512)->default('');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('percent')->default(0);
            $table->integer('wallet_type')->default(1);
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purses');
    }
};
