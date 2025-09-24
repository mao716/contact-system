@if ($paginator->hasPages())
<nav>
	{{-- Previous Page Link --}}
	@if ($paginator->onFirstPage())
	<span aria-hidden="true">&lt;</span>
	@else
	<a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lt;</a>
	@endif

	{{-- Pagination Elements --}}
	@foreach ($elements as $element)
	@if (is_string($element))
	<span>{{ $element }}</span>
	@endif

	@if (is_array($element))
	@foreach ($element as $page => $url)
	@if ($page == $paginator->currentPage())
	<span aria-current="page">{{ $page }}</span>
	@else
	<a href="{{ $url }}">{{ $page }}</a>
	@endif
	@endforeach
	@endif
	@endforeach

	{{-- Next Page Link --}}
	@if ($paginator->hasMorePages())
	<a href="{{ $paginator->nextPageUrl() }}" rel="next">&gt;</a>
	@else
	<span aria-hidden="true">&gt;</span>
	@endif
</nav>
@endif
