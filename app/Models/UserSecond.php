<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSecond extends Model
{
    use HasFactory;

    protected $connection = 'second_mysql'; // Встановлення підключення до другої бази даних
    protected $table = 'users'; // Назва таблиці в другій базі даних



}
