@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="columns is-marginless">
        <div class="column is-4-desktop is-offset-4-desktop is-6-tablet is-offset-3-tablet">
            <h2 class="title is-2 is-size-3-touch white-text">Login</h2>
            <div class="card is-rounded m-b-10 form">
                <div class="card-content">
                    @include('partials._flash')

                    <form id="auth" class="login-form" method="POST" action="{{ route('login') }}" v-cloak>
                        {{ csrf_field() }}

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <p class="control has-icons-left has-icons-right">
                                        <input class="input" :class="{'is-danger': errors.has('email'), 'is-success': fields.email &amp;&amp; fields.email.valid}" v-validate="{rules:{required: true, email: true}}" id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                                        <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                                        <span class="icon is-small is-right">
                                            <i class="fa" :class="{'fa-warning': errors.has('email'), 'fa-check': fields.email &amp;&amp; fields.email.valid}"></i>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <p class="control has-icons-left has-icons-right">
                                        <input class="input" :class="{'is-danger': errors.has('password'), 'is-success': fields.password &amp;&amp; fields.password.valid}" v-validate="{rules:{required:true}}" id="password" type="password" name="password" placeholder="Password" required>
                                        <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>
                                        <span class="icon is-small is-right">
                                            <i class="fa" :class="{'fa-warning': errors.has('password'), 'fa-check': fields.password &amp;&amp; fields.password.valid}"></i>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <label class="checkbox">
                                            <b-checkbox type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field is-grouped">
                                    <div class="control is-fullwidth">
                                        <div class="columns">
                                            <div class="column is-8">
                                                <button type="submit" class="button is-primary is-fullwidth">Login</button>
                                            </div>
                                            <div class="column is-4">
                                                <a href="{{ route('register') }}" class="button is-light is-fullwidth">Register</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <h5 class="has-text-centered m-t-15"><a href="{{ route('password.request') }}" class="muted-text">Forgot Password?</a></h5>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#auth'
        });
    </script>
@endsection
