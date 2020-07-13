@extends('layouts.app')

@section('content')
    <div class="article-list">
        @foreach($items_converted as $i => $item)
            @include('post.article', ['item' => $item])
        @endforeach
    </div>
    {{ $items->appends($params)->links() }}
@endsection

@section('sidebar')
    <form class="search-container">
        <ul class="sidemenu-list">
            <li class="expanded">
                <span class="sidemenu-button sidemenu-expandable-button">
                    ゲーム
                    <i class="mdi mdi-chevron-down"></i>
                </span>
                <ul>
                    @foreach(config('tags.games') as $id => $name)
                    <li>
                        <label class="sidemenu-button">
                            <input class="sidebar-search-query" type="checkbox" name="games[]" value="{{ $id }}"{{ in_array($id, $games, true) ? ' checked' : '' }}>{{--
                            --}}<span style="margin-left: 0.5em;">{{ $name }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </li>
            <li class="expanded">
                <span class="sidemenu-button sidemenu-expandable-button">
                    タイプ
                    <i class="mdi mdi-chevron-down"></i>
                </span>
                <ul>
                    @foreach(config('tags.types') as $id => $name)
                    <li>
                        <label class="sidemenu-button">
                            <input class="sidebar-search-query" type="checkbox" name="types[]" value="{{ $id }}"{{ in_array($id, $types, true) ? ' checked' : '' }}>{{--
                            --}}<span style="margin-left: 0.5em;">{{ $name }}</span>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <div class="btn-container text-center">
            <button type="submit" class="btn btn-primary">検索</button>
        </div>
    </form>
@endsection
