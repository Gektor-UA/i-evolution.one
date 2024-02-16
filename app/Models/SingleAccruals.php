<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingleAccruals extends Model
{
    use HasFactory;

    protected $table = 'single_accruals';
    protected $fillable = [
        'user_id',
        'referral_id',
        'program_id',
    ];
}
