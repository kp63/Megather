
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
@hasSection('page_title')
    <title class="notranslate">@yield('page_title') - {{ config('app.name', 'Laravel') }}</title>
@else
    <title class="notranslate">{{ config('app.name', 'Laravel') }}</title>
@endif
    <link rel="dns-prefetch" href="//cdn.materialdesignicons.com">
    <link rel="prefetch" href="//cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
    <link rel="stylesheet"   href="https://cdn.materialdesignicons.com/5.3.45/css/materialdesignicons.min.css">
    <link rel="stylesheet"   href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" charset="utf-8" defer></script>
@hasSection('head_append')
    @yield('head_append')
@endif
