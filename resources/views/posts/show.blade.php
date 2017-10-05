@extends('layouts/app')

@section('content')
    <h1>{{ $post->title }}</h1>

    <p>{{ $post->body }}</p>

    <p>{{ $post->user->name }}</p>
@endsection
