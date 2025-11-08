@php
    $isAdmin = isAdmin();

    $user = authCheck();
    $isStudent = isStudent();
    $isInstructor = isInstructor();
    $isOrganization = isOrganization();

    if ($isStudent || $isInstructor || $isOrganization) {
        $userInfo = $user?->userable ?? null;

        $userTranslations = parse_translation($userInfo);

        $email = $user->email ?? '';

        $firstName = $userTranslations['first_name'] ?? ($userInfo?->first_name ?? '');
        $lastName = $userTranslations['last_name'] ?? ($userInfo?->last_name ?? '');
        $orgName = $userTranslations['name'] ?? ($userInfo?->name ?? '');

        $name = isset($userInfo?->first_name, $userInfo?->last_name) ? $firstName . ' ' . $lastName : $orgName;
        $imagePath = userImagePath($user->guard);
    }
@endphp

<header
    class="header px-4 sm:px-6 h-[calc(theme('spacing.header')_-_10px)] sm:h-header bg-white dark:bg-dark-card rounded-none xl:rounded-10 flex items-center mb-4 xl:m-4 group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_32px)] rtl:group-data-[sidebar-size=lg]:xl:ml-4 rtl:group-data-[sidebar-size=lg]:xl:mr-[calc(theme('spacing.app-menu')_+_32px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_32px)] rtl:group-data-[sidebar-size=sm]:xl:ml-0 rtl:group-data-[sidebar-size=sm]:xl:mr-[calc(theme('spacing.app-menu-sm')_+_32px)] group-data-[sidebar-size=sm]:group-data-[theme-width=box]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] rtl:group-data-[sidebar-size=sm]:group-data-[theme-width=box]:xl:ml-0 rtl:group-data-[sidebar-size=sm]:group-data-[theme-width=box]:xl:mr-[calc(theme('spacing.app-menu-sm')_+_16px)] group-data-[theme-width=box]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] rtl:group-data-[theme-width=box]:xl:ml-0 rtl:group-data-[theme-width=box]:xl:mr-[calc(theme('spacing.app-menu')_+_16px)] group-data-[theme-width=box]:xl:mr-0 xl:dk-theme-card-square duration-300">
    <div class="flex-center-between grow">
        <!-- Header Left -->
        <div class="flex items-center gap-4">
            <div class="menu-hamburger-container flex-center">
                <button type="button" id="app-menu-hamburger"
                    class="menu-hamburger hover:bg-primary hover:text-white hidden xl:block"></button>
                <button type="button" class="menu-hamburger hover:bg-primary hover:text-white block xl:hidden"
                    data-drawer-target="app-drawer" data-drawer-show="app-drawer" aria-controls="app-drawer"></button>
            </div>
        </div>
        <!-- Header Right -->
        <div class="flex items-center gap-3">
            @if (count(app('languages')) > 0)
                <div
                    class="flex items-center justify-end space-x-5 divide-x divide-white/15 [&>:not(:first-child)]:pl-5 grow">
                    <div class="flex items-center">
                        <form method="get" action="{{ route('language.set') }}" id="language-form">
                            @csrf
                            <input type="hidden" name="admin_id"
                                value="{{ auth('admin')->check() ? auth('admin')->user()->id : null }}">
                            <input type="hidden" name="user_id"
                                value="{{ auth()->check() ? auth()->user()->id : null }}">
                            <select name="locale" aria-label="Choose Language"
                                onchange="event.preventDefault();
                                document.getElementById('language-form').submit();"
                                class="text-gray-500 dark:text-dark-text dark:bg-dark-card-shade font-semibold bg-transparent focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                                @foreach (app('languages') as $language)
                                    <option value="{{ $language->code }}"
                                        {{ app()->getLocale() == $language->code ? 'selected' : '' }}>
                                        {{ $language->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                </div>
            @endif
            <!-- View Frontend Link -->
            <a href="{{ route('home.index') }}" target="_blank" aria-label="View Site Frontend Link"
                class="relative size-8 hidden sm:flex-center hover:bg-gray-200 dark:hover:bg-dark-icon rounded-md after:absolute after:-top-1.5 after:border-transparent after:border-[6px] after:!border-t-gray-500 after:invisible after:opacity-0 before:absolute before:bottom-[calc(100%_+_6px)] before:content-['Visit_Website'] before:bg-gray-500 before:w-max before:px-2 before:py-1 before:text-white before:rounded-md before:text-xs before:invisible before:opacity-0 before:duration-200 after:duration-200 hover:before:visible hover:before:opacity-100 hover:after:visible hover:after:opacity-100 dk-theme-card-square">
                <i class="ri-eye-fill text-[22px]"></i>
            </a>
            <!-- Light/Dark Button -->
            <button type="button"
                class="themeMode size-8 hidden sm:flex-center hover:bg-gray-200 dark:hover:bg-dark-icon rounded-md dk-theme-card-square"
                onclick="toggleThemeMode()">
                <i class="ri-contrast-2-line text-[22px] group-[.dark]:before:!content-['\f1bf']"></i>
            </button>
            <!-- Settings Button -->
            <button type="button" aria-label="Offcanvas menu settings" data-offcanvas-id="app-settings-sidebar"
                class="size-8 flex-center hover:bg-gray-200 dark:hover:bg-dark-icon rounded-md dk-theme-card-square">
                <i class="ri-settings-3-line text-[22px] animate-spin-slow"></i>
            </button>

            @if ($isAdmin)
                <x-portal::admin.notification read-route="{{ route('notification.read.all') }}"
                    route="{{ route('notification.history') }}" :notifications="Auth::user()->unreadNotifications"
                    singleRoute="notification.history.status" />
            @endif
            @if ($isStudent)
                <x-portal::admin.notification read-route="{{ route('student.notification.read.all') }}"
                    route="{{ route('student.notification.history') }}" :notifications="Auth::user()->unreadNotifications"
                    singleRoute="student.notification.history.status" />
            @endif
            @if ($isOrganization)
                <x-portal::admin.notification read-route="{{ route('organization.notification.read.all') }}"
                    route="{{ route('organization.notification.history') }}" :notifications="Auth::user()->unreadNotifications"
                    singleRoute="organization.notification.history.status" />
            @endif
            @if ($isInstructor)
                <x-portal::admin.notification read-route="{{ route('instructor.notification.read.all') }}"
                    route="{{ route('instructor.notification.history') }}" :notifications="Auth::user()->unreadNotifications"
                    singleRoute="instructor.notification.history.status" />
            @endif
            <!-- Border -->
            <div class="w-[1px] h-[calc(theme('spacing.header')_-_10px)] sm:h-header bg-[#EEE] dark:bg-dark-card-shade">
            </div>
            <!-- User Profile Button -->
            <div class="relative">
                <button type="button" data-popover-target="dropdownProfile" data-popover-trigger="click"
                    data-popover-placement="bottom-end" class="flex items-center gap-2">
                    @if ($isStudent || $isInstructor || $isOrganization)
                        @if (fileExists('lms/' . $imagePath, $userInfo->profile_img) == true && $userInfo?->profile_img != '')
                            <img src="{{ asset('storage/lms/' . $imagePath . '/' . $userInfo->profile_img) }}"
                                alt="cover-image"
                                class="size-9 rounded-50 dk-theme-card-square object-cover object-center">
                        @else
                            <img src="{{ asset('lms/assets/images/placeholder/profile.jpg') }}" alt="user-img"
                                class="size-10 rounded-50 dk-theme-card-square object-cover object-center">
                        @endif
                    @endif
                    @if ($isAdmin)
                        @php
                            $profileImg = Auth::guard('admin')->user()->profile_img;
                            $photo =
                                fileExists('lms/admins', $profileImg) == true && $profileImg !== ''
                                    ? asset('storage/lms/admins/' . $profileImg)
                                    : asset('lms/assets/images/placeholder/profile.jpg');
                        @endphp

                        <img src="{{ $photo }}" alt="user-img"
                            class="size-10 rounded-50 dk-theme-card-square object-cover">
                    @endif
                </button>
                <div id="dropdownProfile"
                    class="invisible z-backdrop bg-white text-left divide-y [&>:last-child:border-t-0] divide-gray-100 rounded-lg shadow w-48 dark:bg-dark-card-shade dark:divide-dark-border-four dk-theme-card-square">
                    <div class="px-4 py-3 text-sm text-gray-500 dark:text-white rtl:text-right">
                        <h6 class="card-title text-lg">
                            @if ($isStudent || $isInstructor || $isOrganization)
                                {{ $name ?? '' }}
                            @endif

                            @if ($isAdmin)
                                {{ Auth::guard('admin')->user()->name }}
                            @endif
                        </h6>
                        <div class="ext-sm text-gray-500 dark:text-dark-text">
                            @if ($isAdmin)
                                <div class="truncate"> {{ Auth::guard('admin')->user()->email }}</div>
                            @endif
                            @if ($isStudent || $isInstructor || $isOrganization)
                                <div class="truncate"> {{ $email }}</div>
                            @endif
                        </div>
                    </div>
                    <ul class="text-sm text-gray-700 dark:text-gray-200">

                        @if ($isAdmin)
                            <li>
                                <a href="{{ route('admin.profile') }}"
                                    class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">
                                    {{ translate('My Profile') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('home.index') }}" target="_blank"
                                class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">
                                {{ translate('Visit Website') }}
                            </a>
                        </li>

                        @if ($isStudent)
                            <li>
                                <a href="{{ route('student.enroll.index') }}"
                                    class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">
                                    {{ translate('My Course') }}
                                </a>
                            </li>
                        @endif
                        @if ($isInstructor)
                            <li>
                                <a href="{{ route('instructor.setting') }}"
                                    class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">
                                    {{ translate('Setting') }}
                                </a>
                            </li>
                        @endif
                        @if ($isOrganization)
                            <li>
                                <a href="{{ route('organization.setting') }}"
                                    class="flex font-medium px-4 py-2 hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white">
                                    {{ translate('Setting') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                    @if ($isInstructor)
                        <a href="{{ route('instructor.logout') }}"
                            class="flex font-medium px-4 py-2 text-sm text-gray-700 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white"
                            onclick="event.preventDefault();
                            document.getElementById('header-logout-form').submit();">
                            {{ translate('Log out') }}
                        </a>
                        <form id="header-logout-form" action="{{ route('instructor.logout') }}" method="POST"
                            class="hidden">
                            @csrf
                        </form>
                    @endif
                    @if ($isStudent)
                        <a href="{{ route('student.logout') }}"
                            class="flex font-medium px-4 py-2 text-sm text-gray-700 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white"
                            onclick="event.preventDefault();
                            document.getElementById('header-logout-form').submit();">
                            {{ translate('Log out') }}
                        </a>
                        <form id="header-logout-form" action="{{ route('student.logout') }}" method="POST"
                            class="hidden">
                            @csrf
                        </form>
                    @endif
                    @if ($isOrganization)
                        <a href="{{ route('organization.logout') }}"
                            class="flex font-medium px-4 py-2 text-sm text-gray-700 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white"
                            onclick="event.preventDefault();
                            document.getElementById('header-logout-form').submit();">
                            {{ translate('Log out') }}
                        </a>
                        <form id="header-logout-form" action="{{ route('organization.logout') }}" method="POST"
                            class="hidden">
                            @csrf
                        </form>
                    @endif

                    @if ($isAdmin)
                        <a href="{{ route('admin.logout') }}"
                            class="flex font-medium px-4 py-2 text-sm text-gray-700 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-icon dark:hover:text-white"
                            onclick="event.preventDefault();
                    document.getElementById('header-logout-form').submit();">
                            {{ translate('Log out') }}
                        </a>
                        <form id="header-logout-form" action="{{ route('admin.logout') }}" method="POST"
                            class="hidden">
                            @csrf
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>
<!-- End Header -->
