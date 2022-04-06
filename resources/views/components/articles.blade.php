<div class="article-list row m-1">
  @foreach($items as $i => $item)
    @include('components.article', ['item' => $item])
  @endforeach
</div>
@isset ($params)
  {{ $items->appends($params)->links() }}
@else
  {{ $items->links() }}
@endisset
