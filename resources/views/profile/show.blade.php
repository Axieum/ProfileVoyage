@extends('layouts.profile')

@section('title', $profile->display_name . "'s Profile")

@section('content')
    <div class="profile-image has-content-hcentered">
        <figure class="image is-256x256-desktop is-192x192-touch">
            <img class="is-circle has-border" src="{{ url(file_exists(storage_path('app/public/avatars\\' . $profile->avatar . '.png')) ? 'storage/avatars/' . $profile->avatar . '.png' : 'img/_profile.png') }}" alt="{{ $profile->display_name }}'s Profile Picture">
        </figure>
    </div>
    <div class="profile-info container has-text-centered m-t-15">
        <h1 class="title white-text is-size-1-desktop is-size-3-touch">{{ $profile->display_name }}</h1>
        @if (!is_null($profile->motto))
            <p class="subtitle has-text-weight-light white-text is-size-4-desktop is-size-6-touch">"<i>{{ $profile->motto }}</i>"</p>
        @endif
        @if (!is_null($profile->date_of_birth) || !is_null($profile->location) || !is_null($profile->country))
            <div class="level">
                    @if (!is_null($profile->date_of_birth))
                        <div class="level-item">
                            <span class="icon is-small white-text"><i class="fa fa-birthday-cake"></i></span>&nbsp;<time class="time white-text" datetime="{{ $profile->date_of_birth }}">{{ date('jS \o\f F, Y', strtotime($profile->date_of_birth)) }}</time>
                        </div>
                    @endif
                    @if (!is_null($profile->location))
                        <div class="level-item">
                            <span class="icon is-small white-text"><i class="fa fa-map-marker"></i></span>&nbsp;<p class="white-text">{{ $profile->location }}</p>
                        </div>
                    @endif
                    @if (!is_null($profile->country))
                        <div class="level-item">
                            <span class="icon is-medium white-text flag-icon flag-icon-{{ strtolower($profile->countryObject->code) }}"></span>&nbsp;<p class="white-text">{{ $profile->countryObject->name }}</p>
                        </div>
                    @endif
            </div>
        @endif
    </div>
    <p class="profile-divider"></p>
    <div class="profile-links">
        <div class="columns is-mobile is-multiline has-content-hcentered">
            @foreach ($profile->socials as $social)
                <div class="column is-4-desktop is-6-tablet is-12-mobile">
                    <a href="{{ $social->url }}">
                        <div class="card is-social is-horizontal is-rounded">
                            <div class="card-image">
                                <figure class="image is-64x64 has-content-centered">
                                    <span class="icon is-large"><i class="fa fa-{{ $social->platform->icon() }}"></i></span>
                                </figure>
                            </div>
                            <div class="card-content">
                                <p class="title is-size-4-desktop is-size-5-touch">{{ $social->value }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.profile-image img').css('opacity', 1);
            }, 0);
            setTimeout(function() {
                $('.profile-info').css('opacity', 1);
            }, 250);
            setTimeout(function() {
                $('.profile-divider').css('width', '60%');
            }, 500);
            setTimeout(function() {
                $('nav.navbar').css('top', 0).css('opacity', 1);
            }, 750);

            var cards = $('.card.is-social');

            $(cards).each(function(i) {
                let ele = $(this);
                setTimeout(function() {
                    ele.addClass('fadeInUp');
                }, 250 * i + 1000);
            })
        });
    </script>
@endsection
