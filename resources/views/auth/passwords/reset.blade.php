@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="columns is-marginless">
        <div class="column is-6-desktop is-offset-3-desktop is-8-tablet is-offset-2-tablet">
            <h2 class="title is-2 is-size-3-touch white-text">Reset Password</h2>
            <div class="card is-rounded m-b-10 form">
                <div class="card-content">
                    @include('partials._flash')

                    <form id="auth" class="form password-reset-form" method="POST" action="{{ route('password.request') }}" v-cloak>
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">

                        <!-- Email -->
                        <div class="field">
                            <p class="control has-icons-left has-icons-right">
                                <input class="input" :class="{'is-danger': errors.has('email'), 'is-success': fields.email &amp;&amp; fields.email.valid}" v-validate="{rules:{required: true, email: true}}" name="email" type="email" placeholder="Email" value="{{ old('email') }}" required>
                                <span class="icon is-small is-left"><i class="fa fa-envelope-o"></i></span>
                                <span class="icon is-small is-right">
                                    <i class="fa" :class="{'fa-warning': errors.has('email'), 'fa-check': fields.email &amp;&amp; fields.email.valid}"></i>
                                </span>
                            </p>
                            <p class="help is-danger" :show="errors.has('email')">@{{ errors.first('email') }}</p>
                        </div>

                        <!-- Password -->
                        <div class="field is-horizontal is-marginless">
                            <div class="field-body">
                                <div class="field">
                                    <p class="control has-icons-left has-icons-right">
                                        <input name="password" :class="{'is-danger': errors.has('password'), 'is-success': fields.password &amp;&amp; fields.password.valid}" v-validate="{rules:{required:true, min:6, confirmed: 'password_confirmation'}}" class="input" type="password" placeholder="Password" required>
                                        <span class="icon is-small is-left"><i class="fa fa-unlock-alt"></i></span>
                                        <span class="icon is-small is-right">
                                            <i class="fa" :class="{'fa-warning': errors.has('password'), 'fa-check': fields.password &amp;&amp; fields.password.valid}"></i>
                                        </span>
                                    </p>
                                </div>
                                <div class="field">
                                    <p class="control has-icons-left has-icons-right">
                                        <input name="password_confirmation" :class="{'is-danger': errors.has('password_confirmation'), 'is-success': fields.password_confirmation &amp;&amp; fields.password_confirmation.valid}" data-vv-name="password confirmation" v-validate="{rules:{required:true}}" class="input" type="password" placeholder="Confirm Password" required>
                                        <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>
                                        <span class="icon is-small is-right">
                                            <i class="fa" :class="{'fa-warning': errors.has('password_confirmation'), 'fa-check': fields.password_confirmation &amp;&amp; fields.password_confirmation.valid}"></i>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <p class="help is-danger" :show="errors.has('password')">@{{ errors.first('password') }}</p>
                            <p class="help is-danger" :show="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</p>
                        </div>

                        <div class="field is-horizontal m-t-20">
                            <div class="field-body">
                                <div class="field is-grouped">
                                    <div class="control is-fullwidth">
                                        <div class="columns">
                                            <div class="column is-6 is-offset-3">
                                                <button type="submit" class="button is-primary is-fullwidth">Send Reset Link</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
