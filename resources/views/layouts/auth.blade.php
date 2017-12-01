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
        @yield('styles')
    </head>
    <body special>
        <nav class="navbar has-transparentbackground is-fixed is-nonfixed-touch" role="navigation" aria-label="main navigation">
            <div class="container navbar-brand has-text-centered">
                <a href="{{ route('index') }}" class="logo"><img src="{{ asset('img/logo_light.svg') }}" alt="Profile Voyage" width="48px"></a>
            </div>
        </nav>

        <main class="hero is-fullheight is-fullheight-desktop">
            <div class="hero-body is-paddingless">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </main>

        <script src="{{ asset('js/app.js') }}"></script>
        @include('partials._flash')
        @yield('scripts')
    </body>
</html>
