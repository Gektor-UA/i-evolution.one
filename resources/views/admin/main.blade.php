@extends('layouts.app')

@section('content')

    <div class="admin-page">
        <h1>СТАРТОВА СТОРІНКА АДМІНІСТРАТОРА</h1>

        <div class="videos-list">
            @foreach ($videos as $video)
                <div class="video-item">
                    @if ($video->file_path)
                        <video controls>
                            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <a href="{{ route('downloadVideo', $video->id) }}">Download Video</a>
                        <div class="video-actions">
                            <form action="{{ route('approveVideo', $video->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $video->user_id }}">
                                <button type="submit">Підтвердити</button>
                            </form>
                            <form action="{{ route('rejectVideo', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit">Відхилити</button>
                            </form>
                        </div>
                    @else
                        <iframe width="560" height="315" src="{{$video->video_url}}" frameborder="0" allowfullscreen></iframe>
                        <div class="video-actions">
                            <form action="{{ route('approveVideo', $video->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $video->user_id }}">
                                <button type="submit">Підтвердити</button>
                            </form>
                            <form action="{{ route('rejectVideo', $video->id) }}" method="POST">
                                @csrf
                                <button type="submit">Відхилити</button>
                            </form>
                        </div>
                    @endif
                    <div class="user-name">
                        <span>{{ $video->user->first_name }}</span>
                        <span>{{ $video->user->last_name }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
