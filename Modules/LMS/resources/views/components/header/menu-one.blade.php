@php
    if (empty($menus)) {
        return;
    }
    $class = $class ?? [];
@endphp

<nav class="hidden lg:flex-center ms-20">
    <ul class="flex items-center gap-5 leading-none text-heading font-medium {{ $class['wrapper'] ?? '' }}">
        @foreach ($menus as $menu)
            <li class="flex-center {{ isset($menu['childs']) && count($menu['childs']) > 0 ? 'relative group/has-menu' : '' }}">
                <a href="{{ $menu['url'] ?? '#' }}" aria-label="Nav menu link"
                    class="inline-block px-2 py-3 hover:text-primary [&.active]:text-primary custom-transition effect-nav-menu {{ $menu['is_active'] ?? '' }}">{{ $menu['name'] ?? translate('No name') }}
                </a>
                @if (isset($menu['childs']) && $menu['childs'])
                    <ul class="flex flex-col px-2 py-3 shadow-md rounded-lg w-max absolute top-full left-0 rtl:right-0 z-20 invisible opacity-0 -translate-x-5 group-hover/has-menu:visible group-hover/has-menu:opacity-100 group-hover/has-menu:translate-x-0 custom-transition {{ $class['dropdown_wrapper'] ?? 'bg-white' }}">
                        @foreach ($menu['childs'] as $child)
                            <li>
                                <a href="{{ $child['url'] ?? '#' }}" aria-label="Nav menu link" class="relative inline-block px-2 py-2.5 hover:text-primary w-full before:absolute before:inset-0 before:w-0.5 before:h-0 before:bg-primary hover:before:h-full {{ $class['dropdown_link'] ?? '' }} {{ $child['is_active'] ?? '' }} [&.active]:text-primary before:duration-300 duration-300">
                                    {{ $child['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
