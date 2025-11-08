@if (isset($paginator) && $paginator->hasPages())
    <!-- PAGINATION -->
    <div class="flex-center mt-10 lg:mt-[60px]">
        <ul class="flex items-center gap-x-2.5">
            @if (!$paginator->onFirstPage())
                <a class="slider-navigation disabled" href="{{ $paginator->previousPageUrl() }}" aria-label="Pagination">
                    <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                </a>
            @endif
            @foreach ($elements as $element)
                @if (is_string($element))
                    <a class="slider-navigation disabled" aria-current="page">{{ $element }}</a>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button type="button" aria-label="Pagination link" class="slider-navigation active">{{ $page }}</button>
                        @else
                            <a class="slider-navigation" aria-label="Pagination link" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <a class="slider-navigation" href="{{ $paginator->nextPageUrl() }}" aria-label="Pagination link">
                    <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                </a>
            @else
                <button class="slider-navigation">
                    <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                </button>
            @endif
        </ul>
    </div>
@endif
