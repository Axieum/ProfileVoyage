@extends('layouts.app')

@section('title', 'Social Linking')
@section('subtitle', 'Add or remove your social accounts')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/mdi.css') }}">
@endsection

@section('content')
    <div id="wrapper" class="columns is-multiline">
        @if (sizeof($socials) >= 5)
        <div class="column is-6 is-offset-3">
            <form action="{{ route('link.request') }}" class="has-text-centered" method="post">
                {{ csrf_field() }}
                <p class="is-size-5 has-text-weight-light">Link a new <b class="has-text-weight-normal">social media</b> account</p>
                <div class="field has-addons has-addons-centered m-t-5">
                    <div class="control has-icons-left">
                        <span class="select">
                            <select name="platform">
                                <option selected disabled>Choose a Platform</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform->name }}" {{ $platform->name == old('name') ? 'selected' : '' }}>{{ $platform->display_name }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="icon is-small is-left">
                            <i class="fa fa-external-link-square"></i>
                        </span>
                    </div>
                    <div class="control">
                        <button type="submit" class="button is-primary">Link</button>
                    </div>
                </div>
            </form>
            <hr class="m-b-15">
        </div>
        @endif
        @foreach ($socials as $social)
            <div class="column is-6 is-offset-3">
                <div class="card is-horizontal is-rounded">
                    <div class="card-image">
                        <figure class="image is-64x64 has-content-centered">
                            <b-tooltip label="{{ $social->platform->display_name }}" position="is-top" type="is-primary" animated>
                                <span class="icon is-large-desktop is-medium-touch"><i class="mdi mdi-{{ $social->platform->icon() }}"></i></span>
                            </b-tooltip>
                        </figure>
                    </div>
                    <div class="card-content">
                        <a href="{{ $social->url }}" class="title has-text-weight-normal is-size-4-desktop is-size-6-touch">{{ $social->value }}</a>
                    </div>
                    <div class="card-actions level is-mobile">
                        <div class="level-item">
                            <b-tooltip label="View Profiles ({{ sizeof($social->profiles) }})" position="is-top" type="is-primary" animated>
                                <a href="{{ route('link.show', $social->id) }}" class="button is-primary is-small-touch is-hoverable">
                                    <span class="icon is-small"><i class="fa fa-eye"></i></span>
                                </a>
                            </b-tooltip>
                        </div>
                        <div class="level-item">
                            <form action="{{ route('unlink', $social->id) }}" method="post" data-for="{{ $social->platform->display_name }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <b-tooltip label="Unlink" position="is-top" type="is-danger" animated>
                                    <button v-on:click.prevent.stop="confirmUnlink(this.event)" type="submit" class="button is-danger is-small-touch is-hoverable">
                                        <span class="icon is-small"><i class="fa fa-chain-broken"></i></span>
                                    </button>
                                </b-tooltip>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="column is-6 is-offset-3 m-b-15">
            @if (sizeof($socials) > 0)
                <hr>
            @endif
            <form action="{{ route('link.request') }}" class="has-text-centered" method="post">
                {{ csrf_field() }}
                <p class="is-size-5 has-text-weight-light">Link a new <b class="has-text-weight-normal">social media</b> account</p>
                <div class="field has-addons has-addons-centered m-t-5">
                    <div class="control has-icons-left">
                        <span class="select">
                            <select name="platform">
                                <option selected disabled>Choose a Platform</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{ $platform->name }}" {{ $platform->name == old('name') ? 'selected' : '' }}>{{ $platform->display_name }}</option>
                                @endforeach
                            </select>
                        </span>
                        <span class="icon is-small is-left">
                            <i class="fa fa-external-link-square"></i>
                        </span>
                    </div>
                    <div class="control">
                        <button type="submit" class="button is-primary">Link</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#wrapper',
            methods: {
                confirmUnlink: function(ele) {
                    this.$dialog.confirm({
                        title: 'Unlinking Account',
                        message: 'Are you sure you want to <b>unlink</b> this ' + $(ele.target).closest('form').attr('data-for') + ' account?',
                        confirmText: 'Unlink',
                        type: 'is-danger',
                        hasIcon: true,
                        onConfirm: () => {
                            $(ele.target).closest('form').submit();
                        }
                    });
                }
            }
        });
    </script>
@endsection
