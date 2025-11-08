<div id="app-drawer"
    class="app-menu flex flex-col bg-white dark:bg-dark-card w-app-menu fixed top-0 left-0 rtl:left-auto rtl:right-0 bottom-0 -translate-x-full rtl:translate-x-full group-data-[sidebar-size=sm]:min-h-screen group-data-[sidebar-size=sm]:h-max border-r-2 rtl:border-r-0 rtl:border-l-2 border-primary-400 xl:border-none xl:!translate-x-0 rounded-r-15 rtl:rounded-r-none rtl:rounded-l-15 xl:!rounded-15 xl:group-data-[sidebar-size=lg]:w-app-menu xl:group-data-[sidebar-size=sm]:w-app-menu-sm xl:group-data-[sidebar-size=sm]:absolute xl:group-data-[sidebar-size=lg]:fixed xl:top-4 xl:left-4 rtl:xl:left-auto rtl:xl:right-4 xl:group-data-[sidebar-size=lg]:bottom-4 xl:group-data-[theme-width=box]:left-auto rtl:xl:group-data-[theme-width=box]:right-auto dk-theme-card-square z-backdrop duration-300"
    tabindex="-1">
    <x-portal::admin.logo route="{{ route('admin.dashboard') }}" />
    <div id="app-menu-scrollbar" data-scrollbar
        class="px-2.5 group-data-[sidebar-size=sm]:px-0 group-data-[sidebar-size=sm]:!overflow-visible !overflow-x-hidden smooth-scrollbar">
        <div class="group-data-[sidebar-size=lg]:max-h-full">
            <ul id="navbar-nav"
                class="text-[14px] !leading-none space-y-1 group-data-[sidebar-size=sm]:space-y-2.5 group-data-[sidebar-size=sm]:flex group-data-[sidebar-size=sm]:flex-col group-data-[sidebar-size=sm]:items-start group-data-[sidebar-size=sm]:mx-2 group-data-[sidebar-size=sm]:overflow-visible">
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('admin.dashboard') }}"
                        class="{{ is_active_menu('admin.dashboard') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 15 15">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M2.8 1h-.05c-.229 0-.426 0-.6.041A1.5 1.5 0 0 0 1.04 2.15c-.04.174-.04.37-.04.6v2.5c0 .229 0 .426.041.6A1.5 1.5 0 0 0 2.15 6.96c.174.04.37.04.6.04h2.5c.229 0 .426 0 .6-.041A1.5 1.5 0 0 0 6.96 5.85c.04-.174.04-.37.04-.6v-2.5c0-.229 0-.426-.041-.6A1.5 1.5 0 0 0 5.85 1.04C5.676 1 5.48 1 5.25 1H5.2zm-.417 1.014c.043-.01.11-.014.417-.014h2.4c.308 0 .374.003.417.014a.5.5 0 0 1 .37.37c.01.042.013.108.013.416v2.4c0 .308-.003.374-.014.417a.5.5 0 0 1-.37.37C5.575 5.996 5.509 6 5.2 6H2.8c-.308 0-.374-.003-.417-.014a.5.5 0 0 1-.37-.37C2.004 5.575 2 5.509 2 5.2V2.8c0-.308.003-.374.014-.417a.5.5 0 0 1 .37-.37M9.8 1h-.05c-.229 0-.426 0-.6.041A1.5 1.5 0 0 0 8.04 2.15c-.04.174-.04.37-.04.6v2.5c0 .229 0 .426.041.6A1.5 1.5 0 0 0 9.15 6.96c.174.04.37.04.6.04h2.5c.229 0 .426 0 .6-.041a1.5 1.5 0 0 0 1.11-1.109c.04-.174.04-.37.04-.6v-2.5c0-.229 0-.426-.041-.6a1.5 1.5 0 0 0-1.109-1.11c-.174-.04-.37-.04-.6-.04h-.05zm-.417 1.014c.043-.01.11-.014.417-.014h2.4c.308 0 .374.003.417.014a.5.5 0 0 1 .37.37c.01.042.013.108.013.416v2.4c0 .308-.004.374-.014.417a.5.5 0 0 1-.37.37c-.042.01-.108.013-.416.013H9.8c-.308 0-.374-.003-.417-.014a.5.5 0 0 1-.37-.37C9.004 5.575 9 5.509 9 5.2V2.8c0-.308.003-.374.014-.417a.5.5 0 0 1 .37-.37M2.75 8h2.5c.229 0 .426 0 .6.041A1.5 1.5 0 0 1 6.96 9.15c.04.174.04.37.04.6v2.5c0 .229 0 .426-.041.6a1.5 1.5 0 0 1-1.109 1.11c-.174.04-.37.04-.6.04h-2.5c-.229 0-.426 0-.6-.041a1.5 1.5 0 0 1-1.11-1.109c-.04-.174-.04-.37-.04-.6v-2.5c0-.229 0-.426.041-.6A1.5 1.5 0 0 1 2.15 8.04c.174-.04.37-.04.6-.04m.05 1c-.308 0-.374.003-.417.014a.5.5 0 0 0-.37.37C2.004 9.425 2 9.491 2 9.8v2.4c0 .308.003.374.014.417a.5.5 0 0 0 .37.37c.042.01.108.013.416.013h2.4c.308 0 .374-.004.417-.014a.5.5 0 0 0 .37-.37c.01-.042.013-.108.013-.416V9.8c0-.308-.003-.374-.014-.417a.5.5 0 0 0-.37-.37C5.575 9.004 5.509 9 5.2 9zm7-1h-.05c-.229 0-.426 0-.6.041A1.5 1.5 0 0 0 8.04 9.15c-.04.174-.04.37-.04.6v2.5c0 .229 0 .426.041.6a1.5 1.5 0 0 0 1.109 1.11c.174.041.371.041.6.041h2.5c.229 0 .426 0 .6-.041a1.5 1.5 0 0 0 1.109-1.109c.041-.174.041-.371.041-.6V9.75c0-.229 0-.426-.041-.6a1.5 1.5 0 0 0-1.109-1.11c-.174-.04-.37-.04-.6-.04h-.05zm-.417 1.014c.043-.01.11-.014.417-.014h2.4c.308 0 .374.003.417.014a.5.5 0 0 1 .37.37c.01.042.013.108.013.416v2.4c0 .308-.004.374-.014.417a.5.5 0 0 1-.37.37c-.042.01-.108.013-.416.013H9.8c-.308 0-.374-.004-.417-.014a.5.5 0 0 1-.37-.37C9.004 12.575 9 12.509 9 12.2V9.8c0-.308.003-.374.014-.417a.5.5 0 0 1 .37-.37"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                        <span
                            class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                            {{ translate('Dashboard') }}
                        </span>
                    </a>
                </li>
                @if('menu.module-manager')
                    <li class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#" class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ is_active_menu('module-manager.*') ? 'active show' : '' }}">
                            <span class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 14 14">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1">
                                        <path d="M12.5.5h-11a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-11a1 1 0 0 0-1-1" />
                                        <path d="M7 .5v2.132a1.5 1.5 0 1 0 0 2.236v4.264a1.5 1.5 0 1 1 0 2.236V13.5" />
                                        <path d="M.5 7h2.132a1.5 1.5 0 1 0 2.236 0h4.264a1.5 1.5 0 1 1 2.236 0H13.5" />
                                    </g>
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Module Manager') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    <a href="{{ route('module-manager.index') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('module-manager.*') ? 'active' : '' }}">
                                        {{ translate('Modules') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.theme')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ is_active_menu(['theme.index'], ['hero.*', 'slider.*']) ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48"
                                    stroke-width="2.5">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M33.25 24A9.25 9.25 0 1 0 24 14.75v18.5A9.25 9.25 0 1 1 14.75 24z" />
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M14.75 24A9.25 9.25 0 1 1 24 14.75v18.5A9.25 9.25 0 1 0 33.25 24z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Theme Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    @can('menu.theme')
                                        <a href="{{ route('theme.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('theme.index*') ? 'active' : '' }}">
                                            {{ translate('All themes') }}
                                        </a>
                                    @endcan
                                </li>
                                @can('menu.hero')
                                    <li class="relative group/sub">
                                        <a href="{{ route('hero.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('hero.*') ? 'active' : '' }}">
                                            {{ translate('Hero Manage') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('menu.slider')
                                    <li class="relative group/sub">
                                        <a href="{{ route('slider.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('slider.*') ? 'active' : '' }}">
                                            {{ translate('Slider Manage') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.localization')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ is_active_menu('country.*') || is_active_menu('state.*') || is_active_menu('city.*') || is_active_menu('time-zone.*') || is_active_menu('language.*') ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="m16 24l-6.09-8.6A8.14 8.14 0 0 1 16 2a8.08 8.08 0 0 1 8 8.13a8.2 8.2 0 0 1-1.8 5.13Zm0-20a6.07 6.07 0 0 0-6 6.13a6.2 6.2 0 0 0 1.49 4L16 20.52L20.63 14A6.24 6.24 0 0 0 22 10.13A6.07 6.07 0 0 0 16 4" />
                                    <circle cx="16" cy="9" r="2" fill="currentColor" />
                                    <path fill="currentColor"
                                        d="M28 12h-2v2h2v14H4V14h2v-2H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h24a2 2 0 0 0 2-2V14a2 2 0 0 0-2-2" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Localization Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    @can('menu.language')
                                        <a href="{{ route('language.index') }}" type="button"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('language.*') ? 'active' : '' }}">
                                            {{ translate('Language') }}
                                        </a>
                                    @endcan

                                    @can('menu.country')
                                        <a href="{{ route('country.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('country.*') ? 'active' : '' }}">
                                            {{ translate('Country') }}
                                        </a>
                                    @endcan
                                    @can('menu.state')
                                        <a href="{{ route('state.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('state.*') ? 'active' : '' }}">
                                            {{ translate('State') }}
                                        </a>
                                    @endcan
                                    @can('menu.city')
                                        <a href="{{ route('city.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('city.*') ? 'active' : '' }}">
                                            {{ translate('City') }}
                                        </a>
                                    @endcan
                                    @can('menu.time.zone')
                                        <a href="{{ route('time-zone.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('time-zone.*') ? 'active' : '' }}">
                                            {{ translate('Time Zone') }}
                                        </a>
                                    @endcan
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.icon.provider')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition  {{ is_active_menu('icon.*') ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 6.5a3.5 3.5 0 1 0 7 0a3.5 3.5 0 1 0-7 0M2.5 21h8l-4-7zM14 3l7 7m-7 0l7-7m-7 11h7v7h-7z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Icon Provider Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    @can('menu.icon')
                                        <a href="{{ route('icon.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('icon.*') ? 'active' : '' }}">
                                            {{ translate('Icon') }}
                                        </a>
                                    @endcan
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.category')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('category.index') }}" type="button"
                            class="{{ is_active_menu('category.*') ? 'active' : '' }} relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M27 22.141V18a2 2 0 0 0-2-2h-8v-4h2a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-6a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2v4H7a2 2 0 0 0-2 2v4.142a4 4 0 1 0 2 0V18h8v4.142a4 4 0 1 0 2 0V18h8v4.141a4 4 0 1 0 2 0M13 4h6l.001 6H13ZM8 26a2 2 0 1 1-2-2a2 2 0 0 1 2 2m10 0a2 2 0 1 1-2-2a2.003 2.003 0 0 1 2 2m8 2a2 2 0 1 1 2-2a2 2 0 0 1-2 2" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Category') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.meeting')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('meet-provider.index') }}" type="button"
                            class="{{ is_active_menu('meet-provider.*') ? 'active' : '' }} relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 14 14">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M3.48 10.533a1.141 1.141 0 1 0 0-2.283a1.141 1.141 0 0 0 0 2.283m-2.055 2.946a2.06 2.06 0 0 1 .267-.993a2.08 2.08 0 0 1 1.788-1.045a2.08 2.08 0 0 1 1.787 1.045c.172.303.263.645.267.993m4.991-2.946a1.141 1.141 0 1 0 0-2.283a1.141 1.141 0 0 0 0 2.283M8.47 13.479a2.06 2.06 0 0 1 .267-.993a2.08 2.08 0 0 1 1.787-1.045a2.06 2.06 0 0 1 2.055 2.037m-5.58-9.431a1.065 1.065 0 1 0 0-2.13a1.065 1.065 0 0 0 0 2.13M5.008 6.718c.003-.337.092-.668.258-.962A2.01 2.01 0 0 1 7 4.743c.71.001 1.383.394 1.733 1.013c.166.294.255.625.259.962" />
                                        <path
                                            d="M11.782.545H2.218a.72.72 0 0 0-.718.718V6c0 .397.322.718.718.718h9.564A.72.72 0 0 0 12.5 6V1.263a.72.72 0 0 0-.718-.718" />
                                    </g>
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Meeting Provider') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.currency')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('currency.index') }}" type="button"
                            class="{{ is_active_menu('currency.*') ? 'active' : '' }} relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M17.005 16.003h2v-12h-10v2h8zm0 2v2.999c0 .553-.45 1-1.007 1H4.012a1 1 0 0 1-1.007-1l.002-13.998c0-.553.45-1.001 1.007-1.001h2.99v-3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1zm-11.998-10l-.002 12h10v-12zm1.998 8h4.5a.5.5 0 0 0 0-1h-3a2.5 2.5 0 0 1 0-5h.5v-1h2v1h2v2h-4.5a.5.5 0 0 0 0 1h3a2.5 2.5 0 0 1 0 5h-.5v1h-2v-1h-2z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Currency') }}
                            </span>
                        </a>
                    </li>
                @endcan



                @can('menu.course.manage')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition  {{ is_active_menu('course.*') || is_active_menu('subject.*') || is_active_menu('tag.*') || is_active_menu('level.*') || is_active_menu('bundle.*') ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19"
                                    viewBox="0 0 256 256">
                                    <path fill="currentColor"
                                        d="m164.44 105.34l-48-32A8 8 0 0 0 104 80v64a8 8 0 0 0 12.44 6.66l48-32a8 8 0 0 0 0-13.32M120 129.05V95l25.58 17ZM216 40H40a16 16 0 0 0-16 16v112a16 16 0 0 0 16 16h176a16 16 0 0 0 16-16V56a16 16 0 0 0-16-16m0 128H40V56h176zm16 40a8 8 0 0 1-8 8H32a8 8 0 0 1 0-16h192a8 8 0 0 1 8 8" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">

                                {{ translate('Course Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">

                                @can('menu.subject')
                                    <li class="relative group/sub">
                                        <a href="{{ route('subject.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('subject.*') ? 'active' : '' }}">
                                            {{ translate('Subject') }}
                                        </a>
                                    </li>
                                @endcan


                                @can('menu.tag')
                                    <li class="relative group/sub">
                                        <a href="{{ route('tag.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('tag.*') ? 'active' : '' }}">
                                            {{ translate('Tag') }}
                                        </a>
                                    </li>
                                @endcan

                                @can('menu.level')
                                    <li class="relative group/sub">
                                        <a href="{{ route('level.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('level.*') ? 'active' : '' }}">
                                            {{ translate('Level') }}
                                        </a>
                                    </li>
                                @endcan

                                @can('menu.course')
                                    <li class="relative group/sub">
                                        <a href="{{ route('course.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('course.*') ? 'active' : '' }}">
                                            {{ translate('Course') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('menu.bundle')
                                    <li class="relative group/sub">
                                        <a href="{{ route('bundle.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('bundle.*') ? 'active' : '' }}">
                                            {{ translate('Bundle Course') }}
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.enrollment')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition  {{ is_active_menu('enrollment.*') ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 2048 2048">
                                    <path fill="currentColor"
                                        d="M1848 896q42 0 78 15t64 42t42 63t16 78q0 39-15 76t-43 65l-717 719l-377 94l94-377l717-718q28-28 65-42t76-15m51 249q21-21 21-51q0-31-20-50t-52-20q-14 0-27 4t-23 15l-692 694l-34 135l135-34zM640 896H512V768h128zm896 0H768V768h768zM512 1152h128v128H512zm128-640H512V384h128zm896 0H768V384h768zM384 1664h443l-32 128H256V0h1536v743q-67 10-128 44V128H384zm384-512h514l-128 128H768z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Enrollments Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    <a href="{{ route('enrollment.index') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('enrollment.index') ? 'active' : '' }}">
                                        {{ translate('Enrollment') }}
                                    </a>
                                    <a href="{{ route('enrollment.create') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('enrollment.create') ? 'active' : '' }}">
                                        {{ translate('New Enrolled') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="#"
                        class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition  {{ is_active_menu('organization.*') || is_active_menu('student.*') || is_active_menu('instructor.*') ? 'active show' : '' }}">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                viewBox="0 0 256 256">
                                <path fill="currentColor"
                                    d="M208 34H48a14 14 0 0 0-14 14v160a14 14 0 0 0 14 14h160a14 14 0 0 0 14-14V48a14 14 0 0 0-14-14M94 120a34 34 0 1 1 34 34a34 34 0 0 1-34-34m-28.23 90a66.43 66.43 0 0 1 20.77-29.36a66 66 0 0 1 82.92 0A66.43 66.43 0 0 1 190.23 210ZM210 208a2 2 0 0 1-2 2h-5.17a77.85 77.85 0 0 0-49.38-51.71a46 46 0 1 0-50.9 0A77.85 77.85 0 0 0 53.17 210H48a2 2 0 0 1-2-2V48a2 2 0 0 1 2-2h160a2 2 0 0 1 2 2Z" />
                            </svg>
                        </span>
                        <span
                            class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                            {{ translate('User Manage') }}
                        </span>
                    </a>
                    <div
                        class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                        <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                            <li class="relative group/sub">
                                <a href="{{ route('organization.index') }}"
                                    class="{{ is_active_menu('organization.*') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden ">
                                    {{ translate('Organization') }}
                                </a>
                                <a href="{{ route('instructor.index') }}"
                                    class="{{ is_active_menu('instructor.*') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden ">
                                    {{ translate('Instructor') }}
                                </a>
                                <a href="{{ route('student.index') }}"
                                    class="{{ is_active_menu('student.*') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden">
                                    {{ translate('Student') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                @can('menu.review')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('course-review.index') }}"
                            class="{{ is_active_menu('course-review.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="m16 8l1.912 3.703l4.088.594L19 15l1 4l-4-2.25L12 19l1-4l-3-2.703l4.2-.594z" />
                                    <path fill="currentColor"
                                        d="M17.736 30L16 29l4-7h6a1.997 1.997 0 0 0 2-2V8a1.997 1.997 0 0 0-2-2H6a1.997 1.997 0 0 0-2 2v12a1.997 1.997 0 0 0 2 2h9v2H6a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4h20a4 4 0 0 1 4 4v12a4 4 0 0 1-4 4h-4.835Z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 shrink-0">
                                {{ translate('Review') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.marketing')
                    <li
                        class=" relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="{{ is_active_menu('coupon.*') ? 'active show' : '' }} dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M14.25 2.1a1.25 1.25 0 0 0-1.17-.1L6.91 4.43a1.2 1.2 0 0 1-.46.09H2.5a1.25 1.25 0 0 0-1.25 1.25v.1H0v3h1.25V9a1.25 1.25 0 0 0 1.25 1.22L4 13.4a1.26 1.26 0 0 0 1.13.72h.63A1.25 1.25 0 0 0 7 12.87v-2.53l6.08 2.43a1.3 1.3 0 0 0 .47.09a1.3 1.3 0 0 0 .7-.22a1.25 1.25 0 0 0 .55-1V3.13a1.25 1.25 0 0 0-.55-1.03m-8.5 3.67V9H2.5V5.77zm0 7.1h-.63l-1.23-2.65h1.86zm1.62-3.72A2.3 2.3 0 0 0 7 9V5.7a2.3 2.3 0 0 0 .37-.11l6.18-2.46v8.48zm7.46-3.03v2.5a1.25 1.25 0 0 0 0-2.5" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Marketing') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                @can('menu.coupon')
                                    <li class="relative group/sub">
                                        <a href="{{ route('coupon.index') }}"
                                            class=" {{ is_active_menu('coupon.*') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden">
                                            {{ translate('All Coupons') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('menu.financial')
                    <li
                        class=" relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="{{ is_active_menu('sale.*') || is_active_menu('request.payout') ? 'active show' : '' }} dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    width="20" height="20">
                                    <path
                                        d="M3.00488 3.00275H21.0049C21.5572 3.00275 22.0049 3.45046 22.0049 4.00275V20.0027C22.0049 20.555 21.5572 21.0027 21.0049 21.0027H3.00488C2.4526 21.0027 2.00488 20.555 2.00488 20.0027V4.00275C2.00488 3.45046 2.4526 3.00275 3.00488 3.00275ZM4.00488 5.00275V19.0027H20.0049V5.00275H4.00488ZM8.50488 14.0027H14.0049C14.281 14.0027 14.5049 13.7789 14.5049 13.5027C14.5049 13.2266 14.281 13.0027 14.0049 13.0027H10.0049C8.62417 13.0027 7.50488 11.8835 7.50488 10.5027C7.50488 9.12203 8.62417 8.00275 10.0049 8.00275H11.0049V6.00275H13.0049V8.00275H15.5049V10.0027H10.0049C9.72874 10.0027 9.50488 10.2266 9.50488 10.5027C9.50488 10.7789 9.72874 11.0027 10.0049 11.0027H14.0049C15.3856 11.0027 16.5049 12.122 16.5049 13.5027C16.5049 14.8835 15.3856 16.0027 14.0049 16.0027H13.0049V18.0027H11.0049V16.0027H8.50488V14.0027Z">
                                    </path>
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Financial') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                @can('menu.sale')
                                    <li class="relative group/sub">
                                        <a href="{{ route('sale.index') }}"
                                            class=" {{ is_active_menu('sale.*') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden">
                                            {{ translate('Sale') }}
                                        </a>
                                    </li>
                                @endcan

                                @can('request.payout')
                                    <li class="relative group/sub">
                                        <a href="{{ route('request.payout') }}"
                                            class=" {{ is_active_menu('request.payout') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden">
                                            {{ translate('Payout Request') }}
                                        </a>
                                    </li>
                                @endcan

                                @can('offline.menu.payment')
                                    <li class="relative group/sub">
                                        <a href="{{ route('offline.payment') }}"
                                            class=" {{ is_active_menu('offline.payment') ? 'active' : '' }} relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden">
                                            {{ translate('Offline Payment') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.testimonial')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('testimonial.index') }}"
                            class="{{ is_active_menu('testimonial.*') ? 'active' : '' }} leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M5 6C3.355 6 2 7.355 2 9v14c0 1.645 1.355 3 3 3h22c1.645 0 3-1.355 3-3V9c0-1.645-1.355-3-3-3zm0 2h22c.566 0 1 .434 1 1v14c0 .566-.434 1-1 1H5c-.566 0-1-.434-1-1V9c0-.566.434-1 1-1m6 2c-2.2 0-4 1.8-4 4c0 1.113.477 2.117 1.219 2.844A5.04 5.04 0 0 0 6 21h2c0-1.668 1.332-3 3-3s3 1.332 3 3h2a5.04 5.04 0 0 0-2.219-4.156C14.523 16.117 15 15.114 15 14c0-2.2-1.8-4-4-4m7 1v2h8v-2zm-7 1c1.117 0 2 .883 2 2s-.883 2-2 2s-2-.883-2-2s.883-2 2-2m7 3v2h8v-2zm0 4v2h5v-2z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Testimonials') }}
                            </span>
                        </a>

                    </li>
                @endcan
                @can('menu.emailtemplate')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('email-template.index') }}"
                            class="{{ is_active_menu('email-template.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <mask id="lineMdEmailPlus0">
                                        <g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1.5">
                                            <path
                                                d="M4 5h16c0.55 0 1 0.45 1 1v12c0 0.55 -0.45 1 -1 1h-16c-0.55 0 -1 -0.45 -1 -1v-12c0 -0.55 0.45 -1 1 -1Z" />
                                            <path d="M3 6.5l9 5.5l9 -5.5" />
                                            <path fill="#000" stroke="none"
                                                d="M19 13c3.31 0 6 2.69 6 6c0 3.31 -2.69 6 -6 6c-3.31 0 -6 -2.69 -6 -6c0 -3.31 2.69 -6 6 -6Z" />
                                            <path d="M16 19h6" />
                                            <path d="M19 16v6" />
                                        </g>
                                    </mask>
                                    <rect width="24" height="24" fill="currentColor"
                                        mask="url(#lineMdEmailPlus0)" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Email Templates') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.blog')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class=" dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition
                {{ is_active_menu('blog.*') || is_active_menu('blog.category.*') ? 'active show' : '' }} ">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M4 24h10v2H4zm0-6h10v2H4zm22-4H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2M6 6v6h20V6zm20 22h-6a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2m-6-8v6h6v-6z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Blog Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    @can('menu.blog.category')
                                        <a href="{{ route('blog.category.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('blog.category.*') ? 'active' : '' }}">
                                            {{ translate('Category') }}
                                        </a>
                                    @endcan

                                    @can('menu.blog')
                                        <a href="{{ route('blog.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('blog.index*') || is_active_menu('blog.edit*') ? 'active' : '' }}">
                                            {{ translate('Blog') }}
                                        </a>
                                    @endcan
                                </li>

                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.contact')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('contact.index') }}"
                            class="{{ is_active_menu('contact.*') ? 'active' : '' }} relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5">
                                        <path d="M16 2v2m1.915 18a6 6 0 0 0-12 0M8 2v2" />
                                        <circle cx="12" cy="12" r="4" />
                                        <rect width="18" height="18" x="3" y="4" rx="2" />
                                    </g>
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Contacts') }}
                            </span>
                        </a>

                    </li>
                @endcan

                @can('menu.noticeboard')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('noticeboard.index') }}"
                            class="relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ is_active_menu('noticeboard.*') ? 'active' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 20 20">
                                    <g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd">
                                        <path
                                            d="M18 6.923H2v11h16zm-16-1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-11a1 1 0 0 0-1-1z" />
                                        <path
                                            d="M6 9.423a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1 3a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m1 3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m5.768-13.025a2.5 2.5 0 0 0-3.536 0L4.354 6.277a.5.5 0 1 1-.708-.708l3.88-3.878a3.5 3.5 0 0 1 4.949 0l3.879 3.879a.5.5 0 1 1-.708.707z" />
                                    </g>
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Notice Board') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.notification')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="{{ is_active_menu('notification.*') ? 'active show' : '' }} dropdown-button top-layer relative  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="1.5"
                                        d="M18.134 11C18.715 16.375 21 18 21 18H3s3-2.133 3-9.6c0-1.697.632-3.325 1.757-4.525S10.41 2 12 2q.507 0 1 .09M19 8a3 3 0 1 0 0-6a3 3 0 0 0 0 6m-5.27 13a2 2 0 0 1-3.46 0" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Notification Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    <a href="{{ route('notification.index') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('notification.index') ? 'active' : '' }}">
                                        {{ translate('Templates') }}
                                    </a>
                                    <a href="{{ route('notification.history') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('notification.history') ? 'active' : '' }}">
                                        {{ translate('History') }}
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.support')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition  {{ is_active_menu('support-ticket.*') ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 14 14">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 7V4.37A3.93 3.93 0 0 1 7 .5a3.93 3.93 0 0 1 4 3.87V7M1.5 5.5h1A.5.5 0 0 1 3 6v3a.5.5 0 0 1-.5.5h-1a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1m11 4h-1A.5.5 0 0 1 11 9V6a.5.5 0 0 1 .5-.5h1a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1M9 12.25a2 2 0 0 0 2-2V8m-2 4.25a1.25 1.25 0 0 1-1.25 1.25h-1.5a1.25 1.25 0 0 1 0-2.5h1.5A1.25 1.25 0 0 1 9 12.25" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Ticket & Support Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    @can('menu.category.support')
                                        <a href="{{ route('support-ticket.category.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('support-ticket.category.*') ? 'active' : '' }}">
                                            {{ translate('Support Category') }}
                                        </a>
                                    @endcan
                                    @can('menu.ticket.support')
                                        <a href="{{ route('support-ticket.ticket.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('support-ticket.ticket.index') || is_active_menu('support-ticket.reply') ? 'active' : '' }}">
                                            {{ translate('Tickets') }}
                                        </a>
                                    @endcan
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.staff')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#"
                            class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition  {{ is_active_menu('staff.index') || is_active_menu('staff.index') || is_active_menu('staff/.*') || is_active_menu('staff.create') || is_active_menu('role.index') || is_active_menu('role.index.*') || is_active_menu('role.create') || is_active_menu('permission.index') || is_active_menu('permission.*') || is_active_menu('role*') ? 'active show' : '' }}">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                    viewBox="0 0 24 24">
                                    <path fill="none" stroke="currentColor" stroke-width="1.5"
                                        d="M0 22.5h24M13.5 20v-6S11 12.5 7 12.5S.5 14 .5 14v6m17-18.5v3h-3v3h3v3h3v-3h3v-3h-3v-3zm-10.756 9S3.999 8.752 3.999 6.566c0-1.691 1.344-3.062 3.002-3.062s2.995 1.371 2.995 3.062C9.996 8.75 7.26 10.5 7.26 10.5z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Staff Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    @can('menu.permission')
                                        <a href="{{ route('permission.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('permission.index') || is_active_menu('permission.*') ? 'active' : '' }}">
                                            {{ translate('Permissions') }}
                                        </a>
                                    @endcan
                                    @can('menu.role')
                                        <a href="{{ route('role.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('role.index') || is_active_menu('role.*') ? 'active' : '' }}">
                                            {{ translate('Roles') }}
                                        </a>
                                    @endcan
                                    @can('menu.staff')
                                        <a href="{{ route('staff.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('staff.index') || is_active_menu('staff.create*') ? 'active' : '' }}">
                                            {{ translate('Users') }}
                                        </a>
                                    @endcan
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.payment-method')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('payment-method.index') }}"
                            class="{{ is_active_menu('payment-method.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 48 48">
                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="3"
                                        d="M38 10L10 38M6 6l6 8l6-8M5 14h14M5 20h14m-7-6v12m20.846 0H42v16H22v-5.85" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Payment Method') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.certificate')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('certificate.create') }}"
                            class="{{ is_active_menu('certificate.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 36 36">
                                    <path fill="currentColor"
                                        d="M32 6H4a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h15l.57-.7l.93-1.14l-.09-.16H4V8h28v8.56a8.4 8.4 0 0 1 2 1.81V8a2 2 0 0 0-2-2"
                                        class="clr-i-outline clr-i-outline-path-1" />
                                    <path fill="currentColor" d="M7 12h17v1.6H7z"
                                        class="clr-i-outline clr-i-outline-path-2" />
                                    <path fill="currentColor" d="M7 16h11v1.6H7z"
                                        class="clr-i-outline clr-i-outline-path-3" />
                                    <path fill="currentColor" d="M7 23h10v1.6H7z"
                                        class="clr-i-outline clr-i-outline-path-4" />
                                    <path fill="currentColor"
                                        d="M27.46 17.23a6.36 6.36 0 0 0-4.4 11l-1.94 2.37l.9 3.61l3.66-4.46a6.26 6.26 0 0 0 3.55 0l3.66 4.46l.9-3.61l-1.94-2.37a6.36 6.36 0 0 0-4.4-11Zm0 10.68a4.31 4.31 0 1 1 4.37-4.31a4.35 4.35 0 0 1-4.37 4.31"
                                        class="clr-i-outline clr-i-outline-path-5" />
                                    <path fill="none" d="M0 0h36v36H0z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Certificate Manage') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.faq')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('faq.index') }}"
                            class="{{ is_active_menu('faq.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M7.5 2A2.5 2.5 0 0 1 10 4.5c0 .523-.167.923-.423 1.24a3 3 0 0 1-.624.561l-.167.117c-.262.182-.451.317-.586.483a.88.88 0 0 0-.2.598v1a.5.5 0 0 1-1 0v-1c0-.519.168-.916.425-1.23c.185-.226.413-.404.616-.55l.173-.121c.26-.181.449-.317.584-.485A.9.9 0 0 0 9 4.5a1.5 1.5 0 0 0-3 0a.5.5 0 0 1-1 0A2.5 2.5 0 0 1 7.5 2m0 8.1a.875.875 0 1 1 0 1.75a.875.875 0 0 1 0-1.75" />
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M7.5 14c1.18 0 2.19-.137 3.05-.389c1 .699 2.33 1.42 4.05 2.27c.916.456 1.79-.578 1.21-1.42c-.727-1.07-1.36-2.11-1.86-3.29c.736-1.17 1.04-2.61 1.04-4.17c0-3.87-1.88-7-7.5-7s-7.5 3.14-7.5 7c0 3.87 1.88 7 7.5 7zm5.61-3.36a1 1 0 0 0-.077.92c.516 1.23 1.17 2.31 1.89 3.37c-1.65-.823-2.88-1.5-3.8-2.14a1 1 0 0 0-.852-.14c-.758.221-1.67.349-2.77.349c-2.63 0-4.2-.728-5.13-1.73C1.43 10.249 1 8.789 1 6.999s.434-3.26 1.37-4.27c.927-1 2.5-1.73 5.13-1.73s4.2.728 5.13 1.73c.94 1.02 1.37 2.48 1.37 4.27c0 1.44-.284 2.68-.888 3.64z"
                                        clip-rule="evenodd" />
                                </svg>

                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Faq Manage') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.page')
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('page.index') }}"
                            class="{{ is_active_menu('page.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span
                                class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="M3 19V5h18v14zm1-1h7.5V6H4zm8.5 0H20V6h-7.5zm-7.115-2.5h4.73v-1h-4.73zm0-3h4.73v-1h-4.73zm0-3h4.73v-1h-4.73zm8.5 6h4.73v-1h-4.73zm0-3h4.73v-1h-4.73zm0-3h4.73v-1h-4.73zM11.5 18V6z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Page Manage') }}
                            </span>
                        </a>
                    </li>
                @endcan
                @can('menu.setting')
                    <li class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#" class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ is_active_menu(['theme-setting.index', 'site.language', 'backend-setting.index', 'site.language.translate'], ['site.language.*']) ? 'active show' : '' }}">
                            <span class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 15 15">
                                    <path fill="none" stroke="currentColor"
                                        d="M13.5 5.5h-12m12 0a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1h-12a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1m12 0a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1m-12-4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1m12 0h-12m12 0a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-12a1 1 0 0 1-1-1v-2a1 1 0 0 1 1-1m.5-6h3m-3 4h3m-3 4h3" />
                                </svg>
                            </span>
                            <span class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Settings Manage') }}
                            </span>
                        </a>
                        <div
                            class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                @can('setting.theme')
                                    <li class="relative group/sub">
                                        <a href="{{ route('theme-setting.index') }}"
                                            class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('theme-setting.index') ? 'active' : '' }}">
                                            {{ translate('Frontend Settings') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('menu.site-setting')
                                    <a href="{{ route('site.language') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu(['site.language'], ['site.language.*']) ? 'active' : '' }}">
                                        {{ translate('Site Language') }}
                                    </a>
                                @endcan

                                @can('menu.backend-setting')
                                    <a href="{{ route('backend-setting.index') }}" type="button"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('backend-setting.index') ? 'active' : '' }}">
                                        {{ translate('Backend Settings') }}
                                    </a>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                @can('menu.license')
                    <li class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="#" class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ is_active_menu(['license.*']) ? 'active show' : '' }}">
                            <span class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M5.25 4A3.25 3.25 0 0 0 2 7.25v9.5A3.25 3.25 0 0 0 5.25 20h5.95q.121-.235.313-.427l1.073-1.073H9.5v-8h11v.611a4.5 4.5 0 0 1 1.5.647V7.25A3.25 3.25 0 0 0 18.75 4zM20.5 9h-11V5.5h9.25c.966 0 1.75.784 1.75 1.75zM8 5.5v13H5.25a1.75 1.75 0 0 1-1.75-1.75v-9.5c0-.966.784-1.75 1.75-1.75zM19.5 19a3.5 3.5 0 1 0-3.38-2.586a.8.8 0 0 0-.15.116l-3.75 3.75a.75.75 0 0 0-.22.53v1.44c0 .414.336.75.75.75h1.75a.5.5 0 0 0 .5-.5V22h1a.5.5 0 0 0 .5-.5v-1h1a.5.5 0 0 0 .5-.5v-1zm1.5-4a1 1 0 1 1-2 0a1 1 0 0 1 2 0" />
                                </svg>
                            </span>
                            <span class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('License Key') }}
                            </span>
                        </a>
                        <div class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                            <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                                <li class="relative group/sub">
                                    <a href="{{ route('license.update.form') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('license.update.*') ? 'active' : '' }}">
                                        {{ translate('License Key Update') }}
                                    </a>
                                </li>
                                <li class="relative group/sub">
                                    <a href="{{ route('license.remove.index') }}"
                                        class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ is_active_menu('license.remove.*') ? 'active' : '' }}">
                                        {{ translate('License Key Remove') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan

                @if (module_enable_check('subscribe'))
                    <li class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('subscribe.index') }}"
                            class="{{ is_active_menu('subscribe.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 32 32">
                                    <path fill="currentColor" d="M28 2h-5v2h5v24h-5v2h5c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-5 18.52c0-4.62-3.78-5.14-6.82-5.56c-3.31-.46-5.18-.86-5.18-3.71c0-2.39 2.51-3.24 4.65-3.24c2.32 0 4.14.86 5.57 2.63l1.56-1.26C21.26 7.5 19.32 6.41 17 6.1V3h-2v3.02c-3.62.22-6 2.26-6 5.22c0 4.73 3.83 5.26 6.91 5.69c3.25.45 5.09.84 5.09 3.58c0 3.03-3.13 3.48-5 3.48c-3.43 0-4.88-.96-6.22-2.63l-1.56 1.26c1.77 2.19 3.73 3.17 6.78 3.34V29h2v-3.04c3.73-.3 6-2.33 6-5.44" />
                                    <path fill="currentColor" d="M4 4h5V2H4c-1.1 0-2 .9-2 2v24c0 1.1.9 2 2 2h5v-2H4z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 shrink-0">
                                {{ translate('Subscribe') }}
                            </span>
                        </a>
                    </li>
                @else
                    <li class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('lms.module', ['name'=> 'subscribe']) }}"
                            class="{{ is_active_menu('lms.module') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <span class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 32 32">
                                    <path fill="currentColor" d="M28 2h-5v2h5v24h-5v2h5c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2m-5 18.52c0-4.62-3.78-5.14-6.82-5.56c-3.31-.46-5.18-.86-5.18-3.71c0-2.39 2.51-3.24 4.65-3.24c2.32 0 4.14.86 5.57 2.63l1.56-1.26C21.26 7.5 19.32 6.41 17 6.1V3h-2v3.02c-3.62.22-6 2.26-6 5.22c0 4.73 3.83 5.26 6.91 5.69c3.25.45 5.09.84 5.09 3.58c0 3.03-3.13 3.48-5 3.48c-3.43 0-4.88-.96-6.22-2.63l-1.56 1.26c1.77 2.19 3.73 3.17 6.78 3.34V29h2v-3.04c3.73-.3 6-2.33 6-5.44" />
                                    <path fill="currentColor" d="M4 4h5V2H4c-1.1 0-2 .9-2 2v24c0 1.1.9 2 2 2h5v-2H4z" />
                                </svg>
                            </span>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 shrink-0">
                                {{ translate('Subscribe') }}
                            </span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
    <!-- Logout Link -->
    <div class="mt-auto px-2.5 py-6 group-data-[sidebar-size=sm]:px-2">
        <a href="#"
            class="flex-center-between text-gray-500 dark:text-dark-text font-semibold leading-none bg-gray-200 dark:bg-dark-icon dark:text-dark-text rounded-[10px] px-6 py-4 group-data-[sidebar-size=sm]:p-[12px_8px] group-data-[sidebar-size=sm]:justify-center dk-theme-card-square"
            onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">
            <span class="group-data-[sidebar-size=sm]:hidden block">{{ translate('Logout') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                <path fill="currentColor" d="M5 5h7V3H3v18h9v-2H5z" />
                <path fill="currentColor" d="m21 12l-4-4v3H9v2h8v3z" />
            </svg>
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
