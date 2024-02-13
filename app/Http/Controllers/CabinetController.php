<?php

namespace App\Http\Controllers;

use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index()
    {
        // Перевірка чи підтверджено відео, якщо так то відкриється блок з вибором програм
        $user_id = Auth::id();
        $video = Video::where('user_id', $user_id)
            ->where('is_approved', 1)
            ->where(function ($query) {
                $query->whereNull('is_program')->orWhere('is_program', 0);
            })
            ->first();

        // Вивід балансу на сторінку
        $balbance = Purse::where('user_id', $user_id)
            ->where('wallet_type', 1)
            ->first();

        return view('cabinet',
            ['video' => $video],
            ['balance' => $balbance]
        );
    }
}
