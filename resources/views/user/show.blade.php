<?php /** @var $links Illuminate\Support\Collection */ ?>
<x-app-layout :title="sprintf(__('%s\'s Profile'), $user->name)">
  <div class="content-box big-padding">
    <div class="profile-page-header">
      <div class="profile-page-username @if($user->profile->nickname !== null) with-nickname @endif">
        <div class="profile-page-header-avatar">
          <img data-avatar src="{{ $user->getAvatar() }}" alt="{{ __('Profile Image') }}">
        </div>
        <h1>{{ $user->name }}</h1>
        @if($user->profile->nickname !== null)
          <span class="nickname">{{ $user->profile->nickname }}</span>
        @endif
      </div>
      @if ($links->isNotEmpty())
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
      <p class="profile-text">{{ Util::nl2br($bio) }}</p>
    @endif
  </div>
</x-app-layout>
