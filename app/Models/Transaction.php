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
    const WITHDRAWAL_PACKAGE = 4;
    const PAYMENT_BY_PACKAGE = 5;
    const WITHDRAWAL_PACKAGE_PENALTY = 6;
    const REFERRAL_INTEREST_FIRST_LINE = 7;
    const REFERRAL_INTEREST_SECOND_LINE = 8;
    const REFERRAL_INTEREST_THIRD_LINE = 9;

    const FIRST_BONUS_AMBASSADOR_FIRST_LINE = 10;
    const FIRST_BONUS_AMBASSADOR_SECOND_LINE = 11;
    const FIRST_BONUS_AMBASSADOR_THIRD_LINE = 12;
    const FIRST_BONUS_AMBASSADOR_FOURTH_LINE = 13;
    const FIRST_BONUS_AMBASSADOR_FIFTH_LINE = 14;
    const FIRST_BONUS_AMBASSADOR_SIXTH_LINE = 15;

    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'type_transaction',
        'amount',
        'purses_type',
    ];
}
