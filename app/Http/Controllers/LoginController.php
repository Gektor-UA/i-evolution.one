<?php

namespace App\Http\Controllers;

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
        // Валідація даних
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Перевірка авторизаційних даних
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Якщо користувач успішно авторизований, перенаправте його на домашню сторінку
            return redirect()->intended('cabinet');
        }

        // Якщо авторизація не вдалася, перенаправте користувача назад на сторінку логіну з повідомленням про помилку
        return back()->withErrors([
            'email' => 'Неправильна електронна пошта або пароль.',
        ]);
    }
}
