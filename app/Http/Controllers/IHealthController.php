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

//        $UserParent = User::where('referrer_hash', '=', $data)->first();
//
//        $newUser = User::create([
//            'first_name' => $data['first_name'],
//            'last_name' => $data['last_name'],
//            'email' => $data['email'],
//            'password' => Hash::make($data['password']),
//            'referrer_hash' => (new RegistrationController())->generationReferrerHash(),
//            'verification_withdrawal' => 0,
//            'verification_tariff_closing' => 0,
//        ]);
//
//        if (!empty($UserParent)) {
//            ReferralsUserSeeder::create([
//                $newUser->id,
//                $UserParent->id,
//            ]);
//        }
//
//        return redirect('/login');
    }
}
