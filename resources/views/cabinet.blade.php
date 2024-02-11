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
                    <input type="file" name="video" accept="video/*" required>
                    <button type="submit">Upload Video</button>
                </form>

                <!-- Форма для введення посилання на YouTube -->
                <form action="{{ route('submitYouTubeLink') }}" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
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
                        <p class="card__sum">{{ $balance->amount }}</p>
                    </div>
                </div>
            </div>

            @if($video)
                <div class="packages-list">
                    <div class="row">
                    <div class="packages-list__item col-4">ПРОГРАМА 70$</div>
                    <div class="packages-list__item col-4">ПРОГРАМА 140$</div>
                    <div class="packages-list__item col-4">ПРОГРАМА 420$</div>
                    </div>
                </div>
            @endif


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
    </script>
@endsection


