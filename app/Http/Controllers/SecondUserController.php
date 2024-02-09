<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSecond;
use Illuminate\Http\Request;

class SecondUserController extends Controller
{
    public function index()
    {
//        $ambassadorUsers = UserSecond::where('is_ambassador', 1)->get();
//
//
//        foreach ($ambassadorUsers as $user) {
//            $existingUser = User::where('email', $user->email)->first();
//            if (!$existingUser) {
//                User::create([
//                    'first_name' => $user->first_name,
//                    'last_name' => $user->last_name,
//                    'email' => $user->email,
//                    'password' => $user->password,
//                    'phone' => $user->phone,
//                    'birthday' => $user->birthday,
//                    'referrer_hash' => $user->referrer_hash,
//                    'twofa_secret' => $user->twofa_secret,
//                    'avatar' => $user->avatar,
//                    'verification_withdrawal' => $user->verification_withdrawal,
//                    'verification_tariff_closing' => $user->verification_tariff_closing,
//                    'role_id' => $user->role_id,
//                    'achived_turnover' => $user->achived_turnover,
//                    'is_ambassador' => $user->is_ambassador,
//                ]);
//            }
//        }

        $users = User::all();
        return view('index', compact('users'));
    }
}
