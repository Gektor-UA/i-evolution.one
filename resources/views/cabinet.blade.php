@extends('layouts.app')

@section('content')
    <div class="cabinet__inner">
        <div class="cabinet__item">
            <h1 class="cabinet__title">{{ __('I-Health') }}</h1>
            <div class="balance__inner">
                <h2 class="balance__title">{{ __('Ваш баланс:') }}</h2>

                <div class="balance__income">
                    <div class="balance__box">
                        <p class="balance__text">{{ __('Баланс') }}</p>
                        <div class="balance__item">
                            <p class="balance__sum">{{ $balance->amount }} $</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($video)
                <div class="packages__list">
                    <div class="packages__item">
                        <p>{{ __('ПРОГРАМА 70$') }}</p>
                        <button class="select-package-btn" data-package-id="1">{{ __('Вибрати') }}</button>
                    </div>

                    <div class="packages__item">
                        <p>{{ __('ПРОГРАМА 140$') }}</p>
                        <button class="select-package-btn" data-package-id="2">{{ __('Вибрати') }}</button>
                    </div>

                    <div class="packages__item">
                        <p>{{ __('ПРОГРАМА 420$') }}</p>
                        <button class="select-package-btn" data-package-id="3">{{ __('Вибрати') }}</button>
                    </div>
                </div>
            @endif

            <form class="forms__video" action="{{ route('uploadVideo') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input class="forms__video__input" type="file" name="video" accept="video/*" required>
                <button class="forms__video__btn" {{ $blockForm ? 'disabled' : '' }} type="submit">Upload Video</button>
            </form>

            <div class="youtube__inner">
                <div class="i__health__link__inner">
                    <a href="" id="iHealthRefLink" data-ref-link="{{ config('app.url', '') }}/i-health/{{ Auth::user()->referrer_hash }}">I-Health</a>
                </div>
                <form class="forms__youtube" action="{{ route('submitYouTubeLink') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    {{-- <label for="youtubeLink">YouTube Link:</label> --}}
                    <input class="forms__youtube__input" type="text" name="youtubeLink" id="youtubeLink" required>
                    <button class="forms__youtube__btn" type="submit">{{ __('Submit') }}</button>
                </form>
            </div>

        </div>
    </div>

    {{-- <div class="main-alerts">
        <div class="container">
            <div class="i-health__inner">
                <h2 class="section-heading">I-Health</h2>
                <a href="" class="btn-primary color-white" id="iHealthRefLink" data-ref-link="{{ config('app.url', '') }}/i-health/{{ Auth::user()->referrer_hash }}">I-Health</a>
            </div>

            <div class="forms-video" style="position: relative"> --}}
                <!-- Форма для завантаження відео -->
                {{-- <form action="{{ route('uploadVideo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="file" name="video" accept="video/*" required>
                    <button type="submit">Upload Video</button>
                </form> --}}

                <!-- Форма для введення посилання на YouTube -->
                {{-- <form action="{{ route('submitYouTubeLink') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <label for="youtubeLink">YouTube Link:</label>
                    <input type="text" name="youtubeLink" id="youtubeLink" required>
                    <button type="submit" {{ $blockForm ? 'disabled' : '' }}>Submit YouTube Link</button>
                </form>
            </div>


            @if($selectVideo)
                <div class="alert alert-primary" role="alert">
                    Your video has been sent for verification
                </div>
            @endif

            <div class="card-wrap mb-4">
                <div class="card card-balance">
                    <div class="card__header">
                        <h5 class="card__title">$</h5>
                    </div>
                    <div class="card__body">
                        <p class="card__sum">{{ $balance->amount }}</p>
                    </div>
                </div>
            </div>

            @if($video)
                <div class="packages-list">
                    <div class="alert alert-success" role="alert">
                        Your video has been approved
                    </div>
                    <div class="row">
                        <div class="packages-list__item col-4">
                            <span>ПРОГРАМА 70$</span>
                            <button class="select-package-btn" data-package-id="1">Вибрати</button>
                        </div>
                        <div class="packages-list__item col-4">
                            <span>ПРОГРАМА 140$</span>
                            <button class="select-package-btn" data-package-id="2">Вибрати</button>
                        </div>
                        <div class="packages-list__item col-4">
                            <span>ПРОГРАМА 420$</span>
                            <button class="select-package-btn" data-package-id="3">Вибрати</button>
                        </div>
                    </div>
                </div>
            @endif --}}

{{--            @foreach ($referrals as $referral)--}}
{{--                <p>{{ $referral }}</p>--}}
{{--            @endforeach--}}

            {{--            <div class="statistic-problem">--}}
            {{--                <button--}}
            {{--                    type="button"--}}
            {{--                    id="problemsBtn"--}}
            {{--                    class="btn btn-warning mt-4"--}}
            {{--                    onclick="$('#problemModel').modal('show')">--}}
            {{--                    Need help?--}}
            {{--                </button>--}}
            {{--            </div>--}}

        {{-- </div>
    </div> --}}




{{--  Копіювання рефералки в буфер обміну  --}}
    <script>
        document.getElementById('iHealthRefLink').addEventListener('click', function() {
            var refLink = this.getAttribute('data-ref-link');

            var input = document.createElement('textarea');
            input.value = refLink;
            document.body.appendChild(input);

            input.select();
            var result = document.execCommand('copy');

            document.body.removeChild(input);

            return false;
        });



    // Вибір програми
        document.addEventListener('DOMContentLoaded', function() {
            const selectPackageBtns = document.querySelectorAll('.select-package-btn');
            selectPackageBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // const packageId = this.getAttribute('data-package-id');
                    const packageId = parseInt(this.getAttribute('data-package-id'));
                    selectPackage(packageId);
                });
            });

            function selectPackage(packageId) {
                console.log(typeof packageId);
                fetch('/save-package', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ package_id: packageId })
                })
                    .then(response => {
                        if (response.ok) {
                            // Обробка успішної відповіді
                            alert('Пакет успішно вибрано!');
                        } else {
                            // Обробка помилки
                            alert('Помилка вибору пакета. Спробуйте ще раз.');
                        }
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                        alert('Помилка вибору пакета. Спробуйте ще раз.');
                    });
            }
        });
    </script>
@endsection


