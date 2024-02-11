<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Додавання до таблиці users поля де буде зберігатися значення бонусу нараховано чи ні (20$)
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('bonus_processed')->default(false)->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
