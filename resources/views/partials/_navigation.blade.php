<nav class="navbar has-transparentbackground {{ Route::is('index') ? 'is-fixed is-nonfixed-touch' : '' }}" role="navigation" aria-label="main navigation">
    <div class="container level is-mobile">
        <div class="level-left">
            <div class="level-item navbar-brand is-marginless">
                <a href="{{ route('index') }}" class="logo"><img src="{{ asset('img/logo_light.svg') }}" alt="Profile Voyage" width="48px"></a>
            </div>
            <a class="navbar-burger">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
        <div class="level-right">
            <div class="navbar-menu">
                <div class="navbar-start">
                    <div class="has-text-weight-bold is-size-5-desktop navbar-item has-text-centered">
                        @guest
                            <a href="{{ route('index') }}" class="level-item navbar-item">Getting Started</a>
                        @else
                            <a href="#!" class="level-item navbar-item">Dashboard</a>
                        @endguest
                        <a href="#!" class="level-item navbar-item">Learn More</a>
                        <a href="#!" class="level-item navbar-item">Help</a>
                    </div>
                </div>
                <div class="navbar-end">
                    @if (Auth::guest())
                        <div class="navbar-item level-item">
                            <div class="field is-grouped">
                                <p class="control">
                                    <a href="{{ route('login') }}" class="button {{ Route::is('index') ? 'is-light' : '' }} is-outlined">
                                        <span class="icon"><i class="fa fa-sign-in"></i></span>
                                        <span>Login</span>
                                    </a>
                                </p>
                                <p class="control">
                                    <a href="{{ route('register') }}" class="button is-primary is-secondary">
                                        <span class="icon"><i class="fa fa-users"></i></span>
                                        <span>Register</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="navbar-item has-dropdown is-hoverable">
                            <div class="level is-marginless p-l-5 p-r-5">
                                <div class="level-left">
                                    <a href="{{ route('account.edit') }}" class="level-item m-r-10">
                                        <figure class="image is-24x24">
                                            <img src="{{ asset('img/profile.png') }}" class="is-circle has-border">
                                        </figure>
                                    </a>
                                    <a href="{{ route('account.edit') }}" class="level-item washed-text has-text-weight-semibold is-marginless">{{ Auth::user()->profile->name }}</a>
                                    <span class="level-item icon is-small washed-text m-l-5"><i class="fa fa-chevron-down"></i></span>
                                </div>
                            </div>
                            <div class="navbar-dropdown is-boxed">
                                <a class="navbar-item">Profiles</a>
                                <a class="navbar-item">Notifications</a>
                                <a href="{{ route('account.edit') }}" class="navbar-item">Account</a>
                                <hr class="navbar-divider">
                                <a href="{{ route('logout') }}" class="navbar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</nav>
<nav class="navbar-mobile">
    <div class="level is-mobile">
        <div class="level-left"><h2 class="title is-4">Profile Voyage</h2></div>
        <div class="level-right"><a class="navbar-burger-close"><span class="icon"><i class="fa fa-close"></i></span></a></div>
    </div>
    <div class="navbar-divider m-b-15"></div>
    <div class="navbar-mobile-menu">
        @guest
            <a href="{{ route('login') }}" class="navbar-item button is-outlined m-b-15">
                <span class="icon"><i class="fa fa-sign-in"></i></span>
                <span>Login</span>
            </a>
            <a href="{{ route('register') }}" class="navbar-item button is-primary is-secondary">
                <span class="icon"><i class="fa fa-users"></i></span>
                <span>Register</span>
            </a>
        @else
            <div class="level is-mobile is-fullwidth m-b-15">
                <div class="level-left is-centered">
                    <a href="{{ route('account.edit') }}" class="level-item m-r-5">
                        <figure class="image is-24x24">
                            <img src="{{ asset('img/profile.png') }}" class="is-circle has-border-dark is-thin">
                        </figure>
                    </a>
                    <a href="{{ route('account.edit') }}" class="level-item dark-text has-text-weight-normal">{{ Auth::user()->profile->name }}</a>
                </div>
            </div>
            <div class="navbar-divider"></div>
            <a class="navbar-item">Profiles</a>
            <a class="navbar-item">Notifications</a>
            <a href="{{ route('account.edit') }}" class="navbar-item">Account</a>
            <hr class="navbar-divider">
            <a href="{{ route('logout') }}" class="navbar-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
        @endguest
    </div>
</nav>
<div class="navbar-mobile-underlay"></div>
