@extends('layouts.profile')

@section('title', "h")

@section('content')
    <h1 class="title is-2 white-text">Profiles | <small>Showing <span class="has-text-weight-light white-text">{{ $profile->display_name }}</span></small></h1>
@endsection
