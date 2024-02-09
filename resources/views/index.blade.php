@extends('layouts.app')

@section('content')

    <style>
        .i-health__inner {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .i-health__link {
            margin-top: 10px;
        }
    </style>

    <div class="main-alerts">
        <div class="container">
            <div class="i-health__inner">
                <h2 class="section-heading">I-Health</h2>
                <a href="#">Refka</a>
{{--                <a class="i-health__link nav-link refs-btn" href="#" id="iHealthRefLink" data-ref-link="{{ config('app.url', '') }}/i-health/{{ Auth::user()->referrer_hash }}">--}}
{{--                    <svg--}}
{{--                        width="7"--}}
{{--                        height="10"--}}
{{--                        viewBox="0 0 7 10"--}}
{{--                        class="copy-icon"--}}
{{--                        fill="none"--}}
{{--                        xmlns="http://www.w3.org/2000/svg">--}}
{{--                        <path--}}
{{--                            d="M2.47059 7.7C2.24412 7.7 2.05018 7.6118 1.88877 7.4354C1.72735 7.259 1.64678 7.0472 1.64706 6.8V1.4C1.64706 1.1525 1.72777 0.940551 1.88918 0.764151C2.05059 0.587751 2.24439 0.499701 2.47059 0.500001H6.17647C6.40294 0.500001 6.59688 0.588201 6.75829 0.764601C6.91971 0.941001 7.00027 1.1528 7 1.4V6.8C7 7.0475 6.91929 7.25945 6.75788 7.43585C6.59647 7.61225 6.40267 7.7003 6.17647 7.7H2.47059ZM2.47059 6.8H6.17647V1.4H2.47059V6.8ZM0.82353 9.5C0.597059 9.5 0.403118 9.4118 0.241706 9.2354C0.0802948 9.059 -0.000273811 8.8472 6.99091e-07 8.6V2.75C6.99091e-07 2.6225 0.0395301 2.51555 0.118589 2.42915C0.197648 2.34275 0.295373 2.2997 0.411765 2.3C0.528432 2.3 0.626295 2.3432 0.705353 2.4296C0.784412 2.516 0.823804 2.6228 0.82353 2.75V8.6H4.94118C5.05784 8.6 5.15571 8.6432 5.23476 8.7296C5.31382 8.816 5.35322 8.9228 5.35294 9.05C5.35294 9.1775 5.31341 9.28445 5.23435 9.37085C5.15529 9.45725 5.05757 9.5003 4.94118 9.5H0.82353Z" />--}}
{{--                    </svg>--}}
{{--                    <span>@lang('dashboardBase.header.ref_i-health_button_link')</span>--}}
{{--                </a>--}}
            </div>

            <div class="forms-video" style="position: relative">
                <!-- Форма для завантаження відео -->
                <form action="{{ route('uploadVideo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="video" accept="video/*" required>
                    <button type="submit">Upload Video</button>
                </form>

                <!-- Форма для введення посилання на YouTube -->
                <form action="{{ route('submitYouTubeLink') }}" method="post">
                    @csrf
                    <label for="youtubeLink">YouTube Link:</label>
                    <input type="text" name="youtubeLink" id="youtubeLink" required>
                    <button type="submit">Submit YouTube Link</button>
                </form>
            </div>


            <div class="card-wrap mb-4">
                <div class="card card-balance">
                    <div class="card__header">
                        <h5 class="card__title">$</h5>
                    </div>
                    <div class="card__body">
{{--                        <p class="card__sum">{{ $balance }}</p>--}}
                        <p class="card__sum">0</p>
                    </div>
                </div>

                <h1>Список користувачів</h1>
                <ul>
                    @foreach ($users as $user)
                        <li>{{ $user->first_name }}</li>
                    @endforeach
                </ul>
            </div>




{{--            <div class="statistic-problem">--}}
{{--                <button--}}
{{--                    type="button"--}}
{{--                    id="problemsBtn"--}}
{{--                    class="btn btn-warning mt-4"--}}
{{--                    onclick="$('#problemModel').modal('show')">--}}
{{--                    Need help?--}}
{{--                </button>--}}
{{--            </div>--}}

        </div>
    </div>

@endsection
