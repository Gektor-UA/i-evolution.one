<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusClosingProgram extends Model
{
    use HasFactory;

    protected $table = 'fl_bonus_closing_program';
    protected $fillable = [
        'user_id',
        'referral_id',
        'program_id',
    ];
}
