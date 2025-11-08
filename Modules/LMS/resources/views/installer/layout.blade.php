<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Application Installer</title>

    @if (!alreadyInstalled())
        @if (indexFile() == true)
            <!-- style css -->
            <link rel="stylesheet" href="{{ edulab_asset('installer/assets/css/style.css') }}">
        @else
            @if (env('ASSET_URL') !== null)
                <link rel="stylesheet" href="{{ edulab_asset('installer/assets/css/style.css') }}">
            @else
                <link rel="stylesheet" href="{{ edulab_asset('public/installer/assets/css/style.css') }}">
            @endif

        @endif
    @else
        <link rel="stylesheet" href="{{ edulab_asset('installer/assets/css/style.css') }}">
    @endif
</head>

<body>

    @yield('content')

    @if (!alreadyInstalled())
        @php
            $prefix = indexFile() || env('ASSET_URL') !== null ? '' : 'public/';
        @endphp
    @else
        @php
            $prefix = '';
        @endphp
    @endif
    <script src="{{ asset($prefix . 'installer/assets/js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset($prefix . 'installer/assets/js/js-confetti.browser.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script src="{{ edulab_asset($prefix . 'installer/assets/js/main.js') }}"></script>

    @if (request()->is('/'))
        <script>
            window.location.replace(`install`);
        </script>
    @endif
    @if (request()->is('install/final'))
        <script>
            const canvas = document.getElementById('custom_canvas');
            const jsConfetti = new JSConfetti({
                canvas
            })
            jsConfetti.addConfetti();
        </script>
    @endif
</body>

</html>
