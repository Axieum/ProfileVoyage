@extends('layouts.app')

@section('title', 'Account Settings')
@section('subtitle', 'Configure your account')

@section('hero-footer')
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container">
                <ul>
                    <li><a href="{{ route('account.edit.email') }}"><span class="icon is-small"><i class="fa fa-envelope"></i></span>Email</a></li>
                    <li class="is-active"><a><span class="icon is-small"><i class="fa fa-lock"></i></span>Security</a></li>
                </ul>
            </div>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="columns">
            <div class="column is-6 is-offset-3">
                @include('partials._errors')
                
                <form class="form" action="{{ route('account.update.security') }}" method="POST" v-cloak>
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <h3 class="title is-4">Change Password</h3>
                    <hr>

                    <!-- Current Password -->
                    <div class="field">
                        <p class="label is-size-6 has-text-weight-light">You must provide your <b class="has-text-weight-normal">current password</b> for security purposes.</p>
                        <div class="control has-icons-left has-icons-right">
                            <input v-model="password_current" type="password" class="input" placeholder="Current Password" name="password_current" required :class="{'is-danger': errors.has('password_current'), 'is-success': fields.password_current &amp;&amp; fields.password_current.valid }" v-validate="{rules:{required: true}}">
                            <span class="icon is-small is-left"><i class="fa fa-unlock"></i></span>
                            <span class="icon is-small is-right">
                                <i class="fa" :class="{'fa-warning': errors.has('password_current'), 'fa-check': fields.password_current &amp;&amp; fields.password_current.valid}"></i>
                            </span>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="field">
                        <p class="label is-size-6 has-text-weight-light">Once set, this will be your <b class="has-text-weight-normal">new password</b> for logging in.</p>
                        <div class="control has-icons-left has-icons-right">
                            <input v-model="password" type="password" class="input" placeholder="New Password" name="password" required :class="{'is-danger': errors.has('password'), 'is-success': fields.password &amp;&amp; fields.password.valid}" v-validate="{rules:{required:true, min:6, confirmed: 'password_confirmation'}}">
                            <span class="icon is-small"><i class="fa fa-unlock-alt"></i></span>
                            <span class="icon is-small is-right">
                                <i class="fa" :class="{'fa-warning': errors.has('password'), 'fa-check': fields.password &amp;&amp; fields.password.valid}"></i>
                            </span>
                        </div>
                        <p class="help is-danger" :show="errors.has('password')">@{{ errors.first('password') }}</p>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input v-model="password_confirmation" type="password" class="input" placeholder="Confirm New Password" name="password_confirmation" required :class="{'is-danger': errors.has('password'), 'is-success': fields.password &amp;&amp; fields.password.valid}" data-vv-name="password confirmation" v-validate="{rules:{required:true}}">
                            <span class="icon is-small is-left"><i class="fa fa-lock"></i></span>
                            <span class="icon is-small is-right">
                                <i class="fa" :class="{'fa-warning': errors.has('password'), 'fa-check': fields.password &amp;&amp; fields.password.valid}"></i>
                            </span>
                        </div>
                        <p class="help is-danger" :show="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</p>
                    </div>

                    <div class="field columns m-t-15">
                        <div class="column is-4 is-offset-4">
                            <button type="submit" class="button is-primary is-fullwidth" :disabled="submittable == 0">Update Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="columns">
            <div class="column is-6 is-offset-3">
                <form id="deleteAccount" class="form" action="{{ route('account.delete') }}" method="POST">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}

                    <h3 class="title is-4">Destroy Account</h3>
                    <hr>

                    <p class="label is-size-6 has-text-weight-light">Clicking this button will delete your account. There is <b class="has-text-weight-normal">no turning back</b>!</p>
                    <div class="column is-4 is-offset-4">
                        <button type="button" @click="confirmDeletion" class="button is-danger is-fullwidth">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: 'main',
            data: {
                password_current: '',
                password: '',
                password_confirmation: '',
                submittable: false
            },
            watch: {
                password_current: function() {
                    this.openSesame();
                },
                password: function() {
                    this.openSesame();
                },
                password_confirmation: function() {
                    this.openSesame();
                }
            },
            methods: {
                openSesame: _.debounce(function() {
                    var errors = this.errors.has('password_current') || this.errors.has('password') || this.errors.has('password_confirmation');
                    var equality = this.password === this.password_current;
                    var length = this.password.length > 0 && this.password_current.length > 0 && this.password_confirmation.length > 0;
                    this.submittable = !errors && !equality && length;
                }, 250),
                confirmDeletion: function() {
                    if (confirm('Are you sure you want to delete your account? This action cannot be reversed.'))
                        document.getElementById('deleteAccount').submit();
                }
            }
        });
    </script>
@endsection
