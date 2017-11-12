@extends('layouts.app')

@section('title', 'Account Settings')
@section('subtitle', 'Configure your account')

@section('hero-footer')
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container">
                <ul>
                    <li><a href="{{ route('account.edit') }}"><span class="icon is-small"><i class="fa fa-address-card"></i></span>General</a></li>
                    <li class="is-active"><a><span class="icon is-small"><i class="fa fa-envelope"></i></span>Email</a></li>
                    <li><a href="{{ route('account.edit.security') }}"><span class="icon is-small"><i class="fa fa-lock"></i></span>Security</a></li>
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
                <form class="form" action="{{ route('account.update.email') }}" method="POST" v-cloak>
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <h3 class="title is-4">Change Email</h3>
                    <hr>

                    <!-- New Email -->
                    <div class="field">
                        <p class="label is-size-6 has-text-weight-light">Your current email is <b class="has-text-weight-normal">{{ Auth::user()->email }}</b>.</p>
                        <p class="control has-icons-left has-icons-right" :class="{'is-loading': emailLoading}">
                            <input name="email" v-model="emailValue" :class="{'is-danger': (errors.has('email') || !emailAvailable) &amp;&amp; !emailLoading, 'is-success': fields.email &amp;&amp; fields.email.valid &amp;&amp; emailAvailable}" v-validate="{rules:{required:true, email: true}}" class="input" type="email" placeholder="Email" value="{{ old('email') }}" required>
                            <span class="icon is-small is-left"><i class="fa fa-envelope-o"></i></span>
                            <span class="icon is-small is-right">
                                <i class="fa" :class="{'fa-warning': (errors.has('email') || !emailAvailable) &amp;&amp; !emailLoading, 'fa-check': fields.email &amp;&amp; fields.email.valid &amp;&amp; !emailLoading}"></i>
                            </span>
                        </p>
                        <p class="help is-danger" :show="errors.has('email')">@{{ errors.first('email') }}</p>
                        <p class="help is-danger" v-show="!errors.has('email') &amp;&amp; !emailAvailable &amp;&amp; !emailLoading">That email is already in use.</p>
                    </div>

                    <!-- Confirm New Email -->
                    <div class="field">
                        <div class="control has-icons-left has-icons-right">
                            <input v-model="email_confirmation" type="email" class="input" placeholder="Confirm New email" name="email_confirmation" required :class="{'is-danger': errors.has('email'), 'is-success': fields.email &amp;&amp; fields.email.valid}" data-vv-name="email confirmation" v-validate="{rules:{required:true}}">
                            <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
                            <span class="icon is-small is-right">
                                <i class="fa" :class="{'fa-warning': errors.has('email'), 'fa-check': fields.email &amp;&amp; fields.email.valid}"></i>
                            </span>
                        </div>
                        <p class="help is-danger" :show="errors.has('email_confirmation')">@{{ errors.first('email_confirmation') }}</p>
                    </div>

                    <p class="label is-size-6 has-text-weight-light">Once updated, you'll need to <b class="has-text-weight-normal">verify</b> your new email.</p>
                    <div class="field columns m-t-15">
                        <div class="column is-4 is-offset-4">
                            <button type="submit" class="button is-primary is-fullwidth" :disabled="submittable == 0">Change Email!</button>
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
            el: 'main',
            data: {
                emailLoading: false,
                emailAvailable: true,
                emailValue: "{{ old('email') }}",
                email_confirmation: '',
                emailCurrent: '{{ Auth::user()->email }}',
                submittable: false
            },
            watch: {
                emailValue: function() {
                    this.emailLoading = true;
                    if (this.emailValue === this.emailCurrent) {
                        this.emailLoading = false;
                        app.emailAvailable = false;
                    } else {
                        if (!this.errors.has('email')) {
                            this.checkEmail();
                        } else {
                            this.emailLoading = false;
                        }
                    }
                    this.openSesame();
                },
                email_confirmation: function() {
                    this.openSesame();
                }
            },
            methods: {
                checkEmail:  _.debounce(function () {
                    var app = this;
                    app.emailAvailable = true;
                    axios.post('{{ route('auth.check', 'email') }}', {value: app.emailValue})
                    .then(function (response) {
                        app.emailLoading = false;
                        app.emailAvailable = response.data;
                    })
                    .catch(function (error) {
                        console.log(error);
                        app.emailLoading = false;
                        app.emailAvailable = true; // Ensure they can at least submit the form and get turned away server side.
                    });
                }, 1000),
                openSesame: _.debounce(function() {
                    var errors = this.errors.has('email') || !this.emailAvailable || this.errors.has('email_confirmation');
                    var equality = this.emailValue === this.email_confirmation && this.emailValue != this.emailCurrent;
                    var length = this.emailValue.length > 0 && this.email_confirmation.length > 0;
                    this.submittable = !errors && equality && length;
                }, 250)
            }
        });
    </script>
@endsection
