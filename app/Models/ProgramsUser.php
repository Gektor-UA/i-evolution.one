<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramsUser extends Model
{
    use HasFactory;

    protected $table = 'fl_programs_user';

    protected $fillable = [
        'user_id',
        'program_id',
        'first_withdrawal',
        'second_withdrawal',
        'third_withdrawal',
        'payment_program',
    ];
}
