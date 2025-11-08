<div
    class="js-cookie-consent cookie-consent bg-[#212121] shadow-md p-6 max-w-screen-sm fixed left-1/2 -translate-x-1/2 bottom-4 rounded-[10px] z-[999]">
    <div class="js-cookie-consent-are flex flex-col h-full">
        <div class="cookie-content text-white flex flex-col gap-3">
            @php

                $cookie =
                    get_theme_option('gdpr_cookie' . active_language()) ?:
                    get_theme_option('gdpr_cookieen') ?? get_theme_option('gdpr_cookie' . app('default_language'));
            @endphp
            <h4 class="text-lg font-bold"> {{ $cookie['gdpr_title'] ?? '' }} </h4>
            <div>{!! clean($cookie['gdpr_description'] ?? '') !!}</div>
        </div>
        <div class="cookie-btn-grp flex items-center justify-end gap-3 mt-6">
            <button type="button" aria-label="Accept cookie"
                class="btn b-solid btn-warning-solid rounded-md js-cookie-consent-agree cookie-consent__agree">
                {{ translate('Accept') }}
            </button>
            <button type="button" aria-label="Decline cookie"
                class="btn b-outline btn-danger-outline rounded-md js-cookie-consent-reject">
                {{ translate('Decline') }}
            </button>
        </div>
    </div>
</div>
