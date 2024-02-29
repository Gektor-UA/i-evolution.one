<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Models\User;
use App\Models\Withdraw;
use Database\Seeders\ReferralsUserSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IHealthController extends Controller
{
    /**
     * Збереження хешу реферера
     *
     * @return redirect to register
     */
    public function iHealth($data)
    {
        $User = User::where('referrer_hash', '=', $data)->first();

        return redirect()->route('register')
            ->withCookie('referrerHash', $data)
            ->withCookie('referrerName', (!empty($User) ? $User['first_name'] . ' ' . $User['last_name'] : ''));
    }
}
