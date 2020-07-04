@extends('layouts.app')

@section('content')
    <div class="content-box big-padding">
        <div class="profile-page-header">
            <div class="profile-page-username">
                <div class="profile-page-header-avatar">
                    <img src="{{ asset('img/userdata/avatar/default.png') }}" alt="">
                </div>
                <h1>{{ $username }}</h1>
            </div>
            <hr class="separator">
            <p class="profile-social-links">
                <a href="https://twitter.com/Twitter"><i class="mdi mdi-twitter"></i> Twitter</a>
                <a href="https://twitter.com/Twitter"><i class="mdi mdi-twitter"></i> Twitter</a>
                <a href="https://twitter.com/Twitter"><i class="mdi mdi-twitter"></i> Twitter</a>
                <a href="https://twitter.com/Twitter"><i class="mdi mdi-twitter"></i> Twitter</a>
            </p>
        </div>
        <p class="profile-text">どうも、{{ $username }}と申します。<br>虹六やってます。</p>
    </div>
@endsection
