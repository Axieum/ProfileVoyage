@extends('layouts.profile')

@section('title', $profile->display_name . "'s Profile")

@section('content')
    @if (!Auth::guest() && Auth::user()->id === $profile->user_id)
        <a id="cog" class="white-text" href="{{ route('profile.edit', $profile->link) }}">
            <span>Edit Profile</span><span class="icon is-medium"><i class="fa fa-cog"></i></span>
        </a>
    @endif
    <div class="profile-image has-content-hcentered">
        <figure class="image is-256x256-desktop is-128x128-touch">
            <img class="is-circle has-border" src="https://placehold.it/256x256" alt="{{ $profile->display_name }}'s Profile Picture">
        </figure>
    </div>
    <div class="profile-info has-text-centered m-t-15">
        <h1 class="title white-text is-size-1-desktop is-size-3-touch">{{ $profile->display_name }}</h1>
        @if (!is_null($profile->motto))
            <p class="subtitle has-text-weight-light white-text is-size-4-desktop is-size-6-touch">"<i>{{ $profile->motto }}</i>"</p>
        @endif
    </div>
    <p class="profile-divider"></p>
    <div class="profile-links">
        <div class="columns is-mobile is-multiline has-content-hcentered">
            <!-- Link Template -->
            <div class="column is-4-desktop is-6-tablet is-12-mobile">
                <a href="#twitter">
                    <div class="card is-social is-horizontal is-rounded">
                        <div class="card-image">
                            <figure class="image is-64x64 has-content-centered">
                                <span class="icon is-large"><i class="fa fa-twitter"></i></span>
                            </figure>
                        </div>
                        <div class="card-content">
                            <p class="title is-size-4-desktop is-size-5-touch">@yberiner</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- End Link Template -->
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

            var cards = $('.card.is-social');

            $(cards).each(function(i) {
                let ele = $(this);
                setTimeout(function() {
                    ele.addClass('animated').addClass('fadeInUp');
                }, 250 * i + 750);
            })
        });
    </script>
@endsection
