<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $video = Video::where('user_id', $user_id)
            ->where('is_approved', 1)
            ->first();
        return view('cabinet', ['video' => $video]);
    }
}
