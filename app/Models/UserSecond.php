<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSecond extends Model
{
    use HasFactory;

    protected $connection = 'second_mysql'; // Встановлення підключення до другої бази даних
    protected $table = 'users'; // Назва таблиці в другій базі даних

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'birthday',
        'referrer_hash',
        'twofa_secret',
        'avatar',
        'verification_withdrawal',
        'verification_tariff_closing',
        'role_id',
        'achived_turnover',
        'is_ambassador',
    ];

}
