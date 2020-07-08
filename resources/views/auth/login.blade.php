@extends('layouts.app')

<?php $ogp_tags = false; ?>
@section('page_title', __('Login'))

@section('content')
    <div class="login-form">
        <h1>{{ __('Login') }}</h1>

        <a class="btn full google login-btn" href="{{ route('oauth', ['provider' => 'google']) }}"><i class="mdi mdi-google"></i> Google ログイン</a>
        <a class="btn full discord login-btn" href="{{ route('oauth', ['provider' => 'discord']) }}"><i class="mdi mdi-discord"></i> Discord ログイン</a>

    </div>
@endsection
