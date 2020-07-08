@if ($paginator->hasPages())
<div class="pagination">
@if ($paginator->onFirstPage())
                    <span class="super-arrow disabled" aria-label="@lang('pagination.first')" aria-disabled="true"><i class="mdi mdi-arrow-collapse-left"></i></span>
                    <span class="arrow disabled" aria-label="@lang('pagination.previous')" aria-disabled="true"><i class="mdi mdi-arrow-left"></i></span>
@else
                    <a class="super-arrow" href="{{ $paginator->url(1) }}" aria-label="@lang('pagination.first')"><i class="mdi mdi-arrow-collapse-left"></i></a>
                    <a class="arrow" href="{{ $paginator->previousPageUrl() }}" aria-label="@lang('pagination.previous')" rel="prev"><i class="mdi mdi-arrow-left"></i></a>
@endif
@foreach ($elements as $element)
@if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
@endif
@if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
                    <a href="#" class="selected" aria-current="page">{{ $page }}</a>
@else
                    <a href="{{ $url }}">{{ $page }}</a>
@endif
@endforeach
@endif
@endforeach
@if ($paginator->hasMorePages())
                    <a class="arrow" href="{{ $paginator->nextPageUrl() }}" aria-label="@lang('pagination.next')" rel="next"><i class="mdi mdi-arrow-right"></i></a>
                    <a class="super-arrow" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="@lang('pagination.last')"><i class="mdi mdi-arrow-collapse-right"></i></a>
@else
                    <span class="arrow disabled" aria-label="@lang('pagination.next')" aria-disabled="true"><i class="mdi mdi-arrow-right"></i></span>
                    <span class="super-arrow disabled" aria-label="@lang('pagination.last')" aria-disabled="true"><i class="mdi mdi-arrow-collapse-right"></i></span>
@endif
                </div>
@endif
