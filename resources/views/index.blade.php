@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="title is-large is-size-2-touch white-text">
                    <h1 class="title is-large is-size-2-touch white-text">Profile Voyage</h1>
                    <p class="subtitle has-text-weight-light is-size-6-touch is-size-4-desktop muted-text">Share your online presence with a single link!</p>
                </div>
            </div>
        </div>
        <div class="hero-footer">
            <div id="steps" class="container">
                <div class="columns is-marginless">
                    <a href="#!" class="column has-text-centered has-content">
                        <span class="icon is-large"><i class="fa fa-plug"></i></span>
                        <p class="title is-size-3-desktop is-size-4-touch m-t-10">Connect</p>
                        <p class="subtitle is-size-6-touch">Link social media platforms to your account.</p>
                    </a>
                    <a href="#!" class="column has-text-centered has-content">
                        <span class="icon is-large"><i class="fa fa-id-card"></i></span>
                        <p class="title is-size-3-desktop is-size-4-touch m-t-10">Create</p>
                        <p class="subtitle is-size-6-touch">Build individual profiles for specific audiences.</p>
                    </a>
                    <a href="#!" class="column has-text-centered has-content">
                        <span class="icon is-large"><i class="fa fa-shield"></i></span>
                        <p class="title is-size-3-desktop is-size-4-touch m-t-10">Secure</p>
                        <p class="subtitle is-size-6-touch">Choose who sees what.</p>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
