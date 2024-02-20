<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;

    const STATUS_CONFIRM = 1;
    const STATUS_CANCELLED = 2;
    const STATUS_PENDING = 3;

    protected $table = 'withdraws';

    protected $fillable = [
        'user_id',
        'amount',
        'status',
        'wallet',
        'wallet_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
