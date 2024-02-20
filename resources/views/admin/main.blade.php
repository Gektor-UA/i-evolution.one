@extends('layouts.app')

@section('content')

    <div class="admin-page">

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

        <div class="requests">
            <h1 style="color: #FFFFFF">Запросы на вивод денег</h1>
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">В ожидании</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="confirm-tab" data-bs-toggle="tab" data-bs-target="#confirm" type="button" role="tab" aria-controls="confirm" aria-selected="false">Подтвержденные</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="canceled-tab" data-bs-toggle="tab" data-bs-target="#canceled" type="button" role="tab" aria-controls="canceled" aria-selected="false">Отмененные</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active d-flex align-items-center justify-content-center gap-3" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                    @foreach($withdraws as $withdraw)
                        @if($withdraw->status == 3)
                            <p style="color: #FFFFFF; text-align: center; padding: 20px 0;">
                                {{ $withdraw->user->first_name }} {{ $withdraw->user->last_name }} - {{ $withdraw->amount }}
                            </p>
                            <button class="approve-btn" data-id="{{ $withdraw->id }}">Подтвердить</button>
                            <button class="cancel-btn" data-id="{{ $withdraw->id }}">Отменить</button>
                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="confirm" role="tabpanel" aria-labelledby="confirm-tab">
                    @foreach($withdraws as $withdraw)
                        @if($withdraw->status == 1)
                            <p style="color: #FFFFFF; text-align: center; padding: 20px 0;">
                                {{ $withdraw->user->first_name }} {{ $withdraw->user->last_name }} - {{ $withdraw->amount }}
                            </p>
                        @endif
                    @endforeach
                </div>
                <div class="tab-pane fade" id="canceled" role="tabpanel" aria-labelledby="canceled-tab">
                    @foreach($withdraws as $withdraw)
                        @if($withdraw->status == 2)
                            <p style="color: #FFFFFF; text-align: center; padding: 20px 0;">
                                {{ $withdraw->user->first_name }} {{ $withdraw->user->last_name }} - {{ $withdraw->amount }}
                            </p>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.approve-btn').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    let withdrawId = this.dataset.id;
                    console.log('Approved');
                    sendWithdrawStatus(withdrawId, 'confirm');
                });
            });

            document.querySelectorAll('.cancel-btn').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    let withdrawId = this.dataset.id;
                    console.log('Cancelled');
                    sendWithdrawStatus(withdrawId, 'cancelled');
                });
            });
        });

        function sendWithdrawStatus(withdrawId, status) {
            fetch(`/withdraw/${withdrawId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    withdraw_id: withdrawId,
                    status: status
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    location.reload();
                })
                .catch(error => {
                    console.error('There was an error!', error);
                });
        }
    </script>
@endsection
