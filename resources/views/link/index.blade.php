@extends('layouts.app')

@section('title', 'Social Linking')
@section('subtitle', 'Add or remove your social accounts')

@section('content')
    <div class="columns is-multiline">
        @foreach ($socials as $social)
            <div class="column is-6 is-offset-3">
                <div class="card is-horizontal is-rounded">
                    <div class="card-image">
                        <figure class="image is-64x64 has-content-centered">
                            <span class="icon is-large-desktop is-medium-touch"><i class="fa fa-{{ $social->platform->icon() }}"></i></span>
                        </figure>
                    </div>
                    <div class="card-content">
                        <a href="{{ $social->url }}" class="title has-text-weight-normal is-size-4-desktop is-size-6-touch">{{ $social->value }}</a>
                    </div>
                    <div class="card-actions level">
                        <div class="level-item">
                            <a href="#profiles" class="button is-primary is-small-touch is-hoverable">View Profiles</a>
                        </div>
                        <div class="level-item">
                            <form action="{{ route('unlink', $social->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="button is-danger is-small-touch is-hoverable">Unlink</a></form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="column is-6 is-offset-3 m-b-15">
            @if (sizeof($socials) > 0)
                <hr>
            @endif
            <form action="{{ route('link.request') }}" class="has-text-centered" method="post">
                {{ csrf_field() }}
                <p class="is-size-5 has-text-weight-light">Link a new <b class="has-text-weight-normal">social media</b> account</p>
                <div class="field has-addons has-addons-centered m-t-5">
                    <div class="control has-icons-left">
                        <span class="select">
                            <select name="platform">
                                <option selected disabled>Choose a Platform</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform->name }}" {{ $platform->name == old('name') ? 'selected' : '' }}>{{ $platform->display_name }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="icon is-small is-left">
                            <i class="fa fa-external-link-square"></i>
                        </span>
                    </div>
                    <div class="control">
                        <button type="submit" class="button is-primary">Link</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
