@extends('layouts.auth')

@section('title', 'Email Not Verified')

@section('content')
    <div id="app" class="container has-text-centered">
        <h2 class="title is-2 white-text">Unauthorised Access</h2>
        <p class="subtitle is-4 has-text-weight-light white-text">You must verify your email!</p>
        <a href="{{ route('auth.sendverityemail') }}" class="button is-light" @click="resend" onclick="event.preventDefault(); document.getElementById('sendit').submit();" :disabled="resent === 0">Resend Email</a>
        <form id="sendit" action="{{ route('auth.sendverityemail') }}" method="post" style="display: none;">
            {{ csrf_field() }}
            <input type="hidden" name="api_token" value="{{ Auth::user()->api_token }}">
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                resent: false
            },
            methods: {
                resend: function() {
                    this.resent = true;
                }
            }
        });
    </script>
@endsection
