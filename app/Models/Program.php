<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'program_name',
        'first_amount',
        'second_amount',
        'third_amount',
        'income_program',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'programs_user', 'program_id', 'user_id')->withTimestamps();
    }
}
