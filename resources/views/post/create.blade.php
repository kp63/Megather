@extends('layouts.app')
@section('page_title', __('Create New Post'))

@section('content')
    <div class="content-box">
        <form method="POST" class="new-post-form" action="{{ route('new_post') }}" name="new-post-form">
            @csrf

            <h1>{{ __('Create New Post') }}</h1>

            <label class="input select">
                <span>{{ __('Game') }}</span>
                <select name="game" required @error ('game') class="is-invalid" @enderror>
                    <option value="_unselected" disabled selected>（募集ゲーム）</option>
                    @foreach (config('tags.games') as $game_id => $game_name)
                        <option class="notranslate" value="{{ $game_id }}" @if(old('game') === $game_id) selected @endif>{{ __($game_name) }}</option>
                    @endforeach
                </select>
            </label>
            @error('game')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label class="input select">
                <span>{{ __('Type') }}</span>
                <select name="type" required @error ('type') class="is-invalid" @enderror>
                    <option value="_unselected" disabled selected>（募集タイプ）</option>
                    @foreach (config('tags.types') as $type_id => $type_name)
                        <option value="{{ $type_id }}" @if(old('type') === $type_id) selected @endif>{{ __($type_name) }}</option>
                    @endforeach
                </select>
            </label>
            @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label class="input">
                <span>{{ __('Content') }}</span>
                <textarea type="text" class="form-control @error('content')is-invalid @enderror" name="content" required minlength="5" style="display: block;">{{ old('content') }}</textarea>
            </label>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <h3 style="margin-top: 20px;">プレビュー</h3>
            <div class="article-list">
                <div class="article" data-post-form-content-preview style="display: none;">
                    <div class="article-header">
                        <a class="header-userimage" href="{{ route('profile_page', ['username' => App\User::getUsernameFromId(Auth::id())]) }}" target="_blank" title="{{ sprintf(__('%s\'s Profile'), App\User::getUsernameFromId(Auth::id())) }}">
                            <img src="{{ App\User::getAvatarFromId(Auth::id()) }}" alt="Profile Image">
                        </a>
                        <div class="header-username">
                            <span class="notranslate">{{ App\User::getUsernameFromId(Auth::id()) }}</span>
                        </div>
                        <button class="header-operation-button" disabled>
                            <i class="mdi mdi-dots-vertical"></i>
                        </button>
                    </div>
                    <div class="article-body">
                        <div class="body-tags">
                            <a id="content-prev-game" href="http://localhost:8000/search?games=siege" target="_blank"></a>
                            <a id="content-prev-type" href="http://localhost:8000/search?types=imb" target="_blank"></a>
                        </div>
                        <div class="body-content">
                            <p id="content-prev-content"></p>
                        </div>
                    </div>
                    <div class="article-footer">
                        <span class="article-postdate">今</span>
                    </div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">{{ __('Post') }}</button>
        </form>
    </div>
@endsection
