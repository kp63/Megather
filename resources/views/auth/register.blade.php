@extends('layouts.app')

<?php $ogp_tags = false; ?>
@section('page_title', __('Register'))

@section('content')
    <form method="POST" class="login-form" action="{{ route('register') }}">
        <h1>{{ __('Register') }}</h1>

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
            <span>{{ __('Email') }}</span>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
        </label>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

        <label class="input">
            <span>{{ __('Password') }}</span>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </label>
        <label class="input">
            <span>{{ __('Confirm Password') }}</span>
            <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
        </label>
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror


        <div style="margin: 12px 0;">
            <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="margin-left: 4px;">{{ __('or Login') }}</a>
            @endif
        </div>
    </form>
@endsection
