<!DOCTYPE html>
<html lang="en-US" data-theme="dark">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="max-image-preview:large" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trade 24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Roboto+Slab:wght@100..900&display=swap" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
<div id="site">

    <header class="header">
        <div class="header__inner">
            <div class="logo__inner">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('img/logo.png') }}" alt="logo">
                    </a>

            </div>
            <nav class="nav">
{{--                <ul class="menu">--}}
{{--                    <li><a href="#">Header</a></li>--}}
{{--                    <li><a href="#">Header</a></li>--}}
{{--                    <li><a href="#">Header</a></li>--}}
{{--                    <li><a href="#">Header</a></li>--}}
{{--                </ul>--}}
                <ul class="auth">
                    @auth
                        <li class="d-flex gap-3 text-white">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit">Выйти</button>
                            </form>
                            <form action="{{ route('cabinet') }}" method="GET">
                                @csrf
                                <button type="submit">Кабинет</button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a class="{{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">{{ __('Авторизация') }}</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
{{--        FOOTER--}}
    </footer>

</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>




