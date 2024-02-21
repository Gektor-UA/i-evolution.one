<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
                return redirect()->intended('cabinet');
            }
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Неверная электронная почта или пароль.',
            ])->withInput($request->only('email'));
        }
    }
}
