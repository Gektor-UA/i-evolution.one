<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purse extends Model
{
    use HasFactory;

    const I_HEALTH_PURSE = 1;

    protected $table = 'fl_purses';
    protected $fillable = ['user_id', 'amount','wallet_type', 'percent'];
}
