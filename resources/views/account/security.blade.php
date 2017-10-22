@extends('layouts.app')

@section('title', 'Account Settings')
@section('subtitle', 'Configure your account')

@section('hero-footer')
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container is-fullwidth-touch">
                <ul>
                    <li><a href="{{ route('account.edit') }}"><span class="icon is-small"><i class="fa fa-address-card"></i></span>General</a></li>
                    <li><a href="{{ route('account.edit.email') }}"><span class="icon is-small"><i class="fa fa-envelope"></i></span>Email</a></li>
                    <li class="is-active"><a><span class="icon is-small"><i class="fa fa-lock"></i></span>Security</a></li>
                </ul>
            </div>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">

        @if ($errors->any())
            <div class="notification is-danger">
                <button class="delete"></button>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="columns">
            <div class="column is-6 is-offset-3">
                <form class="form" action="{{ route('account.update.security') }}" method="POST" v-cloak>
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <!-- Password -->

                    <div class="field columns m-t-15">
                        <div class="column is-4 is-offset-4">
                            <button type="submit" class="button is-primary is-fullwidth">Save Changes!</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: 'main'
        });
    </script>
@endsection
