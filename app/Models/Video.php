<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    const BONUS_VIDEO = 20;

    protected $table = 'fl_videos';

    protected $fillable = [
        'user_id',
        'video_url',
        'file_path',
        'is_sent',
        'is_approved',
        'is_program',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
