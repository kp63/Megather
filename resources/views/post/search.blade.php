@extends('layouts.app')
@section('page_title', 'メンバー募集検索')

@section('content')
    <div class="article-list">
        @foreach($items_converted as $i => $item)
            @include('components.article', ['item' => $item])
        @endforeach
    </div>
    {{ $items->appends($params)->links() }}
@endsection

@section('sidebar')
    <form class="search-container">
        <label class="input">
            <input type="text" name="tags" value="{{ $_GET['tags'] ?? '' }}" placeholder="タグ検索（スペース区切り）">
        </label>

        <ul class="sidemenu-list">
            <li class="expanded">
                <span class="sidemenu-button sidemenu-expandable-button" @click="toggleSidemenuExpand">
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
                <span class="sidemenu-button sidemenu-expandable-button" @click="toggleSidemenuExpand">
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
