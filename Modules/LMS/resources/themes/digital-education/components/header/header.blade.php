@php
    $headerClass = $data['header_class'] ?? 'bg-white py-4 sticky-header';
    $headerWrapperClass = $data['header_wrapper_class'] ?? 'flex items-center';
    $rightActionsWrapperClass = $data['right_actions_wrapper_class'] ?? 'ms-auto flex items-center gap-5';
    $components = $data['components'] ?? [];
    $innerHeaderTop = $components['inner-header-top'] ?? 'default';
    $search = $data['search'] ?? [];
    $header = $data['header'] ?? [];
    $theme = 'default';
@endphp

<header class=" {{ $headerClass }} ">
    <div class="container">
        @if(  $innerHeaderTop && $innerHeaderTop !== 'default' )
        <x-dynamic-component component='{{ "theme::header.{$innerHeaderTop}" }}' />
        @endif
        <div class="{{ $headerWrapperClass }}">
            <x-dynamic-component component='{{ "{$theme}:theme::header.logo" }}' :theme="$theme" :default-logo="$data['default_logo'] ?? null" />
            <x-dynamic-component component='{{ "{$theme}:theme::header.menu-one" }}' :menus="$data['menus'] ?? []" :theme="$theme" :class="$data['menu_class'] ?? []" />
            <!-- ACTIONS -->
            <div class="{{ $rightActionsWrapperClass }}">
                <!-- SEARCH -->
                @if( $search['is_show'] ?? true )
                    <x-dynamic-component component='{{ "{$theme}:theme::header.search" }}' :theme="$theme" :class="$data['search_class'] ?? []" />
                @endif
                <x-dynamic-component component='{{ "{$theme}:theme::header.right-side" }}' :theme="$theme" :data="$data" :data="$data" />
                <!-- MENU BUTTON -->
                @if (!isset($style))
                    <div class="flex-center lg:hidden shrink-0">
                        <button 
                            type="button"
                            data-offcanvas-id="offcanvas-menu"
                            aria-label="Mobile menu button"
                            class="btn-icon b-solid btn-primary-icon-solid !text-heading dark:text-white font-bold">
                            <i class="ri-menu-unfold-line rtl:before:content-['\ef3d']"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>