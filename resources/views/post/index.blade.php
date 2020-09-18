@extends('layouts.app')
@section('page_title', 'メンバー募集一覧')

@section('content')
    <div class="article-list nosidebar">
        @foreach($items_converted as $i => $item)
            @include('components.article', ['item' => $item])
        @endforeach
    </div>
    {{ $items->links() }}
@endsection
