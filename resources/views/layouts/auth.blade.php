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
    <body special>
        <nav class="container navbar is-transparent" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a href="{{ route('index') }}" class="logo"><img src="{{ asset('img/logo.svg') }}" alt="Profile Voyage" height="58px" width="167px"></a>
            </div>
        </nav>

        <main class="hero is-fullheight" style="margin-top: -82px;">
            <div class="hero-body">
                <div class="container">
                    @yield('content')
                </div>
            </div>
        </main>

        <script src="{{ asset('js/app.js') }}"></script>
        @yield('scripts')
    </body>
</html>
