@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <h1 class="text-center">{{ __('Авторизація') }}</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">{{ __('Електронна пошта:') }}</label>
                            <input type="email" class="form-control mt-3 form-input" id="email" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">{{ __('Пароль:') }}</label>
                            <input type="password" class="form-control mt-3 form-input" id="password" name="password" required>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary submit__btn">{{ __('Увійти') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <style>
        body {
            background-color: rgb(68, 1, 73);
        }

        h1, label {
            font-family: 'Noto Serif', serif;
            font-weight: 600;
            background: linear-gradient(186deg, #F9E5B6 19.08%, #F2C05E 91.22%), linear-gradient(178.46deg, #FAF7F1 1.31%, #FCE4B2 44.89%, #F2C05E 77.32%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(245, 210, 128, 1), -1px -1px 4px rgba(0, 0, 0, 0.3);
        }

        .form-input {
            font-family: 'Noto Serif', serif;
            font-weight: 600;
            background: linear-gradient(186deg, #F9E5B6 19.08%, #F2C05E 91.22%), linear-gradient(178.46deg, #FAF7F1 1.31%, #FCE4B2 44.89%, #F2C05E 77.32%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(245, 210, 128, 1), -1px -1px 4px rgba(0, 0, 0, 0.3);
            border: 1px solid #F5D280;
        }

        .form-input:hover,
        .form-input:focus {
            border: 1px solid #F5D280;
            box-shadow: 0px 0px 10px 0px #F5D280;
        }

        .submit__btn {
            font-family: 'Noto Serif', serif;
            font-weight: 600;
            background: linear-gradient(186deg, #F9E5B6 19.08%, #F2C05E 91.22%), linear-gradient(178.46deg, #FAF7F1 1.31%, #FCE4B2 44.89%, #F2C05E 77.32%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 15px rgba(245, 210, 128, 1), -1px -1px 4px rgba(0, 0, 0, 0.3);
            border: 1px solid transparent;
        }

        .submit__btn:hover {
            border: 1px solid #F5D280;
            box-shadow: 0px 0px 10px 0px #F5D280;
        }
    </style>
@endsection



