<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
        ]);

        User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'referrer_hash' => $this->generationReferrerHash(),
            'verification_withdrawal' => 0,
            'verification_tariff_closing' => 0,
        ]);

        return redirect('/')->with('success', 'Ви успішно зареєструвалися!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

    private function generationReferrerHash()
    {
        $str  = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz123456789';
        $hash = '';

        do {
            for ($i = 1; $i <= 10; $i++) {
                $hash .= $str[rand(0, strlen($str)-1)];
            }
        } while ( (bool)User::where('referrer_hash', '=', $hash)->count() );

        return $hash;
    }
}
