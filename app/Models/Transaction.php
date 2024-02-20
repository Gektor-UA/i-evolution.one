<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Поповнення балансу
    const REFILL = 1;
    // Вивід коштів
    const WITHDRAWAL = 2;

    // Константи для розміщення бонусів звичайних користувачів
    const SINGLE_REFERRAL_BONUS = 3;
    const WITHDRAWAL_PACKAGE = 4;
    const PAYMENT_BY_PACKAGE = 5;
    const WITHDRAWAL_PACKAGE_PENALTY = 6;
    const REFERRAL_INTEREST_FIRST_LINE = 7;
    const REFERRAL_INTEREST_SECOND_LINE = 8;
    const REFERRAL_INTEREST_THIRD_LINE = 9;

    // Константи для розміщення бонусів амбасадорів
    const FIRST_BONUS_AMBASSADOR_FIRST_LINE = 10;
    const FIRST_BONUS_AMBASSADOR_SECOND_LINE = 11;
    const FIRST_BONUS_AMBASSADOR_THIRD_LINE = 12;
    const FIRST_BONUS_AMBASSADOR_FOURTH_LINE = 13;
    const FIRST_BONUS_AMBASSADOR_FIFTH_LINE = 14;
    const FIRST_BONUS_AMBASSADOR_SIXTH_LINE = 15;
    const SECOND_BONUS_AMBASSADOR_FIRST_LINE = 16;
    const SECOND_BONUS_AMBASSADOR_SECOND_LINE = 17;
    const SECOND_BONUS_AMBASSADOR_THIRD_LINE = 18;
    const SECOND_BONUS_AMBASSADOR_FOURTH_LINE = 19;
    const SECOND_BONUS_AMBASSADOR_FIFTH_LINE = 20;
    const SECOND_BONUS_AMBASSADOR_SIXTH_LINE = 21;

    // Константа для розміщення бонусу кількості рефералів
    const BONUS_NUMBER_REFERRALS = 22;

    // Константа для нарахування бонусу по програмі "Швидкий старт"
    const QUICK_START = 23;

    // Константа для нарахування бонусу по програмі "Кількість амбасадорів"
    const AMBASSADORS = 24;

    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'type_transaction',
        'amount',
        'purses_type',
    ];
}
