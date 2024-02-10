<!DOCTYPE html>
<html lang="en-US" data-theme="dark">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="robots" content="max-image-preview:large" />
    <title>Trade 24</title>


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
<script src="/js/script.js"></script>
</body>

</html>
