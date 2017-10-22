<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Profile Voyage | @yield('title')</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body {{ Route::is('index') ? 'special' : '' }}>
        <nav {{ Route::is('index') ?: 'special' }}>
            @include('partials._navigation')

            @if (!Route::is('index'))
                @include('partials._header')
            @endif
        </nav>

        @include('partials._flash')

        <main>
            @yield('content')
        </main>

        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
