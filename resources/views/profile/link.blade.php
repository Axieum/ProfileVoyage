@extends('layouts.app')

@section('title', "Profile Editing")
@section('subtitle', 'Make changes to an existing profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/mdi.css') }}">
@endsection

@section('hero-footer')
    <div class="hero-foot">
        <nav class="tabs is-boxed is-fullwidth">
            <div class="container is-fullwidth p-l-15 p-r-15">
                <ul>
                    <li><a href="{{ route('profile.edit', $profile->link) }}"><span class="icon is-small"><i class="fa fa-id-card"></i></span>General</a></li>
                    <li class="is-active"><a><span class="icon is-small"><i class="fa fa-external-link-square"></i></span>Social Links</a></li>
                </ul>
            </div>
        </nav>
    </div>
@endsection

@section('content')
    <div id="wrapper" class="container">
        <div class="columns">
            <div class="column is-6 is-offset-3">
                @include('partials._errors')

                <div class="level is-mobile is-marginless">
                    <div class="level-left">
                        <h3 class="title is-4">Editing: <a href="{{ route('profile.show', $profile->link) }}" class="has-text-weight-normal">{{ $profile->name }}</a></h3>
                    </div>
                </div>
                <hr style="margin-top: 0.5rem;">

                @if(sizeof($profile->socials) > 0)
                    <h3 class="title is-size-5-desktop is-size-6-touch is-marginless">Showing:</h3>
                @endif

                @foreach ($profile->socials as $social)
                    <div class="column is-12">
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
                                    <form action="{{ route('profile.links.remove', ['profileLink' => $profile->link, 'id' => $social->id]) }}" method="post" data-for="{{ $social->platform->display_name }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <b-tooltip label="Remove" position="is-top" type="is-danger" animated>
                                            <button v-on:click.prevent.stop="confirmUnlink(this.event)" type="submit" class="button is-danger is-small-touch is-hoverable">
                                                <span class="icon is-small"><i class="fa fa-times"></i></span>
                                            </button>
                                        </b-tooltip>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if (sizeof($profile->socials) > 0)
                    <hr>
                @endif
                @if (sizeof($profile->socials) != sizeof($socials))
                    <h3 class="title is-size-5-desktop is-size-6-touch is-marginless">Hidden:</h3>
                @endif
                @foreach ($socials as $social)
                    {{-- Only print the linked profiles here --}}
                    @if(!$profile->socials->contains('id', $social->id))
                        <div class="column is-12">
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
                                        <form action="{{ route('profile.links.add', $profile->link) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="text" style="display: none;" name="social_id" value="{{ $social->id }}">
                                            <b-tooltip label="Add" position="is-top" type="is-success" animated>
                                                <button type="submit" class="button is-success is-small-touch is-hoverable">
                                                    <span class="icon is-small"><i class="fa fa-plus"></i></span>
                                                </button>
                                            </b-tooltip>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <hr>
                <p class="is-size-5 has-text-weight-light has-text-centered">Need to <b class="has-text-weight-normal">link</b> a new <a href="{{ route('link.index') }}" class="has-text-weight-normal">social media</a> account?</p>
            </div>
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
                        title: 'Remove Reference',
                        message: 'Are you sure you want to <i>remove</i> this <b>' + $(ele.target).closest('form').attr('data-for') + '</b> account from this <b>{{ $profile->name }}</b> profile?',
                        confirmText: 'Remove',
                        type: 'is-warning',
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
