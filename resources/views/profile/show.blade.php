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
                            <span class="icon white-text"><i class="mdi mdi-cake-variant"></i></span><time class="time white-text" datetime="{{ $profile->date_of_birth }}">{{ date('jS \o\f F, Y', strtotime($profile->date_of_birth)) }}</time>
                        </div>
                    @endif
                    @if (!is_null($profile->location))
                        <div class="level-item">
                            <span class="icon white-text"><i class="mdi mdi-map-marker"></i></span><p class="white-text">{{ $profile->location }}</p>
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
    <div id="profile-links" class="profile-links">
        <div class="columns is-mobile is-multiline has-content-hcentered">
            @if (sizeof($profile->socials) < 1 && !Auth::guest() && $profile->user_id == Auth::user()->id)
                <p class="is-size-5-desktop is-size-6-touch white-text has-text-weight-light">You haven't linked any social accounts yet. <a href="{{ route('profile.links', $profile->link) }}" class="has-text-weight-normal white-text">Click here to do just that!</a></p>
            @endif
            @foreach ($profile->socials()->select('*', 'socials.id as id')->join('social_platforms', 'social_platforms.id', '=', 'socials.platform_id')->orderBy('social_platforms.display_name')->get() as $social)
                <div class="column social-wrapper is-4-desktop is-6-tablet is-12-mobile">
                    <a href="{{ $social->url }}">
                        <div class="card is-social is-horizontal is-rounded">
                            <div class="card-image">
                                <figure class="image is-64x64 has-content-centered">
                                    <span class="icon is-large"><i class="mdi mdi-{{ $social->platform->icon() }}"></i></span>
                                </figure>
                            </div>
                            <div class="card-content">
                                <p class="title is-size-4-desktop is-size-5-touch has-text-weight-normal">{{ $social->value }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection
