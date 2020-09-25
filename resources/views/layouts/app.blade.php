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
        <meta property="og:image" content="{{  asset('img/icon_x128.png') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Laravel') }}">
        <meta property="og:description" content="{{ config('seo.description') }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@Megather">
        <meta name="twitter:domain" content="megather.netom.jp">
        <meta name="twitter:image" content="{{  asset('img/og.png') }}">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @endif
    @hasSection('page_title')
        <title class="notranslate">@yield('page_title') - {{ config('app.name', 'Megather') }}</title>
    @else
        <title class="notranslate">{{ config('app.name', 'Megather') }}</title>
    @endif
{{--    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">--}}
    <link rel="prefetch"     href="//cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css">
    <link rel="stylesheet"   href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css">
    <link rel="stylesheet"   href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" charset="utf-8" defer></script>
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
                    <a href="{{ route('login') }}" id="header-login-button">{{ __('Login') }}</a>
                @else
                    <a href="{{ route('new_post') }}">{{ __('New Post') }}</a>
                    <div class="avatar">
                        <img src="{{ App\Profile::getAvatar() }}" alt="{{ __('Avatar') }}">
                        <button class="notranslate" data-avatar id="self-avatar" data-username="{{ App\Profile::getUsername() }}" title="{{ App\Profile::getUsername() }}"></button>
                    </div>
                    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'developer')
                        <a href="/management-panel" title="{{ __('Control Panel') }}"><i class="mdi mdi-cog"></i></a>
                    @endif
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
        <div style="padding: 14px 10px; background-color: #606f94; color: whitesmoke; text-align: center;">
            Megather Beta Version - Last Updated at: {{ `git show -s --format=%cr` }}
        </div>
        {{--        @include('layouts.ie-alert')--}}
        <div class="page-body @hasSection('sidebar') with-sidebar @else without-sidebar @endif">
            <div class="body-content">
                @yield('content')
            </div>
            @hasSection('sidebar')
                <div class="sidebar">
                    @yield('sidebar')
                </div>
            @endif
        </div>

        <footer>
            <p class="text-14px">当サイトを使用することによって、このサイトの<a href="{{ url('/terms') }}">利用規約</a>に同意したものとみなします。</p>
            <div class="footer-logo"><img src="{{ asset('img/logo.png') }}" srcset="{{ asset('img/logo.svg') }}" alt="Megather"></div>
        </footer>

        <div id="contextmenu-background"></div>
        <div id="contextmenu"></div>
    </div>
    <script>
        <?php
            $langRaw = \Illuminate\Support\Facades\Lang::get('javascript');
            $lang = [];
            foreach ($langRaw as $key => $value) {
                $lang[str_replace(' ', '', lcfirst(ucwords($key)))] = $value;
            }
        ?>
        window.__ = @json($lang)
    </script>
</body>
</html>
