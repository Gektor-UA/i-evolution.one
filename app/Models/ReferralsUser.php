<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralsUser extends Model
{
    use HasFactory;

    protected $table = 'fl_referrals_user';

    protected $fillable = [
        'user_id',
        'referral_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
