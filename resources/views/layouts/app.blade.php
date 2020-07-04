<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (isset($noindex) && $noindex === true)
        <meta name="robots" content="noindex">
    @endif
    @if(($ogp_tags ?? true) === true)
        <meta name="description" content="{{ config('seo.description') }}">
        @hasSection('page_title')
            <meta property="og:title" content="@yield('page_title')">
        @endif
        <meta property="og:type" content="{{ request()->path() === '/' ? 'website' : 'article' }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:image" content="{{  asset('img/userdata/avatar/default.png') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:description" content="{{ config('seo.description') }}">
    @endif
    <title class="notranslate">{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//cdn.materialdesignicons.com">
    <link rel="stylesheet"   href="https://cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
    <link rel="stylesheet"   href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" charset="utf-8" defer></script>
    @hasSection('head_append')
        @yield('head_append')
    @endif
</head>
<body>
    <div id="app" class="wrapper">
        <div class="page-header">
            <a href="{{ url('/') }}" class="header-logo">
                <img class="notranslate" src="{{ asset('img/logo.png') }}" srcset="{{ asset('img/logo.svg') }}" alt="Megather">
            </a>
            <div class="header-actions">
                @guest
                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                @else
                    <a href="{{ route('new_post') }}">{{ __('New Post') }}</a>
                    <button class="notranslate" @click="username_button_click" data-username="{{ Auth::user()->username }}">{{ Auth::user()->username }}</button>
                    @if (Auth::user()->role === 'administrator' || Auth::user()->role === 'developer')
                        <a href="/control" title="{{ __('Control Panel') }}"><i class="mdi mdi-cog"></i></a>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            </div>
        </div>

        <div class="page-body">
            <div class="body-content">
                @yield('content')
            </div>
        </div>

        <div id="contextmenu-background" @click.right.prevent @mousedown="close_contextmenu"></div>
        <div id="contextmenu" @click.right.prevent></div>
    </div>
    <script>
        var __ = {
            deleteThisPost: '{{ __('Delete This Post') }}',
            reportThisPost: '{{ __('Report This Post') }}',
            myProfile: '{{ __('My Profile') }}',
            accountSettings: '{{ __('Account Settings') }}',
            logout: '{{ __('Logout') }}',
        }
    </script>
</body>
</html>
