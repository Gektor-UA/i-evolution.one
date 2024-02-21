@extends('layouts.app')

@section('content')

    <div class="auth__container">
        <div class="auth__inner">
            <h1 class="auth__title">{{ __('Авторизация') }}</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="auth__form__group">
                    <label for="email">{{ __('Электронная почта:') }}</label>
                    <input type="email" class="auth__form__input" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="auth__form__group">
                    <label for="password">{{ __('Пароль:') }}</label>
                    <input type="password" class="auth__form__input" id="password" name="password" required>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                    </div>
                @endif

                <div class="auth__form__group">
                    <button type="submit" class="form__submit" >{{ __('Войти') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection



