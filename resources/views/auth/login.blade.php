<x-app-layout :title="__('Login')" :ogp-tags="false">
  <div class="login-form">
    <h1>{{ __('Login') }}</h1>

    @if(\App\Enums\Providers::Google->isEnabled())
      <a class="btn full google login-btn" href="{{ route('oauth', ['provider' => 'google']) }}"><i class="mdi mdi-google"></i> Google ログイン</a>
    @endif
    @if(\App\Enums\Providers::Discord->isEnabled())
      <a class="btn full discord login-btn" href="{{ route('oauth', ['provider' => 'discord']) }}"><i class="mdi mdi-discord"></i> Discord ログイン</a>
    @endif

    <p style="margin-top: 16px; color: gray; font-size: 14px">* Megatherは安全のためメールアドレスを収集しません。</p>
  </div>
</x-app-layout>
