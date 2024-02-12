<!DOCTYPE html>
<html lang="en-US" data-theme="dark">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="max-image-preview:large" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Trade 24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>
<div id="site">

    <header class="header">
        HEADER
        <br>
        <br>
        <br>
        <nav>
            <ul>
                @auth
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Вийти</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('register') }}">Реєстрація</a></li>
                    <li><a href="{{ route('login') }}">Авторизація</a></li>
                @endauth
            </ul>
        </nav>
    </header>

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer">
        FOOTER
    </footer>

</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script src="{{ asset('js/script.js') }}"></script>
</body>

</html>




