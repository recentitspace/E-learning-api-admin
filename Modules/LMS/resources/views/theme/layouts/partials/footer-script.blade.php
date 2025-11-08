<script src="{{ asset('lms/frontend/assets/vendor/js/jquery-3.7.1.min.js') }}"></script>
<!-- VENDOR JS -->
<script src="{{ asset('lms/frontend/assets/vendor/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('lms/assets/js/vendor/toastr.min.js') }}"></script>
<!-- THEME JS -->

<script src="{{ edulab_asset('lms/frontend/assets/js/slider.js') }}"></script>
<script src="{{ edulab_asset('lms/frontend/assets/js/tab.js') }}"></script>
<script>
    let baseUrl = "{{ url('/') }}"
    const discountText = "{{ translate('Discount') }}";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@php
    $tawkChat = get_theme_option(key: 'tawk_chat') ?? [];
    $customScript = get_theme_option('custom_script') ?? [];
    $customJs = $customScript['custom_js'] ?? '';
@endphp



@if (isset($tawkChat['status']) && $tawkChat['status'] == 'on' && (isset($tawkChat['url']) && $tawkChat['url'] !== ''))
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = "{{ $tawkChat['url'] }}";
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
@endif

@stack('js')
<script src="{{ edulab_asset('lms/frontend/assets/js/main.js') }}"></script>
<script src="{{ edulab_asset('lms/frontend/assets/js/custom.js') }}"></script>

@if ($customJs)
    <script>
        (function($) {
            "use strict";
            {!! $customJs !!}
        })(jQuery);
    </script>
@endif
<p class="d-none cookie"></p>
