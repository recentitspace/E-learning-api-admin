@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? [];
    $logo = $data['logo_options'] ?? get_theme_option(key: 'theme_logo');

    $defaultFavIcon =
        isset($logo['favicon']) && fileExists('lms/theme-options', $logo['favicon']) == true
            ? asset("storage/lms/theme-options/{$logo['favicon']}")
            : asset('lms/frontend/assets/images/favicon.svg');
    $favIcon = $data['fav_icon'] ?? $defaultFavIcon;

    $customScript = get_theme_option('custom_script') ?? [];
    $customCss = $customScript['custom_css'] ?? '';
    $customJs = $customScript['custom_js'] ?? '';
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() ?? app('default_language') }}" class="group" dir="{{ active_rtl() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $backendSetting['app_name'] ?? translate('Edulab LMS') }}</title>
    <meta name="description" content="web development agency">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $favIcon }}">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap">
    @stack('css')
    <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms/frontend/assets/vendor/css/swiper-bundle.min.css') }}">
    <script src="{{ asset('lms/frontend/assets/vendor/js/lozad.min.js') }}"></script>
    <link rel="stylesheet"
        href="{{ asset('lms/frontend/assets/css/output.min.css?v=' . asset_version('lms/frontend/assets/css/output.min.css')) }}">
    @if ($customCss)
        <style>
            {!! $customCss !!}
        </style>
    @endif
</head>
