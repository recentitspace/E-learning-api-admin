@php
    $backend_logo_options = get_theme_option(key: 'backend_logo') ?? [];
    $backend_logo = $backend_logo_options['logo'] ?? null;
    $backend_dark_logo = $backend_logo_options['dark_logo'] ?? null;
    $backend_icon_logo = $backend_logo_options['icon_logo'] ?? null;
    $backend_dark_icon_logo = $backend_logo_options['dark_icon_logo'] ?? null;
    $mainLogo =
        $backend_logo && fileExists('lms/theme-options', $backend_logo) == true
            ? asset("storage/lms/theme-options/{$backend_logo}")
            : asset('lms/assets/images/logo/logo.svg');

    $darkLogo =
        $backend_dark_logo && fileExists('lms/theme-options', $backend_dark_logo) == true
            ? asset("storage/lms/theme-options/{$backend_dark_logo}")
            : asset('lms/assets/images/logo/dark-logo.svg');

    $iconLogo =
        $backend_icon_logo && fileExists('lms/theme-options', $backend_icon_logo) == true
            ? asset("storage/lms/theme-options/{$backend_icon_logo}")
            : asset('lms/assets/images/logo/icon-logo.svg');

    $darkIconLogo =
        $backend_dark_icon_logo &&
        fileExists('lms/theme-options', $backend_dark_icon_logo) == true
            ? asset("storage/lms/theme-options/{$backend_dark_icon_logo}")
            : asset('lms/assets/images/logo/dark-icon-logo.svg');
@endphp
<div
    class="px-6 group-data-[sidebar-size=sm]:px-4 h-header flex items-center shrink-0 group-data-[sidebar-size=sm]:justify-center">
    <a href="{{ $route }}" class="group-data-[sidebar-size=lg]:block hidden">
        <img src="{{ $mainLogo }}" class="hidden group-[.light]:block max-w-[100px]" alt="main-logo" />
        <img src="{{ $darkLogo }}" class="hidden group-[.dark]:block max-w-[100px]" alt="dark-logo" />
    </a>
    <a href="{{ $route }}" class="group-data-[sidebar-size=lg]:hidden block">
        <img src="{{ $iconLogo }}" class="hidden group-[.light]:block" alt="icon-logo" />
        <img src="{{ $darkIconLogo }}" class="hidden group-[.dark]:block" alt="dark-icon-logo">
    </a>
</div>
