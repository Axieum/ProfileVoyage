@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="columns is-marginless">
        <div class="column is-6-desktop is-offset-3-desktop is-8-tablet is-offset-2-tablet">
            <h2 class="title is-2 is-size-3-touch white-text">Register</h2>
            <div class="card is-rounded m-b-10 form">
                <div class="card-content">
                    @include('partials._flash')

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
                                        <b-datepicker name="date_of_birth" :class="{'is-danger': (errors.has('date_of_birth')), 'is-success': fields.date_of_birth &amp;&amp; fields.date_of_birth.valid}" v-validate="{rules:{required:true}}" :focused-date="maxDate" :min-date="minDate" :max-date="maxDate" placeholder="Date of Birth"  required></b-datepicker>
                                        <span class="icon is-small is-left"><i class="fa fa-calendar"></i></span>
                                        <span class="icon is-small is-right">
                                            <i class="fa" :class="{'fa-warning': errors.has('date_of_birth'), 'fa-check': fields.date_of_birth &amp;&amp; fields.date_of_birth.valid}"></i>
                                        </span>
                                    </p>
                                    <p class="help is-danger" :show="errors.has('date_of_birth')">@{{ errors.first('date_of_birth') }}</p>
                                </div>
                            </div>
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
        const today = new Date();
        var app = new Vue({
            el: '#auth',
            data: {
                emailLoading: false,
                emailAvailable: true,
                emailValue: "{{ old('email') }}",
                minDate: new Date(today.getFullYear() - 128, today.getMonth(), today.getDate()),
                maxDate: new Date(today.getFullYear() - 13, today.getMonth(), today.getDate())
            },
            watch: {
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
                        app.emailAvailable = true;
                    });
                }, 1000)
            }
        });
    </script>
@endsection
