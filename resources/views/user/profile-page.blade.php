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
            @if($links !== [])
            <hr class="separator">
            <p class="profile-social-links">
                @foreach($links as $link)
                    @if(isset($link['href']))
                        <a class="{{ $link['className'] }}" href="{{ $link['href'] }}" target="_blank">@if(isset($link['icon']))<i class="mdi {{ $link['icon'] }}"></i>@endif{{ $link['content'] ?? '' }}</a>
                    @else
                        <span class="{{ $link['className'] }}">@if(isset($link['icon']))<i class="mdi {{ $link['icon'] }}"></i>@endif{{ $link['content'] }}</span>
                    @endif
                @endforeach
            </p>
            @endif
        </div>
        @isset($bio)
            <p class="profile-text">{!! nl2br($bio) !!}</p>
        @endif
    </div>
@endsection
