<!-- SOCIAL -->
@php
    $menuClass = $ulClass ?? null;
    $itemClass = $itemClass ?? null;
@endphp
<ul class="{{ $menuClass }}">
    <li class="translate-x-[calc(10px_*_1)] group-hover/instructor:translate-x-0 delay-[calc(100ms_*_1)] custom-transition">
        <button type="button" aria-label="Social share button" class="flex-center size-10 rounded-50 bg-primary text-white group-hover/instructor:bg-secondary group-hover/instructor:text-heading custom-transition">
            <i class="ri-share-fill"></i>
        </button>
    </li>
    @foreach($socialList as $social)
        <li class="{{ $listClass ?? null }}">
            <a href="{{ $social['url'] ?? '#' }}" class="{{ $itemClass }}" aria-label="Social media link">
                {!! $social['icon'] !!}
            </a>
        </li>
    @endforeach
</ul>