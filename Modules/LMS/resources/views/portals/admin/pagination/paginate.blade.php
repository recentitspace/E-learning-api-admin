@if ($paginator->hasPages())
    <div class="flex-center-between flex-wrap gap-4 border-t-[0.5px] border-gray-200 dark:border-dark-border pt-4">
        <div class="leading-none text-xs font-semibold text-gray-900">
            {{ translate('Showing') }} {{ $paginator->firstItem() }} {{ translate('to') }} {{ $paginator->lastItem() }}
            {{ translate('of') }}
            {{ $paginator->total() }}
            {{ translate('entries') }}
        </div>
        <ul class="grow flex items-center justify-end gap-2 *:text-xs *:text-gray-900">
            @if ($paginator->onFirstPage())
                <li class="hl-pagination--item disabled"> <a class="hl-pagination--button" href="#"
                        tabindex="-1"></a> </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                        class="size-8 border-[0.5px] hover:border-transparent border-gray-900/50 rounded-sm flex-center hover:bg-primary-500 hover:text-white text-gray-900 ac-transition">
                        <i class="ri-arrow-left-line text-inherit"></i>
                    </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled" aria-current="page">{{ $element }}</li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <a href="#"
                                    class="size-8 border-[0.5px] hover:border-transparent [&.active]:border-transparent border-gray-900/50 rounded-sm flex-center hover:bg-primary-500 [&.active]:bg-primary-500 hover:text-white [&.active]:text-white text-gray-900 ac-transition active">
                                    {{ $page > 9 ? $page : "0$page" }}</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                    class="size-8 border-[0.5px] hover:border-transparent [&.active]:border-transparent border-gray-900/50 rounded-sm flex-center hover:bg-primary-500 [&.active]:bg-primary-500 hover:text-white [&.active]:text-white text-gray-900 ac-transition">
                                    {{ $page > 9 ? $page : "0$page" }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="size-8 border-[0.5px] hover:border-transparent border-gray-900/50 rounded-sm flex-center hover:bg-primary-500 hover:text-white text-gray-900 ac-transition disabled">
                        <i class="ri-arrow-right-line text-inherit"></i>
                    </a>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                        class="size-8 border-[0.5px] hover:border-transparent border-gray-900/50 rounded-sm flex-center hover:bg-primary-500 hover:text-white text-gray-900 ac-transition">
                        <i class="ri-arrow-right-line text-inherit"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
