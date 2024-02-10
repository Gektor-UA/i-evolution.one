@extends('layouts.app')

@section('content')
    <div class="register-form">
        <h1>Реєстрація</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div>
                <label for="first_name">Ім'я:</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
            </div>
            <div>
                <label for="last_name">Ім'я:</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required autofocus>
            </div>
            <div>
                <label for="email">Електронна пошта:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="password_confirmation">Підтвердіть пароль:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit">Зареєструватися</button>
        </form>
    </div>
@endSection
