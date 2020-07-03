@extends('layouts.app')

@section('content')
    <div class="article-list">
        @foreach($items_converted as $i => $item)
            <div class="article">
                <div class="article-header">
                    <a href="{{ url('/u/' . $item['username']) }}" class="header-userimage" title="{{ sprintf(__('%s\'s Profile'), $item['username']) }}">
                        <img src="{{ asset('img/userdata/avatar/default.png') }}" alt="{{ __('Profile Image') }}">
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
                            <a>{{ __('Game') }}: <span class="notranslate">{{ __(config('tags.games.' . $item['details']['game'])) }}</span></a>
                        @endif
                        @isset($item['details']['type'])
                            <a>{{ __('Type') }}: {{ __(config('tags.types.' . $item['details']['type'])) }}</a>
                        @endif
                    </div>
                    <div class="body-content">
                        <p>
                            {!! str_replace("\n", '<br>' . "\n" . '                                    ', e($item['content'])) !!}
                        </p>
                    </div>
                </div>
                <div class="article-footer">
                    <span class="article-postdate">{{ $item['postdate'] }}</span>
                </div>
            </div>
        @endforeach
    </div>
    {{ $items->links() }}
@endsection
