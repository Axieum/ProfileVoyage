@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="columns is-marginless">
        <div class="column is-6-desktop is-offset-3-desktop is-8-tablet is-offset-2-tablet">
            <h2 class="title is-2 is-size-3-touch white-text">Register</h2>
            <div class="card is-rounded m-b-10 form">
                <div class="card-content">
                    @if ($errors->any() || session('status'))
                        <div class="notification {{ $errors->any() ? 'is-danger' : 'is-success' }}">
                            <button class="delete"></button>
                            @if (session('status'))
                                {{ session('status') }}
                            @endif
                            @if ($errors->any())
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endif

                    <form id="auth" method="POST" action="{{ route('register') }}" v-cloak>
                        {{ csrf_field() }}

                        <!-- Email -->
                        <div class="field is-horizontal is-marginless columns">
                            <div class="field-body">
                                <div class="field column is-8 is-marginless p-l-0 p-r-0 p-t-0">
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
                                <div class="field column is-4 is-marginless p-r-0 p-t-0">
                                    <p class="control has-icons-left has-icons-right">
                                        <input name="birth_year" :class="{'is-danger': (errors.has('birth_year')), 'is-success': fields.birth_year &amp;&amp; fields.birth_year.valid}" v-validate="{rules:{required:true, integer: true, min_value: 0, max_value: {{ date("Y") }}}}" class="input" type="text" placeholder="Year of Birth" value="{{ old('birth_year') }}" required>
                                        <span class="icon is-small is-left"><i class="fa fa-calendar"></i></span>
                                        <span class="icon is-small is-right">
                                            <i class="fa" :class="{'fa-warning': errors.has('birth_year'), 'fa-check': fields.birth_year &amp;&amp; fields.birth_year.valid}"></i>
                                        </span>
                                    </p>
                                    <p class="help is-danger" :show="errors.has('birth_year')">@{{ errors.first('birth_year') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Link -->
                        <div class="field">
                            <p class="control has-icons-left has-icons-right" :class="{'is-loading': linkLoading}">
                                <input name="link" v-model="linkValue" :class="{'is-danger': (errors.has('link') || !linkAvailable) &amp;&amp; !linkLoading, 'is-success': fields.link &amp;&amp; fields.link.valid &amp;&amp; linkAvailable}" v-validate="{rules:{required: true, min: 2, max: 16, regex: /^[A-Za-z0-9]+(?:-[A-Za-z0-9]+)*$/}}" class="input" type="text" placeholder="Link" value="{{ old('link') }}" required>
                                <span class="icon is-small is-left"><i class="fa fa-link"></i></span>
                                <span class="icon is-small is-right">
                                    <i class="fa" :class="{'fa-warning': (errors.has('link') || !linkAvailable) &amp;&amp; !linkLoading, 'fa-check': fields.link &amp;&amp; fields.link.valid &amp;&amp; !linkLoading}"></i>
                                </span>
                            </p>
                            <p class="help is-danger" :show="errors.has('link')">@{{ errors.first('link') }}</p>
                            <p class="help is-danger" v-show="!errors.has('link') &amp;&amp; !linkAvailable &amp;&amp; !linkLoading">That link is already in use.</p>
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

                        <div class="field is-horizontal m-t-10">
                            <div class="field-body">
                                <div class="field">
                                    <p class="control">
                                        <label class="checkbox">
                                            <b-checkbox type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }} required>
                                            I agree to the <a href="#termsandconditions">terms and conditions</a>
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
                                            <div class="column is-6 is-offset-3">
                                                <button type="submit" class="button is-primary is-fullwidth" >Register</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <h5 class="has-text-centered m-t-15"><a href="{{ route('login') }}" class="muted-text">Already Have an Account?</a></h5>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#auth',
            data: {
                linkLoading: false,
                emailLoading: false,
                linkAvailable: true,
                emailAvailable: true,
                linkValue: "{{ old('link') }}",
                emailValue: "{{ old('email') }}"
            },
            watch: {
                linkValue: function() {
                    this.linkLoading = true;
                    if (this.linkValue.length >= 2 && this.linkValue.length <= 16 && /([-_]*[a-zA-Z0-9]+([-_]*[a-zA-Z0-9]+)*)/.test(this.linkValue)) {
                        this.checkLink();
                    } else {
                        this.linkLoading = false;
                    }
                },
                emailValue: function() {
                    this.emailLoading = true;
                    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
                    if (pattern.test(this.emailValue)) {
                        this.checkEmail();
                    } else {
                        this.emailLoading = false;
                    }
                }
            },
            methods: {
                checkLink:  _.debounce(function () {
                    var app = this;
                    app.linkAvailable = true;
                    axios.post('{{ route('auth.check', 'link') }}', {value: app.linkValue})
                    .then(function (response) {
                        app.linkLoading = false;
                        app.linkAvailable = response.data.valid;
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                        app.linkLoading = false;
                        app.linkAvailable = true; // Ensure they can at least submit the form and get turned away server side.
                    });
                }, 1000),
                checkEmail:  _.debounce(function () {
                    var app = this;
                    app.emailAvailable = true;
                    axios.post('{{ route('auth.check', 'email') }}', {value: app.emailValue})
                    .then(function (response) {
                        app.emailLoading = false;
                        app.emailAvailable = response.data.valid;
                    })
                    .catch(function (error) {
                        console.log(error);
                        app.emailLoading = false;
                        app.emailAvailable = true; // Ensure they can at least submit the form and get turned away server side.
                    });
                }, 1000)
            }
        });
    </script>
@endsection
