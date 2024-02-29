<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ProfileReferrer;
use App\Models\Purse;
use App\Models\ReferralsUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Реєстрація нового користувача
     *
     * @param Request $request
     * @return redirect
     */
    public function create(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        // Створення нового користувача
        $newUser = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'referrer_hash' => $this->generationReferrerHash(),
            'verification_withdrawal' => 0,
            'verification_tariff_closing' => 0,
        ]);

        // Створення гаманця
        Purse::create([
            'user_id' => $newUser->id,
            'amount' => 0,
            'wallet_type' => Purse::I_HEALTH_PURSE,
            'percent' => 0,
        ]);

        // Перевірка та створення реферала
        $RefUser = User::where('referrer_hash', '=', Cookie::get('referrerHash'))->first();
        if (!empty($RefUser)) {
            ProfileReferrer::create([
                'user_id' => $newUser->id,
                'referrer_id' => $RefUser->id
            ]);
//            ReferralsUser::create([
//                'user_id' => $newUser->id,
//                'referral_id' => $RefUser->id]
//            );
        }

        // Автентифікація користувача
        Auth::login($newUser);

        return redirect('/cabinet')->with('success', 'Ви успішно зареєструвалися!');
    }

    public function logout()
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers(), 'regex:/^[a-zA-Z0-9!]+$/'],
        ], [
            'email.unique' => 'Такая почта уже зарегистрирована.',
            'password.regex' => 'Пароль должен содержать только буквы, цифры и символ "!"',
            'password.required' => 'Пароль обязателен для заполнения.',
            'password.confirmed' => 'Подтверждение пароля не совпадает.',
            'password.min' => 'Пароль должен содержать не менее 8 символов.',
            'password' => 'Пароль должен содержать хотя бы одну заглавную и одну строчную букву.',
        ]);
    }
}
