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
{{--                    <input type="file" name="video" accept="video/*" required>--}}
                    <button onclick="document.getElementById('fileInput').click()" {{ $blockForm ? 'disabled' : '' }}>Загрузить видео</button>
                    <span id="fileName"></span>
                    <input type="file" id="fileInput" name="video" accept="video/*" style="display: none" onchange="displayFileName(this)" required>
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



        // Завантаження відео
        // Отримуємо посилання на елементи кнопки та інпуту файлу
        const uploadButton = document.getElementById('uploadButton');
        const fileInput = document.getElementById('fileInput');

        // Встановлюємо текст кнопки
        uploadButton.innerText = 'Завантажити відео';

        // Встановлюємо плейсхолдер інпуту файлу
        fileInput.placeholder = 'Виберіть відео для завантаження';

        // Додаємо обробник події для кліку на кнопку
        uploadButton.addEventListener('click', function() {
            // Симулюємо клік на інпут файлу, коли кнопка натиснута
            fileInput.click();
        });
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
                            alert('Неможливо змінити програму після першого списання.');
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


