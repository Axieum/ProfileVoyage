@extends('layouts.app')

@section('title', 'Social Linking')
@section('subtitle', 'Add or remove your social accounts')

@section('content')
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <h3 class="title is-4">Linked Accounts</h3>
            <hr>
            <ul>
                @foreach ($socials as $social)
                    <li>{{ $social->platform->display_name }} | {{ $social->value }}</li>
                    <ul style="list-style-type: circle; margin-left: 1.5rem;">
                        @foreach ($social->profiles as $profile)
                            <li>{{ $profile->display_name }}</li>
                        @endforeach
                    </ul>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
