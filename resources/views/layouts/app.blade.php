<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @if ($noindex)
    <meta name="robots" content="noindex">
  @endif
  @if(!$noindex && $ogp_tags)
    <meta name="description" content="{{ config('seo.description') }}">
    <meta property="og:title" content="{{ $title ?? $fullTitle }}">
    <meta property="og:type" content="{{ request()->path() === '/' ? 'website' : 'article' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{  asset('img/icon_x128.png') }}">
    <meta property="og:site_name" content="{{ config('app.name', 'Megather') }}">
    <meta property="og:description" content="{{ config('seo.description') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@Megather">
    <meta name="twitter:domain" content="megather.netom.jp">
    <meta name="twitter:image" content="{{  asset('img/og.png') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @endif
  @if ($fullTitle)
    <title>{{ $fullTitle }}</title>
  @elseif ($title)
    <title>{{ $title }} - {{ config('app.name') }}</title>
  @else
    <title>{{ config('app.name') }}</title>
  @endif
  <link rel="dns-prefetch" href="//cdn.materialdesignicons.com">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdn.materialdesignicons.com/6.6.96/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
  <link rel="stylesheet" href="{{ mix('assets/css/app.css') }}">
  <script src="{{ mix('assets/js/app.js') }}" charset="utf-8" defer></script>
</head>
<body>
<div id="app" class="wrapper">
  <div class="page-header">
    <a href="{{ url('/') }}" class="header-logo">
      <img class="notranslate" src="{{ asset('img/logo.png') }}" srcset="{{ asset('assets/img/logo.svg') }}" alt="Megather">
    </a>
    <div class="header-actions">
      <a href="{{ route('search') }}" title="{{ __('Search') }}"><i class="mdi mdi-magnify"></i></a>
      @guest
        <a href="{{ route('login') }}" id="header-login-button">{{ __('Login') }}</a>
      @else
        <a href="{{ route('new_post') }}">{{ __('New Post') }}</a>
        <div class="avatar">
          <img src="{{ Auth::user()->getAvatar() }}" alt="{{ __('Avatar') }}">
          <button class="notranslate" data-avatar id="self-avatar" data-username="{{ Auth::user()->name }}" title="{{ Auth::user()->name }}"></button>
        </div>
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'developer')
          <a href="{{ '/management-panel' }}" title="{{ __('Control Panel') }}"><i class="mdi mdi-cog"></i></a>
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
  <div class="page-body {{ $sidebar?->isNotEmpty() ? 'with-sidebar' : 'without-sidebar' }}">
    <div class="body-content">
      {{ $slot }}
    </div>
    @if ($sidebar?->isNotEmpty())
      <div class="sidebar">
        {{ $sidebar }}
      </div>
    @endif
  </div>

  <footer>
    <p class="text-14px">当サイトを使用することによって、あなたは<a href="{{ url('/terms') }}">利用規約</a>に同意したものとみなします。</p>
    <div class="footer-logo"><img src="{{ asset('img/logo.png') }}" srcset="{{ asset('assets/img/logo.svg') }}" alt="Megather"></div>
  </footer>

  <div id="contextmenu-background"></div>
  <div id="contextmenu"></div>
</div>
<script>
  window.user = {{ Js::from(auth()->user()?->only(['id', 'name', 'name_updated_at', 'status', 'role'])) }};
{{--  window.user.profile = {{ Js::from(auth()->user()->profile->only(['nickname', 'avatar_provider', 'avatar_url', 'bio'])) }};--}}
  window.app = {{ Js::from(config('megather')) }};
  window.__ = {{ Js::from(Util::getJsLang()) }};
</script>
</body>
</html>
