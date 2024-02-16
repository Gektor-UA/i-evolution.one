@extends('layouts.app')

@section('content')
    <div class="cabinet__inner">
        <div class="cabinet__item">
            <h1 class="cabinet__title">{{ __('I-Health') }}</h1>
            <div class="balance__video__inner">
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

                <div class="balance__inner">
                    <h2 class="balance__title">{{ __('Видео:') }}</h2>

                    {{-- TODO: поки добавив display: none!!!!!!! --}}

                    <div id="programInfo" style="color: #FFFFFF; text-align: center; display: none"></div>

                    @if($selectVideo)
                        <div class="alert alert-primary" role="alert">
                            Ваше видео отправлено на проверку.
                        </div>
                    @endif

                    <form class="forms__video" action="{{ route('uploadVideo') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="forms__video__inner">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <button class="forms__video__btn" onclick="document.getElementById('fileInput').click()" {{ $blockForm ? 'disabled' : '' }}>Загрузить видео</button>
                            <input type="file" id="fileInput" name="video" accept="video/*" style="position: absolute; left: -9999px; opacity: 0;" onchange="displayFileName(this)" required>
                            <button class="forms__video__btn" type="submit" {{ $blockForm ? 'disabled' : '' }}>Отправить</button>
                        </div>
                        <span class="video__name" id="fileName"></span>

                    </form>

                    <div class="youtube__inner">
                        <div class="i__health__link__inner">
                            <p>ссылка на видео</p>
                            {{-- <a href="" id="iHealthRefLink" data-ref-link="{{ config('app.url', '') }}/i-health/{{ Auth::user()->referrer_hash }}">I-Health</a> --}}
                        </div>
                        <form class="forms__youtube" action="{{ route('submitYouTubeLink') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            {{-- <label for="youtubeLink">YouTube Link:</label> --}}
                            <input class="forms__youtube__input" type="text" name="youtubeLink" id="youtubeLink" {{ $blockForm ? 'disabled' : '' }} required>
                            <button class="forms__youtube__btn" type="submit" {{ $blockForm ? 'disabled' : '' }}>{{ __('Отправить') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- @if($video)
                <div class="alert alert-success" role="alert">
                    Ваше видео одобрено
                </div>
                <div class="packages__list">
                    <div class="packages__item">
                        <p>{{ __('ПРОГРАММА 70$') }}</p>
                        <button class="select-package-btn" data-package-id="1">{{ __('Выбрать') }}</button>
                    </div>

                    <div class="packages__item">
                        <p>{{ __('ПРОГРАММА 140$') }}</p>
                        <button class="select-package-btn" data-package-id="2">{{ __('Выбрать') }}</button>
                    </div>

                    <div class="packages__item">
                        <p>{{ __('ПРОГРАММА 420$') }}</p>
                        <button class="select-package-btn" data-package-id="3">{{ __('Выбрать') }}</button>
                    </div>
                </div>
            @endif --}}

            {{-- TODO: треба добавити логіку --}}
            <div class="progress__box">
                <p class="progress__title">{{ __('Ваш прогресс') }}</p>
                <div class="progress__inner">
                    <div class="progress__bar" style="width: 50%;">
                        50%
                    </div>
                </div>
            </div>

            @if($video)
                <div class="packages__list2">
                    <div class="packages__item2" id="program__1">
                        <p class="package2__title">{{ __('ПРОГРАММА 70$') }}</p>
                        <div class="package2__img">
                            <img src="{{ asset('img/cabinet/program1.png') }}" alt="program1">
                        </div>
                        <p class="package2__discount">+3.5 or -1.17%</p>
                        <p class="package__text"><span>Cashback</span><br> max 50 USD/mth</p>
                        <button class="select-package-btn" data-package-id="1">{{ __('Выбрать') }}</button>
                    </div>

                    <div class="packages__item2 pkg-two" id="program__2">
                        <p class="package2__title">{{ __('ПРОГРАММА 70$') }}</p>
                        <div class="package2__img">
                            <img src="{{ asset('img/cabinet/program2.png') }}" alt="program2">
                        </div>
                        <p class="package2__discount">+3.5 or -1.17%</p>
                        <p class="package__text"><span>Cashback</span><br> max 50 USD/mth</p>
                        <button class="select-package-btn" data-package-id="1">{{ __('Выбрать') }}</button>
                    </div>

                    <div class="packages__item2 pkg-three" id="program__3">
                        <p class="package2__title">{{ __('ПРОГРАММА 70$') }}</p>
                        <div class="package2__img">
                            <img src="{{ asset('img/cabinet/program3.png') }}" alt="program3">
                        </div>
                        <p class="package2__discount">+3.5 or -1.17%</p>
                        <p class="package__text"><span>Cashback</span><br> max 50 USD/mth</p>
                        <button class="select-package-btn" data-package-id="1">{{ __('Выбрать') }}</button>
                    </div>
                </div>
            @endif
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
                    <button onclick="document.getElementById('fileInput').click()" {{ $blockForm ? 'disabled' : '' }}>Загрузить видео</button>
                    <span id="fileName"></span>
                    <input type="file" id="fileInput" name="video" accept="video/*" style="position: absolute; left: -9999px; opacity: 0;" onchange="displayFileName(this)" required>
                    <button type="submit" {{ $blockForm ? 'disabled' : '' }}>Отправить</button>
                </form>

                <!-- Форма для введення посилання на YouTube -->
                {{-- <form action="{{ route('submitYouTubeLink') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <label for="youtubeLink">Ссылка на YouTube:</label>
                    <input type="text" name="youtubeLink" id="youtubeLink" required>
                    <button type="submit" {{ $blockForm ? 'disabled' : '' }}>Отправить</button>
                </form>
            </div>


            @if($selectVideo)
                <div class="alert alert-primary" role="alert">
                    Ваше видео отправлено на проверку.
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
                        Ваше видео одобрено
                    </div>
                    <div class="row">
                        <div class="packages-list__item col-4">
                            <span>ПРОГРАММА 70$</span>
                            <button class="select-package-btn" data-package-id="1">Выбрать</button>
                        </div>
                        <div class="packages-list__item col-4">
                            <span>ПРОГРАММА 140$</span>
                            <button class="select-package-btn" data-package-id="2">Выбрать</button>
                        </div>
                        <div class="packages-list__item col-4">
                            <span>ПРОГРАММА 420$</span>
                            <button class="select-package-btn" data-package-id="3">Выбрать</button>
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




    <script>
        // Копіювання рефералки в буфер обміну
        document.getElementById('iHealthRefLink').addEventListener('click', function() {
            const refLink = this.getAttribute('data-ref-link');
            const input = document.createElement('textarea');
            input.value = refLink;
            document.body.appendChild(input);
            input.select();
            const result = document.execCommand('copy');
            document.body.removeChild(input);
            return false;
        });

        // Завантаження відео, відображення назви файлу
        function displayFileName(input) {
            const fileNameElement = document.getElementById('fileName');
            if (input.files.length > 0) {
                const fileName = input.files[0].name;
                fileNameElement.textContent = `Файл: ${fileName}`;
            } else {
                fileNameElement.textContent = '';
            }
        }

        // Вибір програми
        document.addEventListener('DOMContentLoaded', function() {
            function getSelectedProgram() {
                fetch('/get-selected-program')
                    .then(response => {
                        if (response.ok) {
                            return response.json();
                        } else {
                            throw new Error('Неможливо отримати дані про вибрану програму.');
                        }
                    })
                    .then(data => {
                        if (data && data.program) {
                            console.log(data.program);
                            const programInfoElement = document.getElementById('programInfo');
                            programInfoElement.innerHTML = `
                        <p>Ваша программа: ${data.program.program_name}</p>
                        <p>Первое списание: ${data.program.first_amount}</p>
                        <p>Второе списание: ${data.program.second_amount}</p>
                        <p>Третье списание: ${data.program.third_amount}</p>
                        <p>Доход: ${data.program.income_program}</p>
                    `;
                        }
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                    });
            }

            getSelectedProgram();

            const selectPackageBtns = document.querySelectorAll('.select-package-btn');
            selectPackageBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const packageId = parseInt(this.getAttribute('data-package-id'));

                    selectPackage(packageId);
                });
            });

            function selectPackage(packageId) {
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
                            const packageItems = document.querySelectorAll('.packages__item2');
                            packageItems.forEach(item => {
                                item.classList.remove('pkg-active');
                            });

                            document.getElementById(`program__${packageId}`).classList.add('pkg-active');

                            getSelectedProgram();
                            alert('Пакет успішно вибрано!');
                        } else {
                            throw new Error('Неможливо змінити програму після першого списання.');
                        }
                    })
                    .catch(error => {
                        console.error('Помилка:', error);
                        alert(error.message || 'Помилка вибору пакета. Спробуйте ще раз.');
                    });
            }
            });
    </script>
@endsection


