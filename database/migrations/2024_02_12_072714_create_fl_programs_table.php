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
        Schema::create('fl_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->integer('first_amount');
            $table->integer('second_amount');
            $table->integer('third_amount');
            $table->integer('income_program');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fl_programs');
    }
};
