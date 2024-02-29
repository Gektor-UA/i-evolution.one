<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Purse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Перевірка авторизаційних даних
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role_id == 1) {
                return redirect()->intended('main');
            } else {

                // add
                $purse = Purse::where('user_id', '=', Auth::user()->id)->first();
                if (!$purse) {
                    Purse::create([
                        'user_id' => Auth::user()->id,
                        'amount' => 0,
                        'wallet_type' => Purse::I_HEALTH_PURSE,
                        'percent' => 0,
                    ]);
                }
                // end add

                return redirect()->intended('cabinet');
            }
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Неверная электронная почта или пароль.',
            ])->withInput($request->only('email'));
        }
    }
}
