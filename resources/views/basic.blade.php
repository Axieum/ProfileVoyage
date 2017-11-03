@extends('layouts.auth')

@section('title', $title)

@section('content')
    <div id="app" class="container has-text-centered">
        <h2 class="title is-2 white-text">{{ $title }}</h2>
        <p class="subtitle is-4 has-text-weight-light white-text">{!! $message !!}</p>
    </div>
@endsection
