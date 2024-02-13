@extends('layouts.app')

@section('content')

    <div class="auth__container">
        <div class="auth__inner">
            <h1 class="auth__title">{{ __('Регистрация') }}</h1>
            @if(Request::cookie('referrerHash'))
                <h3>{{ __('Ваш реферер:') }} {{ Request::cookie('referrerName') }}</h3>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="auth__form__group">
                    <label for="first_name">{{ __('Имя:') }}</label>
                    <input type="text" class="auth__form__input" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                </div>

                <div class="auth__form__group">
                    <label for="last_name">{{ __('Фамилия:') }}</label>
                    <input type="text" class="auth__form__input" id="last_name" name="last_name" value="{{ old('last_name') }}" required autofocus>
                </div>

                <div class="auth__form__group">
                    <label for="email">{{ __('Электронная почта:') }}</label>
                    <input type="email" class="auth__form__input" id="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="auth__form__group">
                    <label for="password">{{ __('Пароль:') }}</label>
                    <input type="password" class="auth__form__input" id="password" name="password" required>
                </div>

                <div class="auth__form__group">
                    <label for="password_confirmation">{{ __('Подтвердите пароль:') }}</label>
                    <input type="password" class="auth__form__input" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="auth__form__group">
                    <button type="submit" class="form__submit" >{{ __('Зарегистрироваться') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
