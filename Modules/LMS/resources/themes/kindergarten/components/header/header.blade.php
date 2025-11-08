@php
    $headerClass = $data['header_class'] ?? 'bg-white py-4 sticky-header';
    $headerWrapperClass = $data['header_wrapper_class'] ?? 'flex items-center';
    $rightActionsWrapperClass = $data['right_actions_wrapper_class'] ?? 'ms-auto flex items-center gap-5';
    $components = $data['components'] ?? [];
    $innerHeaderTop = $components['inner-header-top'] ?? 'default';
    $search = $data['search'] ?? [];
    $header = $data['header'] ?? [];
    $theme = $header['theme'] ?? 'default';
@endphp

@if (!isset($style) && $innerHeaderTop === 'default')
    <x-dynamic-component component='{{ "default:theme::header.header-top-one" }}' :theme="$theme" :content="$header" />
@endif

<header class=" {{ $headerClass }} ">
    <div class="container">
        @if ($innerHeaderTop && $innerHeaderTop !== 'default')
            <x-dynamic-component component='{{ "default:theme::header.{$innerHeaderTop}" }}' />
        @endif
        <div class="{{ $headerWrapperClass }}">
            <x-dynamic-component component='{{ "default:theme::header.logo" }}' :theme="$theme" :data="$data" :default-logo="$data['default_logo'] ?? null" />
            <x-dynamic-component component='{{ "default:theme::header.menu-one" }}' :menus="$data['menus'] ?? get_menus()" :theme="$theme"
                :class="$data['menu_class'] ?? []" />
            <!-- ACTIONS -->
            <div class="{{ $rightActionsWrapperClass }}">
                <!-- SEARCH -->
                @if ($search['is_show'] ?? true)
                    <x-dynamic-component component='{{ "default:theme::header.search" }}' :theme="$theme"
                        :class="$data['search_class'] ?? []" />
                @endif
                <x-dynamic-component component='{{ "default:theme::header.right-side" }}' :theme="$theme" :data="$data" is-show-language="true" text-color="text-heading" />

                  <!-- MENU BUTTON -->
                @if (!isset($style))
                    <div class="flex-center lg:hidden shrink-0">
                        <button type="button" aria-label="Offcanvas menu" data-offcanvas-id="offcanvas-menu"
                            class="btn-icon b-solid btn-secondary-icon-solid !text-heading dark:text-white font-bold">
                            <i class="ri-menu-unfold-line rtl:before:content-['\ef3d']"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
