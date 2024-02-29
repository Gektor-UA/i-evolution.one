<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommissionRecord extends Model
{
    use HasFactory;

    protected $table = 'fl_commission_records';
    protected $fillable = [
        'user_id',
        'referral_id',
        'program_id',
    ];
}
