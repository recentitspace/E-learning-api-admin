@include('theme::layouts.partials.head')

<body class="{{ $body_class ?? '' }}">
    <div class="pre-loader-wrapper">
        <div class="loader">
            <div class="orb"></div>
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
    </div>
    @include('theme::layouts.partials.header')
    <main>
        {{ $slot }}
    </main>
    @include('theme::layouts.partials.footer')
    @include('theme::layouts.partials.footer-script')
</body>
</html>
