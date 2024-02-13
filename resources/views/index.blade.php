@extends('layouts.app')

@section('content')

    <div class="home__img">
        <img src="{{ asset('img/mainImg.png') }}" alt="mainImg">
    </div>


{{--    @foreach ($users as $user)--}}
{{--        <p>{{ $user->first_name }}</p>--}}
{{--    @endforeach--}}
@endsection
