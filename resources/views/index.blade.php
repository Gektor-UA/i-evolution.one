@extends('layouts.app')

@section('content')

    <h1>СТАРТОВА СТОРІНКА</h1>


    @foreach ($users as $user)
        <p>{{ $user->first_name }}</p>
        <!-- Відобразіть інші поля користувача -->
    @endforeach
@endsection
