<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    const REFILL = 1;
    const WITHDRAWAL = 2;
    const SINGLE_REFERRAL_BONUS = 3;

    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'type_transaction',
        'amount',
        'purses_type',
    ];
}
