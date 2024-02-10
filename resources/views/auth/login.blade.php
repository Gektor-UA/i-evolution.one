@extends('layouts.app')

@section('content')
    <div class="login-form">
        <h1>Авторизація</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <label for="email">Електронна пошта:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Увійти</button>
            </div>
        </form>
    </div>
@endsection
