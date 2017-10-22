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

                    <!-- Name -->
                    <div class="field">
                        <label class="label">Name</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="text" placeholder="{{ Auth::user()->profile->name }}" :class="{'is-danger': errors.has('name'), 'is-success': fields.name &amp;&amp; fields.name.valid }" v-validate="{rules:{alpha_spaces: true, max: 64, min: 2 }}" value="{{ old('name') }}" name="name">
                            <span class="icon is-small"><i class="fa fa-user-o"></i></span>
                        </div>
                        <p class="help is-danger" :show="errors.has('name')">@{{ errors.first('name') }}</p>
                    </div>

                    <!-- Location -->
                    <div class="field">
                        <label class="label">Location</label>
                        <div class="control has-icons-left has-icons-right">
                            <input class="input" type="text" placeholder="{{ Auth::user()->profile->location ?: 'e.g. Antarctica' }}" :class="{'is-danger': errors.has('location'), 'is-success': fields.location &amp;&amp; fields.location.valid }" v-validate="{rules:{alpha_spaces: true, max: 85, min: 1 }}" value="{{ old('location') }}" name="location">
                            <span class="icon is-small"><i class="fa fa-globe"></i></span>
                        </div>
                        <p class="help is-danger" :show="errors.has('location')">@{{ errors.first('location') }}</p>
                    </div>

                    <!-- Date of Birth -->
                    <div class="field">
                        <label class="label">Date of Birth</label>
                        <div class="field has-addons">
                            <p class="control">
                                <span class="select">
                                    <select name="dob_day">
                                        <option selected disabled>Day</option>
                                        @for ($i=1; $i <= 31; $i++)
                                            <option value="{{ $i }}" {{ date('d', strtotime(Auth::user()->profile->date_of_birth)) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </span>
                            </p>
                            <p class="control">
                                <span class="select">
                                    <select name="dob_month">
                                        <option selected disabled>Month</option>
                                        @foreach (array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December') as $month)
                                            <option value="{{ $loop->iteration }}" {{ date('m', strtotime(Auth::user()->profile->date_of_birth)) == $loop->iteration ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </p>
                            <p class="control">
                                <span class="select">
                                    <select name="dob_year">
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
