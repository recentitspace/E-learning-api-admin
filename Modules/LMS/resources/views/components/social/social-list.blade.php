@php
    $class =
        'flex divide-x divide-gray-800 divide-opacity-30 text-gray-800 text-lg *:px-4 first:*:pl-0 last:*:pr-0 leading-none mt-8';
    $showClass = $showClass ?? null;
    $className = $showClass ? $class : 'social-wrap';
@endphp

<ul class="{{ $className }}">
    @foreach ($socials as $social)
        <li>
            <a href="{{ $social['url'] ?? '#' }}"
                aria-label="Social media link"
                class="{{ $showClass ? ' hover:text-primary duration-200' : 'social-item' }}">
                {!! $social->icon !!} 
            </a>
        </li>
    @endforeach
</ul>
