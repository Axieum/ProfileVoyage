@extends('layouts.app')

@section('title', 'Account Settings')
@section('subtitle', 'Configure your account')

@section('hero-footer')
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container">
                <ul>
                    <li class="is-active"><a><span class="icon is-small"><i class="fa fa-address-card"></i></span>General</a></li>
                    <li><a href="{{ route('account.edit.email') }}"><span class="icon is-small"><i class="fa fa-envelope"></i></span>Email</a></li>
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
                <form class="form" action="{{ route('account.update') }}" method="POST" v-cloak>
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <h3 class="title is-4">Update Account Details</h3>
                    <hr>

                    <!-- Name -->
                    <div class="field">
                        <p class="label is-size-6 has-text-weight-light"><b class="has-text-weight-normal">Name</b> your account (e.g. John Doe)</p>
                        <div class="control has-icons-left has-icons-right">
                            <input v-model="name" class="input" type="text" placeholder="Name" :class="{'is-danger': errors.has('name'), 'is-success': fields.name &amp;&amp; fields.name.valid }" v-validate="{rules:{alpha_spaces: true, max: 64, min: 2 }}" value="{{ old('name') }}" name="name">
                            <span class="icon is-small"><i class="fa fa-user-o"></i></span>
                        </div>
                        <p class="help is-danger" :show="errors.has('name')">@{{ errors.first('name') }}</p>
                    </div>

                    <!-- Location -->
                    <div class="field">
                        <p class="label is-size-6 has-text-weight-light"><b class="has-text-weight-normal">Where</b> are you? (e.g. England)</p>
                        <div class="control has-icons-left has-icons-right">
                            <input v-model="location" class="input" type="text" placeholder="Location" :class="{'is-danger': errors.has('location'), 'is-success': fields.location &amp;&amp; fields.location.valid }" v-validate="{rules:{alpha_spaces: true, max: 85, min: 1 }}" value="{{ old('location') }}" name="location">
                            <span class="icon is-small"><i class="fa fa-globe"></i></span>
                        </div>
                        <p class="help is-danger" :show="errors.has('location')">@{{ errors.first('location') }}</p>
                    </div>

                    <!-- Date of Birth -->
                    <div class="field">
                        <p class="label is-size-6 has-text-weight-light">When were you <b class="has-text-weight-normal">born</b>?</p>
                        <div class="field has-addons">
                            <p class="control">
                                <span class="select">
                                    <select name="dob_day" v-model="dob_day">
                                        <option selected disabled>Day</option>
                                        @for ($i=1; $i <= 31; $i++)
                                            <option value="{{ $i }}" {{ date('d', strtotime(Auth::user()->profile->date_of_birth)) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </p>
                            <p class="control">
                                <span class="select">
                                    <select name="dob_month" v-model="dob_month">
                                        <option selected disabled>Month</option>
                                        @foreach (array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December') as $month)
                                            <option value="{{ $loop->iteration }}" {{ date('m', strtotime(Auth::user()->profile->date_of_birth)) == $loop->iteration ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </p>
                            <p class="control">
                                <span class="select">
                                    <select name="dob_year" v-model="dob_year">
                                        <option selected disabled>Year</option>
                                        @for ($i=date('Y') - 13; $i >= date('Y') - 128; $i--)
                                            <option value="{{ $i }}" {{ date('Y', strtotime(Auth::user()->profile->date_of_birth)) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="field columns m-t-15">
                        <div class="column is-4 is-offset-4">
                            <button type="submit" class="button is-primary is-fullwidth" :disabled="submittable == 0">Save Changes</button>
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
                oldName: "{{ Auth::user()->profile->name }}",
                oldLocation: "{{ Auth::user()->profile->location }}",
                oldDD: {{ date('d', strtotime(Auth::user()->profile->date_of_birth)) }},
                oldDM: {{ date('m', strtotime(Auth::user()->profile->date_of_birth)) }},
                oldDY: {{ date('Y', strtotime(Auth::user()->profile->date_of_birth)) }},
                name: "{{ Auth::user()->profile->name }}",
                location: "{{ Auth::user()->profile->location }}",
                dob_day: {{ date('d', strtotime(Auth::user()->profile->date_of_birth)) }},
                dob_month: {{ date('m', strtotime(Auth::user()->profile->date_of_birth)) }},
                dob_year: {{ date('Y', strtotime(Auth::user()->profile->date_of_birth)) }},
                submittable: false
            },
            watch: {
                name: function() {
                    this.openSesame();
                },
                location: function() {
                    this.openSesame();
                },
                dob_day: function() {
                    this.openSesame();
                },
                dob_month: function() {
                    this.openSesame();
                },
                dob_year: function() {
                    this.openSesame();
                }
            },
            methods: {
                openSesame: function() {
                    this.submittable = this.oldName != this.name || this.oldLocation != this.location  || this.oldDD != this.dob_day || this.oldDM != this.dob_month || this.oldDY != this.dob_year;
                }
            }
        });
    </script>
@endsection
