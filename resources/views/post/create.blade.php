@extends('layouts.app')

@section('content')
    <div class="content-box">
        <form method="POST" class="new-post-form" action="{{ route('new_post') }}">
            @csrf

            <h1>{{ __('Create New Post') }}</h1>

            <label class="input">
                <span>{{ __('Game') }}</span>
                <select name="game" required>
                    <option value="_unselected" disabled selected>（募集ゲーム）</option>
                    @foreach (config('tags.games') as $game_id => $game_name)
                        <option class="notranslate" value="{{ $game_id }}" @if(old('game') === $game_id) selected @endif>{{ __($game_name) }}</option>
                    @endforeach
                </select>
            </label>
            @error('game')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <label class="input">
                <span>{{ __('Type') }}</span>
                <select name="type" required>
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
                <textarea type="text" class="form-control @error('content')is-invalid @enderror" name="content" required style="display: block;">{{ old('content') }}</textarea>
            </label>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <button class="btn" type="submit">{{ __('Post') }}</button>
        </form>
    </div>
@endsection
