@extends('layouts.app')

@section('page_title', sprintf(__('%s\'s Profile'), $username))

@section('content')
    <div class="content-box big-padding">
        <div class="profile-page-header">
            <div class="profile-page-username @if($nickname !== null) with-nickname @endif">
                <div class="profile-page-header-avatar">
                    <img src="{{ $avatar_uri }}" alt="">
                </div>
                <h1>{{ $username }}</h1>
                @if($nickname !== null)
                    <span class="nickname">{{ $nickname }}</span>
                @endif
            </div>
            @if($links !== [] || $publish_discord_id === true)
                <hr class="separator">
                <p class="profile-social-links">
                    @if($publish_discord_id === true)
                        <span class="discord"><i class="mdi mdi-discord"></i>{{ $username }}#0000<i class="mdi mdi-check-circle" title="確認済み"></i></span>
                    @endif
                    @isset($links['twitter'])
                        <a href="https://twitter.com/{{ $links['twitter'] }}" class="twitter" target="_blank"><i class="mdi mdi-twitter"></i>&commat;{{ $links['twitter'] }}</a>
                    @endif
                    @isset($links['youtube'])
                        <a href="https://www.youtube.com/{{ $links['youtube'] }}/" class="youtube" target="_blank"><i class="mdi mdi-youtube"></i>{{ $links_youtube_name }}</a>
                    @endif
                    @isset($links['twitch'])
                        <a href="https://www.twitch.tv/{{ $links['twitch'] }}" class="twitch" target="_blank"><i class="mdi mdi-twitch"></i>{{ $links['twitch'] }}</a>
                    @endif
                </p>
            @endif
        </div>
        @isset($bio)
            <p class="profile-text">{{ nl2br($bio) }}</p>
        @endif
    </div>
@endsection
