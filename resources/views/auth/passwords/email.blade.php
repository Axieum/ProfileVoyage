@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="columns is-marginless">
        <div class="column is-4-desktop is-offset-4-desktop is-8-tablet is-offset-2-tablet">
            <h2 class="title is-2 is-size-3-touch white-text">Reset Password</h2>
            <div class="card is-rounded m-b-10 form">
                <div class="card-content">
                    @include('partials._flash')

                    <form id="auth" class="form forgot-password-form" method="POST" action="{{ route('password.email') }}" v-cloak>
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

                        <div class="field m-t-10">
                            <div class="field-body">
                                <div class="control is-fullwidth">
                                    <div class="columns">
                                        <div class="column is-6 is-offset-3">
                                            <button type="submit" class="button is-primary is-fullwidth">Send Reset Link</button>
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
