@extends('layouts.app')

<?php $ogp_tags = false; ?>
@section('page_title', __('Login'))

@section('content')
    <form method="POST" class="login-form" action="{{ route('login') }}">
        <h1>{{ __('Login') }}</h1>

        @csrf

        <label class="input">
            <span>{{ __('Username') }}</span>
            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        </label>
        @error('username')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label class="input">
            <span>{{ __('Password') }}</span>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </label>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label style="display: block; margin: 12px 0;">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>{{ __('Remember Me') }}</span>
        </label>

        <div style="margin: 12px 0;">
            <button type="submit" class="btn btn-primary">{{ __('Login') }}</button>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="margin-left: 4px;">{{ __('Forgot Your Password?') }}</a>
            @endif
        </div>
    </form>
@endsection
