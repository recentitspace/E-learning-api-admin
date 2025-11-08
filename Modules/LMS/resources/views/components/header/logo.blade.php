@php
    $logo_name = get_theme_option(key: 'logo', parent_key: 'theme_logo') ?? null;
    $mainLogo =
        $logo_name && fileExists('lms/theme-options', $logo_name) == true
            ? asset("storage/lms/theme-options/{$logo_name}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
    $logo = $defaultLogo ?? $mainLogo;
@endphp
<!-- LOGO -->
<a href="{{ route('home.index') }}" class="flex-center">
    <img src="{{ $logo }}" alt="Header logo" class="max-w-24 sm:max-w-40">
</a>
