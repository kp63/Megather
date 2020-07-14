<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.head')
</head>
<body>
    <div id="app" class="wrapper">
        <div class="page-header">
            <a href="{{ url('/') }}" class="header-logo">
                <img class="notranslate" src="{{ asset('img/logo.png') }}" srcset="{{ asset('img/logo.svg') }}" alt="Megather">
            </a>
            <div class="header-actions">
                <a href="/search" title="{{ __('Search') }}"><i class="mdi mdi-magnify"></i></a>
                @guest
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a class="sp-hide" href="{{ route('oauth', ['provider' => 'google']) }}" title="{{ __('Sign in with Google') }}"><i class="mdi mdi-google"></i></a>
                    <a class="sp-hide" href="{{ route('oauth', ['provider' => 'discord']) }}" title="{{ __('Sign in with Discord') }}"><i class="mdi mdi-discord"></i></a>
{{--                    <a href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                @else
                    <a href="{{ route('new_post') }}">{{ __('New Post') }}</a>
{{--                    <button class="notranslate" @click="usernameButtonClick" data-username="{{ Auth::user()->username }}">{{ Auth::user()->username }}</button>--}}
                    <div class="avatar">
                        <img src="{{ DB::table('profiles')->find(Auth::id())->{'avatar_url'} ?? asset('img/userdata/avatar/default.png') }}" alt="{{ __('Avatar') }}">
                        <button class="notranslate" @click="usernameButtonClick" data-username="{{ Auth::user()->username }}" title="{{ Auth::user()->username }}"></button>
                    </div>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'developer')
                        <a href="/control" title="{{ __('Control Panel') }}"><i class="mdi mdi-cog"></i></a>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
        <div style="padding: 14px 10px; background-color: #606f94; color: whitesmoke; text-align: center;">
            Megather Alpha Version - Last Updated at: {{ `git show -s --format=%cr` }}
        </div>
        <div class="page-body">
            <div class="body-content">
                @yield('content')
            </div>
            @hasSection('sidebar')
            <div class="sidebar">
                @yield('sidebar')
            </div>
            @endif
        </div>

        <div id="contextmenu-background" @click.right.prevent @mousedown="closeContextMenu"></div>
        <div id="contextmenu" @click.right.prevent></div>
    </div>
    <script>
        var __ = {
            deleteThisPost: '{{ __('Delete This Post') }}',
            reportThisPost: '{{ __('Report This Post') }}',
            myProfile: '{{ __('My Profile') }}',
            accountSettings: '{{ __('Account Settings') }}',
            displaySettings: '{{ __('Display Settings') }}',
            logout: '{{ __('Logout') }}',
        }
    </script>
</body>
</html>
