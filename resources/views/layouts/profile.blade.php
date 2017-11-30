<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Profile Voyage | @yield('title')</title>

        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    </head>
    <body special>
        <nav class="navbar is-mobile navbar-profile has-transparentbackground" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-start is-mobile">
                    <div class="navbar-brand has-text-centered">
                        <a href="{{ route('index') }}" class="logo"><img src="{{ asset('img/logo_light.svg') }}" alt="Profile Voyage" width="48px"></a>
                    </div>
                </div>
                @if (!Auth::guest() && Auth::user()->id === $profile->user_id)
                    <div class="navbar-end is-mobile has-content-vcentered">
                        <a class="white-text m-r-10" href="{{ route('profile.links', $profile->link) }}">
                            <span class="icon is-medium"><i class="mdi mdi-link-variant"></i></span>
                        </a>
                        <a class="white-text" href="{{ route('profile.edit', $profile->link) }}">
                            <span class="icon is-medium"><i class="mdi mdi-settings"></i></span>
                        </a>
                    </div>
                @endif
            </div>
        </nav>

        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>

        <script src="{{ asset('js/profile.js') }}"></script>
        @yield('scripts')
    </body>
</html>
