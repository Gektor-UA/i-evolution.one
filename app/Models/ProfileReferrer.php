<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileReferrer extends Model
{
    use HasFactory;

    protected $table = 'profile_referrers';

    protected $fillable = ['user_id', 'referrer_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
