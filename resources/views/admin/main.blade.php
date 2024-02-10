@extends('layouts.app')

@section('content')

    <h1>СТАРТОВА СТОРІНКА АДМІНІСТРАТОРА</h1>


    <div class="videos-list">
{{--        @foreach ($videos as $video)--}}
{{--            <div class="video-item">--}}
{{--                @if ($video->file_path)--}}
{{--                    <video controls>--}}
{{--                        <source src="{{ asset('storage/videos/' . $video->file_path) }}" type="video/mp4">--}}
{{--                        Your browser does not support the video tag.--}}
{{--                    </video>--}}
{{--                    <a href="{{ route('downloadVideo', $video->id) }}">Download Video</a>--}}
{{--                @else--}}
{{--                    <video controls>--}}
{{--                        <source src="{{ $video->video_url }}">--}}
{{--                        Your browser does not support the video tag.--}}
{{--                    </video>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        @endforeach--}}


        @foreach ($videos as $video)
            <div class="video-item">
                @if ($video->file_path)
                    <video controls>
                        <source src="{{ asset('storage/videos/' . $video->file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <a href="{{ route('downloadVideo', $video->id) }}">Download Video</a>
                    <div class="video-actions">
                        <form action="{{ route('approveVideo', $video->id) }}" method="POST">
                            @csrf
                            <button type="submit">Підтвердити</button>
                        </form>
                        <form action="{{ route('rejectVideo', $video->id) }}" method="POST">
                            @csrf
                            <button type="submit">Відхилити</button>
                        </form>
                    </div>
                @else
                    <video controls>
                        <source src="{{ $video->video_url }}">
                        Your browser does not support the video tag.
                    </video>
                    <div class="video-actions">
                        <form action="{{ route('approveVideo', $video->id) }}" method="POST">
                            @csrf
                            <button type="submit">Підтвердити</button>
                        </form>
                        <form action="{{ route('rejectVideo', $video->id) }}" method="POST">
                            @csrf
                            <button type="submit">Відхилити</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@endsection
