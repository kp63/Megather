<x-app-layout title="メンバー募集検索">
  <x-articles :items="$items" />

  <x-slot name="sidebar">
    <form class="search-container">
      <label class="input">
        <input type="text" name="tags" value="{{ request()->input('tags') }}" placeholder="タグ検索（スペース区切り）">
      </label>

      <ul class="sidemenu-list">
        <li class="expanded">
          <span class="sidemenu-button sidemenu-expandable-button">
            ゲーム
            <i class="mdi mdi-chevron-down"></i>
          </span>
          <ul>
{{--            @foreach(config('tags.games') as $id => $name)--}}
{{--              <li>--}}
{{--                <label class="sidemenu-button">--}}
{{--                  <input class="sidebar-search-query" type="checkbox" name="games[]" value="{{ $id }}"{{ in_array($id, $games, true) ? ' checked' : '' }}>--}}{{----}}
{{--                            --}}{{--<span style="margin-left: 0.5em;">{{ $name }}</span>--}}
{{--                </label>--}}
{{--              </li>--}}
{{--            @endforeach--}}
            @foreach(App\Models\Post::getAllGames() as $id => $name)
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
            @foreach(App\Models\Post::getAllTypes() as $id => $name)
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
  </x-slot>
</x-app-layout>
