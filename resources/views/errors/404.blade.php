@extends('layouts.auth')

@section('title', 'Error 404')

@section('content')
    <div id="app" class="container has-text-centered">
        <h2 class="title is-2 white-text">Error 404</h2>
        <p class="subtitle is-4 has-text-weight-light white-text">{{ $exception->getMessage() ?: 'Whoops! Page not found!' }}</p>
    </div>
@endsection
