@extends('layouts.app')

@section('title', "Social References")
@section('subtitle', "View a profile's references to social accounts")

@section('content')
    <div id="wrapper" class="container">
        <div class="columns m-b-15">
            <div class="column is-6-desktop is-offset-3-desktop is-8-tablet is-offset-2-tablet">
                <div class="card is-horizontal is-rounded">
                    <div class="card-image">
                        <figure class="image is-64x64 has-content-centered">
                            <b-tooltip label="{{ $social->platform->display_name }}" position="is-top" type="is-primary" animated>
                                <span class="icon is-large-desktop is-medium-touch"><i class="fa fa-{{ $social->platform->icon() }}"></i></span>
                            </b-tooltip>
                        </figure>
                    </div>
                    <div class="card-content">
                        <a href="{{ $social->url }}" class="title has-text-weight-normal is-size-4-desktop is-size-6-touch">{{ $social->value }}</a>
                    </div>
                    <div class="card-actions level is-mobile">
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
        </div>
        <div class="columns">
            @if (sizeof($profiles) <= 0)
                <p class="is-size-5-desktop is-size-6-touch">This social account has <b>no references</b> to any <a href="{{ route('profile.index') }}">profile</a>.</p>
            @endif
        </div>
        <div class="columns is-multiline is-mobile m-b-15">
            @foreach ($profiles as $profile)
                <div class="column is-3-desktop is-4-tablet is-12-mobile">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-1by1">
                                <img src="{{ url(file_exists(storage_path('app\\public\\avatars\\' . $profile->avatar . '.png')) ? 'storage/avatars/' . $profile->avatar . '.png' : 'img/_profile.png') }}" alt="Profile avatar">
                            </figure>
                        </div>
                        <div class="card-content">
                            <div class="card-head">
                                <p class="title is-4 m-b-0">{{ $profile->name }}</p>
                                <a href="{{ route('profile.show', $profile->link) }}" class="is-size-6">
                                    <span class="icon is-small"><i class="fa fa-link"></i></span>
                                    {{ substr(route('profile.show', $profile->link), strpos(route('profile.show', $profile->link), '//') + 2) }}
                                </a>
                                <a onclick="copyLink(this);" data-value="{{ route('profile.show', $profile->link) }}"><span class="icon is-small"><i class="fa fa-share-square-o"></i></span></a>
                            </div>
                            <div class="level is-mobile">
                                <div class="level-left">
                                    <small class="level-item">
                                        <span class="icon is-small"><i class="fa fa-clock-o"></i></span>&nbsp;<time datetime="{{ $profile->updated_at }}">{{ date('jS \o\f F Y', strtotime($profile->updated_at)) }}</time>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <footer class="card-footer">
                            <a href="{{ route('profile.show', $profile->link) }}" class="card-footer-item"><span class="icon"><i class="fa fa-eye"></i></span>&nbsp;View</a>
                            <a href="{{ route('profile.edit', $profile->link) }}" class="card-footer-item"><span class="icon"><i class="fa fa-pencil"></i></span>&nbsp;Edit</a>
                        </footer>
                    </div>
                </div>
            @endforeach
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
    <script>
        function copyLink(element) {
            var link = element.getAttribute("data-value");

            // Create a temporary element to hold the link.
            target = document.getElementById("_hiddenCopyText_");
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = "_hiddenCopyText_";
                document.body.appendChild(target);
            }
            target.textContent = link;

            // Select the text.
            var currentFocus = document.activeElement;
            target.focus();
            target.setSelectionRange(0, target.value.length);

            // Try to copy it.
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successfully' : 'unsuccessfully';
                var type = successful ? 'success' : 'danger';
                notifications.toast('The profile link "' + link + '" was copied ' + msg, {type: 'is-' + type});
            } catch(error) {
                notifications.toast('Something went wrong, unable to copy the url.', {type: 'is-danger'});
            }

            // Remove temporary element.
            target.remove();
        }
    </script>
@endsection
