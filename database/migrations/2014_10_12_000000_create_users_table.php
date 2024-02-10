<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('messenger')->nullable()->default('');
            $table->dateTime('birthday')->nullable();
            $table->string('referrer_hash');
            $table->string('twofa_secret')->nullable();
            $table->string('avatar')->nullable();
            $table->timestamp('start_promo')->nullable();
            $table->string('achieved_promo_level')->default('');
            $table->boolean('verification_withdrawal')->default(0);
            $table->boolean('verification_tariff_closing')->default(0);
            $table->tinyInteger('role_id')->default(0);
            $table->integer('achived_turnover')->default(0);
            $table->boolean('is_ambassador')->default(0);
            $table->timestamp('ambassador_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
