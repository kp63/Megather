@extends('layouts.app')

@section('page_title', sprintf(__('%s\'s Profile'), $username))

@section('content')
    <div class="content-box big-padding">
        <div class="profile-page-header">
            <div class="profile-page-username @if($nickname !== null) with-nickname @endif">
                <div class="profile-page-header-avatar">
                    <img data-avatar src="{{ $avatar_uri }}" alt="{{ __('Profile Image') }}">
                </div>
                <h1>{{ $username }}</h1>
                @if($nickname !== null)
                    <span class="nickname">{{ $nickname }}</span>
                @endif
            </div>
            <p class="profile-social-links">
                @foreach($links as $link)
                    @if(isset($link['href']))
                        <a class="{{ $link['className'] }}" href="{{ $link['href'] }}" target="_blank">@if(isset($link['icon']))<i class="mdi {{ $link['icon'] }}"></i>@endif{{ $link['content'] ?? '' }}</a>
                    @else
                        <span class="{{ $link['className'] }}">@if(isset($link['icon']))<i class="mdi {{ $link['icon'] }}"></i>@endif{{ $link['content'] }}</span>
                    @endif
                @endforeach
            <p class="profile-social-links">
{{--            @if(($links !== [] && (!isset($links['youtube']) || $links_youtube_name !== null)) || ($publish_discord_id === true && !is_null($discord_id)))--}}
{{--                <hr class="separator">--}}
{{--                <p class="profile-social-links">--}}
{{--                    @if($publish_discord_id === true && !is_null($discord_id))--}}
{{--                        <span class="discord">--}}
{{--                            <i class="mdi mdi-discord"></i>--}}
{{--                            {{ $discord_id }}--}}
{{--                            @if(!is_null($discord_id_updated_at))--}}
{{--                            <i class="mdi mdi-check-circle" title="確認済み ({{ $discord_id_updated_at }})"></i>--}}
{{--                            @endif--}}
{{--                        </span>--}}
{{--                    @endif--}}
{{--                    @isset($links['twitter'])--}}
{{--                        <a href="https://twitter.com/{{ $links['twitter'] }}" class="twitter" target="_blank"><i class="mdi mdi-twitter"></i>&commat;{{ $links['twitter'] }}</a>--}}
{{--                    @endif--}}
{{--                    @if(isset($links['youtube']) && $links_youtube_name !== null)--}}
{{--                        <a href="https://www.youtube.com/{{ $links['youtube'] }}/featured" class="youtube" target="_blank"><i class="mdi mdi-youtube"></i>{{ $links_youtube_name }}</a>--}}
{{--                    @endif--}}
{{--                    @isset($links['twitch'])--}}
{{--                        <a href="https://www.twitch.tv/{{ $links['twitch'] }}" class="twitch" target="_blank"><i class="mdi mdi-twitch"></i>{{ $links['twitch'] }}</a>--}}
{{--                    @endif--}}
{{--                </p>--}}
{{--            @endif--}}
        </div>
        @isset($bio)
            <p class="profile-text">{!! nl2br($bio) !!}</p>
        @endif
    </div>
@endsection
