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
            $table->dateTime('birthday')->nullable();
            $table->string('referrer_hash');
            $table->string('twofa_secret')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('verification_withdrawal');
            $table->boolean('verification_tariff_closing');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

//        DB::table('users')->insert([
//            [
//                'id' => 1,
//                'first_name' => 'Eugen',
//                'last_name' => 'Qwerty',
//                'email' => 'whitefallenangel@gmail.com',
//                'phone' => '',
//                'messenger' => '',
//                'birthday' => '1970-01-01 00:00:00',
//                'referrer_hash' => 'vnRB7vBS66',
//                'twofa_secret' => null,
//                'avatar' => 'avatars/6I8Ce7KPlNykDiY3DsNIVbsHaCmlmFauDZpWQkel.png',
//                'start_promo' => null,
//                'achieved_promo_level' => '',
//                'verification_withdrawal' => 0,
//                'verification_tariff_closing' => 0,
//                'role_id' => 0,
//                'achived_turnover' => 7475,
//                'is_ambassador' => 1,
//                'ambassador_date' => null,
//                'email_verified_at' => null,
//                'password' => '$2y$10$Gr/QjDCUMYqiinv4ucRqJ./txrrxKAO/46CyyKI45dq5ByY9Yrp6G',
//                'remember_token' => null,
//                'created_at' => '2024-02-09 06:49:14',
//                'updated_at' => '2024-02-09 06:49:14',
//            ],
//            [
//                'id' => 2,
//                'first_name' => 'Henry',
//                'last_name' => 'HHHH',
//                'email' => 'ik4863534+500@gmail.com',
//                'phone' => null,
//                'messenger' => '',
//                'birthday' => null,
//                'referrer_hash' => 'e19GbkczK6',
//                'twofa_secret' => null,
//                'avatar' => '',
//                'start_promo' => null,
//                'achieved_promo_level' => '',
//                'verification_withdrawal' => 0,
//                'verification_tariff_closing' => 0,
//                'role_id' => 0,
//                'achived_turnover' => 5000,
//                'is_ambassador' => 1,
//                'ambassador_date' => null,
//                'email_verified_at' => null,
//                'password' => '$2y$10$St4FzmOHcvb/XCTnW/fWpOBBeVfSzIdM4wHlG.gTLPVqfoidEQZZG',
//                'remember_token' => null,
//                'created_at' => '2024-02-09 06:49:14',
//                'updated_at' => '2024-02-09 06:49:14',
//            ],
//        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
