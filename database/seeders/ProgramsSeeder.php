<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('fl_programs')->insert([
            [
                'program_name' => 'Program 70$',
                'first_amount' => '25',
                'second_amount' => '20',
                'third_amount' => '15',
                'income_program' => '70',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_name' => 'Program 140$',
                'first_amount' => '50',
                'second_amount' => '40',
                'third_amount' => '30',
                'income_program' => '140',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'program_name' => 'Program 420$',
                'first_amount' => '145',
                'second_amount' => '120',
                'third_amount' => '90',
                'income_program' => '420',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
