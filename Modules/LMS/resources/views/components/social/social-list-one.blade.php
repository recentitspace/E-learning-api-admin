@php
    $menuClass = $ulClass ?? null;
    $itemClass = $itemClass ?? null;
@endphp
<ul class="{{ $menuClass }}">
    @if (isset($hoverButton))
        <li class="absolute top-3 right-2.5 z-10">
            <button type="button" aria-label="Social share"
                class="flex-center size-10 rounded-50 bg-primary text-white group-hover/instructor:bg-secondary group-hover/instructor:text-heading dark:text-white custom-transition">
                <i class="ri-share-fill"></i>
            </button>
        </li>
    @endif
    @foreach ($socials as $social)
        <li class="{{ $listClass ?? null }}">
            <a href="{{ $social['url'] ?? '#' }}" class="{{ $itemClass }}" aria-label="Social media link">
                {!! $social['icon'] !!} 
            </a>
        </li>
    @endforeach
</ul>
