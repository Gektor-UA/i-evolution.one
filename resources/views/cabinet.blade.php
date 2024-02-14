@extends('layouts.app')

@section('content')
    <div class="main-alerts">
        <div class="container">
            <div class="i-health__inner">
                <h2 class="section-heading">I-Health</h2>
                <a href="" class="btn-primary color-white" id="iHealthRefLink" data-ref-link="{{ config('app.url', '') }}/i-health/{{ Auth::user()->referrer_hash }}">I-Health</a>
            </div>


            <div class="forms-video" style="position: relative">
                <!-- Форма для завантаження відео -->
                <form action="{{ route('uploadVideo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <button onclick="document.getElementById('fileInput').click()" {{ $blockForm ? 'disabled' : '' }}>Загрузить видео</button>
                    <span id="fileName"></span>
                    <input type="file" id="fileInput" name="video" accept="video/*" style="position: absolute; left: -9999px; opacity: 0;" onchange="displayFileName(this)" required>
                    <button type="submit" {{ $blockForm ? 'disabled' : '' }}>Отправить</button>
                </form>

                <!-- Форма для введення посилання на YouTube -->
                <form action="{{ route('submitYouTubeLink') }}" method="post">
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
            @endif

            <div id="programInfo"></div>

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

        </div>
    </div>




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


