<div id="app-drawer"
    class="app-menu flex flex-col bg-white dark:bg-dark-card w-app-menu fixed top-0 left-0 rtl:left-auto rtl:right-0 bottom-0 -translate-x-full rtl:translate-x-full group-data-[sidebar-size=sm]:min-h-screen group-data-[sidebar-size=sm]:h-max border-r-2 rtl:border-r-0 rtl:border-l-2 border-primary-400 xl:border-none xl:!translate-x-0 rounded-r-15 rtl:rounded-r-none rtl:rounded-l-15 xl:!rounded-15 xl:group-data-[sidebar-size=lg]:w-app-menu xl:group-data-[sidebar-size=sm]:w-app-menu-sm xl:group-data-[sidebar-size=sm]:absolute xl:group-data-[sidebar-size=lg]:fixed xl:top-4 xl:left-4 rtl:xl:left-auto rtl:xl:right-4 xl:group-data-[sidebar-size=lg]:bottom-4 xl:group-data-[theme-width=box]:left-auto rtl:xl:group-data-[theme-width=box]:right-auto dk-theme-card-square z-backdrop duration-300"
    tabindex="-1">
    <x-portal::admin.logo route="{{ route('student.dashboard') }}" />
    <div id="app-menu-scrollbar" data-scrollbar
        class="px-2.5 group-data-[sidebar-size=sm]:px-0 group-data-[sidebar-size=sm]:!overflow-visible !overflow-x-hidden smooth-scrollbar">
        <div class="group-data-[sidebar-size=lg]:max-h-full">
            <ul id="navbar-nav"
                class="text-[14px] !leading-none space-y-1 group-data-[sidebar-size=sm]:space-y-2.5 group-data-[sidebar-size=sm]:flex group-data-[sidebar-size=sm]:flex-col group-data-[sidebar-size=sm]:items-start group-data-[sidebar-size=sm]:mx-2 group-data-[sidebar-size=sm]:overflow-visible">
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.dashboard') }}"
                        class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}  relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
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
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="#"
                        class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ request()->routeIs('student.enroll.index') || request()->routeIs('student.purchase.index') || request()->routeIs('student.bundle.index') ? 'active show' : '' }}">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 256 256">
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

                            <li class="relative group/sub">
                                <a href="{{ route('student.enroll.index') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.enroll.index') ? 'active' : '' }}">
                                    {{ translate('My Enrolled') }}
                                </a>
                            </li>
                            <li class="relative group/sub">
                                <a href="{{ route('student.purchase.index') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.purchase.index') ? 'active' : '' }}">
                                    {{ translate('Course Purchase') }}
                                </a>
                            </li>
                            <li class="relative group/sub">
                                <a href="{{ route('student.bundle.index') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.bundle.index') ? 'active' : '' }}">
                                    {{ translate('Bundle Purchase') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.certificate.index') }}"
                        class="{{ request()->routeIs('student.certificate.index') ? 'active' : '' }}  relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 36 36">
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
                            {{ translate('Certificate') }}
                        </span>
                    </a>
                </li>

                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="#"
                        class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ request()->routeIs('student.quiz.result') || request()->routeIs('student.quiz.result') ? 'active show' : '' }}">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M13.5 14.539q.31 0 .545-.236t.236-.545t-.236-.545t-.545-.236t-.545.236t-.236.545t.236.545t.545.235m-.442-2.815h.884q.039-.629.199-.947q.159-.318.767-.888q.634-.576.884-1.03q.25-.452.25-1.039q0-1.01-.72-1.683q-.72-.674-1.822-.674q-.833 0-1.48.45t-.985 1.227l.811.357q.283-.586.69-.88t.964-.293q.716 0 1.187.424q.47.424.47 1.095q0 .408-.228.759q-.229.351-.787.845q-.632.552-.858 1.013t-.226 1.264M8.116 17q-.691 0-1.153-.462T6.5 15.385V4.615q0-.69.463-1.153T8.116 3h10.769q.69 0 1.153.462t.462 1.153v10.77q0 .69-.462 1.152T18.884 17zm0-1h10.769q.23 0 .423-.192t.192-.423V4.615q0-.23-.192-.423T18.884 4H8.116q-.231 0-.424.192t-.192.423v10.77q0 .23.192.423t.423.192m-3 4q-.69 0-1.153-.462T3.5 18.385V6.615h1v11.77q0 .23.192.423t.423.192h11.77v1zM7.5 4v12z" />
                            </svg>
                        </span>
                        <span
                            class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                            {{ translate('Quizzes') }}
                        </span>
                    </a>
                    <div
                        class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                        <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">

                            <li class="relative group/sub">
                                <a href="{{ route('student.quiz.result') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.quiz.result') ? 'active' : '' }}">
                                    {{ translate('My Result') }}
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.assignment.list') }}"
                        class="{{ request()->routeIs('student.assignment.list') ? 'active' : '' }}  relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M5.616 20q-.667 0-1.141-.475T4 18.386V5.615q0-.666.475-1.14T5.615 4h4.7q-.136-.766.367-1.383Q11.184 2 12.01 2t1.328.617T13.685 4h4.7q.666 0 1.14.475T20 5.615v12.77q0 .666-.475 1.14t-1.14.475zm0-1h12.769q.23 0 .423-.192t.192-.424V5.616q0-.231-.192-.424T18.384 5H5.616q-.231 0-.424.192T5 5.616v12.769q0 .23.192.423t.423.192M8 16.27h5q.213 0 .356-.145t.144-.356t-.144-.356t-.356-.144H8q-.213 0-.356.144q-.144.144-.144.357t.144.356t.356.143M8 12.5h8q.213 0 .356-.144t.144-.357t-.144-.356T16 11.5H8q-.213 0-.356.144t-.144.357t.144.356T8 12.5m0-3.77h8q.213 0 .356-.143q.144-.144.144-.357t-.144-.356T16 7.731H8q-.213 0-.356.144t-.144.357t.144.356T8 8.73m4-4.289q.325 0 .538-.212t.212-.538t-.213-.537T12 2.942t-.537.213t-.213.537t.213.538t.537.212M5 19V5z" />
                            </svg>
                        </span>
                        <span
                            class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                            {{ translate('Assignment') }}
                        </span>
                    </a>
                </li>

                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.course-review.index') }}"
                        class="{{ is_active_menu('student.course-review.*') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                        <span
                            class="shrink-0 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_0.43)] group-data-[sidebar-size=sm]:flex-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32">
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


                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.offline.payment') }}"
                        class="{{ is_active_menu('student.offline.payment') ? 'active' : '' }}  leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.5" color="currentColor">
                                <path
                                    d="M2 4.5h6.757a3 3 0 0 1 2.122.879L14 8.5m-9 5H2m6.5-6l2 2a1.414 1.414 0 1 1-2 2L7 10c-.86.86-2.223.957-3.197.227L3.5 10" />
                                <path
                                    d="M5 11v4.5c0 1.886 0 2.828.586 3.414S7.114 19.5 9 19.5h9c1.886 0 2.828 0 3.414-.586S22 17.386 22 15.5v-3c0-1.886 0-2.828-.586-3.414S19.886 8.5 18 8.5H9.5" />
                                <path d="M15.25 14a1.75 1.75 0 1 1-3.5 0a1.75 1.75 0 0 1 3.5 0" />
                            </g>
                        </svg>
                        <span
                            class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 shrink-0">
                            {{ translate('Offline Payment') }}
                        </span>
                    </a>
                </li>


                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="#"
                        class="dropdown-button top-layer relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition {{ request()->routeIs('student.supports.index') || request()->routeIs('student.course.support.index') || request()->routeIs('student.course.support.index') || request()->routeIs('student.course.support.index') || request()->routeIs('student.course.support.index') || request()->routeIs('student.supports.create') || request()->routeIs('student.course.support.create') ? 'active show' : '' }}">
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
                            {{ translate('Support Manage') }}
                        </span>
                    </a>
                    <div
                        class="dropdown-content max-h-0 group-data-[sidebar-size=sm]:!max-h-max overflow-hidden group-data-[sidebar-size=sm]:overflow-visible hidden group-data-[sidebar-size=lg]:block peer-[.show]/dp-btn:my-1.5 group-data-[sidebar-size=sm]:!my-0 group-data-[sidebar-size=lg]:w-[calc(theme('spacing.app-menu')_-_16px)] group-data-[sidebar-size=sm]:w-[calc(theme('spacing.app-menu-sm')_*_2.5)] group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:left-[calc(theme('spacing.app-menu-sm')_*_0.9)] rtl:group-data-[sidebar-size=sm]:left-auto rtl:group-data-[sidebar-size=sm]:right-[calc(theme('spacing.app-menu-sm')_*_0.9)] top-full group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-tooltip group-data-[sidebar-size=sm]:shadow-menu-dropdown transition-all duration-300">
                        <ul class="text-[14px] pl-1.5 group-data-[sidebar-size=sm]:pl-0">
                            <li class="relative group/sub">
                                <a href="{{ route('student.supports.create') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.supports.create') ? 'active' : '' }}">
                                    {{ translate('New Ticket') }}
                                </a>
                                <a href="{{ route('student.supports.index') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.supports.index') ? 'active' : '' }}">
                                    {{ translate('Ticket') }}
                                </a>

                                <a href="{{ route('student.course.support.index') }}"
                                    class="relative peer/link text-gray-500 dark:text-dark-text-two leading-none px-5 py-2.5 group-data-[sidebar-size=lg]:pl-8 rtl:group-data-[sidebar-size=lg]:pr-8 flex hover:text-primary-500 dark:hover:text-dark-text [&.active]:text-primary-500 dark:[&.active]:text-dark-text before:absolute before:top-[49%] before:-translate-y-1/2 before:left-4 rtl:before:left-auto rtl:before:right-4 before:size-1.5 before:rounded-50 before:border before:border-gray-400 dark:before:border-text-dark hover:before:border-none hover:before:bg-primary-400 dark:hover:before:bg-text-dark [&.active]:before:border-none group-data-[sidebar-size=sm]:after:block group-data-[sidebar-size=sm]:after:right-3 [&.active]:before:bg-primary-400 dark:[&.active]:before:bg-text-dark group-data-[sidebar-size=sm]:before:hidden {{ request()->routeIs('student.course.support.index') || request()->routeIs('student.course.support.create') ? 'active' : '' }}">
                                    {{ translate('Course Support') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.notification.history') }}"
                        class="{{ request()->routeIs('student.notification.history') ? 'active' : '' }}  relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
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
                            {{ translate('Notifications') }}
                        </span>
                    </a>
                </li>
                <li
                    class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                    <a href="{{ route('student.wishlist') }}"
                        class="{{ request()->routeIs('student.wishlist') ? 'active' : '' }}  relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                        <i class="ri-heart-line"></i>
                        <span
                            class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                            {{ translate('Wishlist') }}
                        </span>
                    </a>
                </li>

                @if (module_enable_check('subscribe'))
                    <li
                        class="relative group/sm w-full group-data-[sidebar-size=sm]:hover:w-[calc(theme('spacing.app-menu-sm')_*_3.4)] group-data-[sidebar-size=sm]:flex-center">
                        <a href="{{ route('student.subscribe.list') }}"
                            class="{{ request()->routeIs('student.subscribe.list') ? 'active' : '' }}  relative leading-none px-3.5 py-3 h-[42px] flex items-center rounded-md group-data-[sidebar-size=sm]:p-3 group-data-[sidebar-size=sm]:w-full text-gray-500 dark:text-dark-text-two hover:text-primary-500 dark:hover:text-white [&.active]:text-primary-500 dark:[&.active]:text-white group-data-[sidebar-size=sm]:border group-data-[sidebar-size=sm]:border-gray-200 dark:group-data-[sidebar-size=sm]:border-dark-border-four hover:!bg-primary-200 dark:hover:!bg-primary-500 [&.active]:bg-primary-200 dark:[&.active]:bg-primary-500 group-data-[sidebar-size=sm]:bg-white dark:group-data-[sidebar-size=sm]:bg-dark-card group-data-[sidebar-size=sm]:hover:bg-primary-500 group-data-[sidebar-size=sm]:[&.active]:bg-primary-200 dark:group-data-[sidebar-size=sm]:[&.active]:bg-primary-500 group/menu-link peer/dp-btn dk-theme-card-square ac-transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                viewBox="0 0 14 14">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M10.213 2.538A5.499 5.499 0 0 0 1.595 8.01a.75.75 0 0 1-1.474.277a6.999 6.999 0 0 1 11.163-6.821l.612-.612a.5.5 0 0 1 .854.353V3.5a.5.5 0 0 1-.5.5H9.957a.5.5 0 0 1-.353-.853zm2.791 2.577a.75.75 0 0 1 .876.598a6.999 6.999 0 0 1-11.164 6.821l-.612.613a.5.5 0 0 1-.854-.354V10.5a.5.5 0 0 1 .5-.5h2.293a.5.5 0 0 1 .354.854l-.61.609a5.499 5.499 0 0 0 8.618-5.472a.75.75 0 0 1 .6-.876ZM7.627 3.657a.75.75 0 0 0-1.5 0V4a1.704 1.704 0 0 0-.085 3.346l1.26.275a.32.32 0 0 1-.068.63H6.52a.32.32 0 0 1-.3-.212a.75.75 0 0 0-1.415.5a1.82 1.82 0 0 0 1.321 1.17v.362a.75.75 0 0 0 1.5 0v-.362a1.82 1.82 0 0 0-.005-3.553l-1.26-.276a.204.204 0 0 1 .044-.403h.828a.32.32 0 0 1 .3.212a.75.75 0 0 0 1.415-.5a1.82 1.82 0 0 0-1.322-1.17v-.36Z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span
                                class="group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=sm]:ml-6 rtl:group-data-[sidebar-size=sm]:ml-0 rtl:group-data-[sidebar-size=sm]:mr-6 group-data-[sidebar-size=sm]:group-hover/sm:block ml-3 rtl:ml-0 rtl:mr-3 shrink-0">
                                {{ translate('Subscription') }}
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
        <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</div>
