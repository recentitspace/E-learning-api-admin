@if (isset($paginator) && $paginator->hasPages())
    <div class="flex-center mt-12">
        <div class="flex sm:gap-2.5 gap-1 page-item">
            @if (!$paginator->onFirstPage())
                <a class="pagi-btn disabled" href="{{ $paginator->previousPageUrl() }}" aria-label="pagination link" >
                    <i class="ri-arrow-left-line rtl:before:content-['\ea6c'] text-inherit"></i>
                </a>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <button type="button" aria-label="pagination link" class="pagi-btn disabled" aria-current="page">{{ $element }}</button>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button type="button" aria-label="Current page" class="page-link pagi-btn active">{{ $page }}</button>
                        @else
                            <a class="page-link pagi-btn" aria-label="pagination link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <a class="pagi-btn page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="pagination link" >
                    <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
                </a>
            @else
                <button type="button" class="pagi-btn" aria-label="pagination link" >
                    <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
                </button>
            @endif

        </div>
    </div>
@endif
