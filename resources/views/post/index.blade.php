@extends('layouts.app')

@section('content')
    <div class="article-list nosidebar">
        @foreach($items_converted as $i => $item)
            @include('post.article', ['item' => $item])
        @endforeach
    </div>
    {{ $items->links() }}
@endsection
