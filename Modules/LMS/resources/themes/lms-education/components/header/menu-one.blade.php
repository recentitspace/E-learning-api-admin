<!-- NAVIGATION -->
@php
    $menus = $menus ?? get_menus();
    if (empty($menus)) {
        return;
    }

    $class = $class ?? [];
@endphp

<nav class="hidden lg:flex-center">
    <ul class="flex items-center gap-x-5 gap-y-2 flex-wrap leading-none text-heading font-medium">
        @foreach ($menus as $menu)
            <li
                class="flex-center {{ isset($menu['childs']) && count($menu['childs']) > 0 ? 'relative group/has-menu' : '' }}">

                <a href="{{ $menu['url'] ?? '#' }}" aria-label="Menu link"
                    class="inline-block px-2 py-3 hover:text-primary [&.active]:text-primary custom-transition effect-nav-menu {{ $menu['is_active'] ?? '' }}">{{ $menu['name'] ?? translate('No name') }}
                </a>

                @if (isset($menu['childs']) && $menu['childs'])
                    <ul
                        class="flex flex-col bg-white px-2 py-3 shadow-md rounded-lg w-max absolute top-full left-0 z-20 invisible opacity-0 -translate-x-5 group-hover/has-menu:visible group-hover/has-menu:opacity-100 group-hover/has-menu:translate-x-0 custom-transition">
                        @foreach ($menu['childs'] as $child)
                            <li>
                                <a href="{{ $child['url'] ?? '#' }}" aria-label="Menu link"
                                    class="relative inline-block px-2 py-2.5 hover:text-primary w-full hover:bg-gradient-to-r from-primary-100 to-white before:absolute before:inset-0 before:w-0.5 before:h-full hover:before:bg-primary [&.active]:bg-gradient-to-r [&.active]:before:bg-primary {{ $child['is_active'] ?? '' }} [&.active]:text-primary before:duration-300 custom-transition">
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
