<?php /** @var $item App\Models\Post */ ?>
<div class="article col-12 col-md-6 col-lg-4 col-xl-3 p-1" data-id="{{ $item['id'] }}">
  <div class="article-container">
    <div class="article-header">
      @if($item->user->name !== 'Unknown User')
        <a href="{{ route('profile_page', $item->user->name) }}" class="header-userimage" title="{{ sprintf(__('%s\'s Profile'), $item->user->name) }}">
          <img data-avatar src="{{ $item->user->getAvatar() }}" alt="{{ __('Profile Image') }}">
        </a>
      @else
        <span class="header-userimage">
                    <img data-avatar src="{{ asset('img/avatar/default_x64.png') }}" alt="{{ __('Profile Image') }}">
                </span>
      @endif
      <div class="header-username">
        <span class="notranslate">{{ $item->user->name }}</span>
      </div>
      <button class="header-operation-button" aria-label="{{ __('Operation Menu') }}" data-article-operation-button @if ($item->user_id === Auth::id()) data-display-style="postowner" @endif>
        <i class="mdi mdi-dots-vertical"></i>
      </button>
    </div>
    <div class="article-body">
      <div class="body-tags">
        @if ($item->game)
          <a href="{{ route('search', ['games' => $item->game]) }}">{{ __('Game') }}: <span class="notranslate">{{ \App\Models\Post::getGameTitle($item->game) ?? '不明' }}</span></a>
        @endif
        @if ($item->type)
          <a href="{{ route('search', ['types' => $item->type]) }}">{{ __('Type') }}: {{ \App\Models\Post::getTypeName($item->type) ?? '不明' }}</a>
        @endif
      </div>
      <div class="body-content">
        <p>
          {{ Util::link($item->content) }}
        </p>
      </div>
    </div>
    <div class="article-footer">
      <span class="article-postdate">{{ $item->created_at->diffForHumans() }}</span>
    </div>
  </div>
</div>
