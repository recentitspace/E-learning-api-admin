@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
@endphp
<!DOCTYPE html>
<html lang="en" class="group" data-sidebar-size="lg">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ isset($backendSetting['app_name']) ? $backendSetting['app_name'] . ' -' : null }} {{ $title ?? null }}</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content="web development agency">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    @php
        $backendLogo = get_theme_option(key: 'backend_logo') ?? null;
    @endphp
    @if (isset($backendLogo['favicon']) && fileExists($folder = 'lms/theme-options', $fileName = $backendLogo['favicon']) == true && $backendLogo['favicon'] !== '')
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/lms/theme-options/' . $backendLogo['favicon']) }}">
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('lms/frontend/assets/images/favicon.ico') }}">
    @endif
    <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/summernote.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/select/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('lms/assets/css/output.min.css?v=' . asset_version('lms/assets/css/output.min.css')) }}" />

    @stack('css')
</head>

<body class="bg-body-light dark:bg-dark-body group-data-[theme-width=box]:container group-data-[theme-width=box]:max-w-screen-3xl xl:group-data-[theme-width=box]:px-4">
    <div id="preloader" class="dark:!bg-dark-body">
        <div id="status">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>

    <x-portal::admin.header />

    <x-portal::admin.sidebar />

    <x-portal::admin.settings-sidebar />

    <!-- Start Main Content -->
    <main class="main-content group-data-[sidebar-size=lg]:xl:ml-[calc(theme('spacing.app-menu')_+_16px)] rtl:group-data-[sidebar-size=lg]:xl:ml-0 rtl:group-data-[sidebar-size=lg]:xl:mr-[calc(theme('spacing.app-menu')_+_16px)] group-data-[sidebar-size=sm]:xl:ml-[calc(theme('spacing.app-menu-sm')_+_16px)] rtl:group-data-[sidebar-size=sm]:xl:ml-0 rtl:group-data-[sidebar-size=sm]:xl:mr-[calc(theme('spacing.app-menu-sm')_+_16px)] px-4 group-data-[theme-width=box]:xl:px-0 duration-300">
        {{ $slot }}
    </main>
    <!-- End Main Content -->

    <x-portal::admin.ai.modal />

    @include('portal::admin.placeholder')
    @auth
        @if (Auth::user()->guard == 'instructor')
            <input type="hidden" id="baseUrl" value="{{ route('instructor.dashboard') }}" />
        @elseif (Auth::user()->guard == 'organization')
            <input type="hidden" id="baseUrl" value="{{ route('organization.dashboard') }}" />
        @else
            <input type="hidden" id="baseUrl" value="{{ route('admin.dashboard') }}" />
        @endif
    @endauth

    <script src="{{ asset('lms/assets/js/vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/flowbite.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/smooth-scrollbar/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/summernote.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/toastr.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/select2.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/flatpickr.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/sweetalert2.js') }}"></script>
    <script>
        let baseUrl = $("#baseUrl").val();
        const textAreaPlaceholder = "{{ translate('Write your description here') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ edulab_asset('lms/assets/js/component/switcher.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/component/modal.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/component/ai-modal.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/tab.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/custom.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/layout.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/main.js') }}"></script>
    @stack('js')
</body>

</html>
