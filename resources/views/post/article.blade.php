<div class="article" data-id="{{ $item['id'] }}">
    <div class="article-header">
        <a href="{{ route('profile_page', ['username' => $item['username']]) }}" class="header-userimage" title="{{ sprintf(__('%s\'s Profile'), $item['username']) }}">
            <img src="{{ $item['avatar_uri'] }}" alt="{{ __('Profile Image') }}">
        </a>
        <div class="header-username">
            <span class="notranslate">{{ $item['username'] }}</span>
        </div>
        <button class="header-operation-button" aria-label="{{ __('Operation Menu') }}" data-article-operation-button @click="operation_button_click" @if ($item['display_style'] !== null) data-display-style="{{ $item['display_style'] }}" @endif>
            <i class="mdi mdi-dots-vertical"></i>
        </button>
    </div>
    <div class="article-body">
        <div class="body-tags">
            @isset($item['details']['game'])
                <a href="{{ route('search', ['games' => $item['details']['game']]) }}">{{ __('Game') }}: <span class="notranslate">{{ __(config('tags.games.' . $item['details']['game'])) }}</span></a>
            @endif
            @isset($item['details']['type'])
                <a href="{{ route('search', ['types' => $item['details']['type']]) }}">{{ __('Type') }}: {{ __(config('tags.types.' . $item['details']['type'])) }}</a>
            @endif
        </div>
        <div class="body-content">
            <p>
                {!! $item['content'] !!}
            </p>
        </div>
    </div>
    <div class="article-footer">
        <span class="article-postdate">{{ $item['postdate'] }}</span>
    </div>
</div>
