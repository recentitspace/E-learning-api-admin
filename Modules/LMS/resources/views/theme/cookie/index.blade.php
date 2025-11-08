@php
    $cookieConfig = $cookieConsentConfig ?? [];
    $readLess = translate('Read less');
    $readMore = translate('Read more');
@endphp

@if ($cookieConfig['cookie_enabled'] && !$alreadyConsentedWithCookies)
    @include('theme::cookie.dialogContents')
    <script>
        window.laravelCookieConsent = (function() {
            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {
                setCookie('{{ $cookieConfig['cookie_name'] }}', COOKIE_VALUE,
                    {{ $cookieConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');
                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value +
                    ';expires=' + date.toUTCString() +
                    ';domain=' + COOKIE_DOMAIN +
                    ';path=/{{ config('session.secure') ? ';secure' : null }}' +
                    '{{ config('session.same_site') ? ';samesite=' . config('session.same_site') : null }}';
            }

            if (cookieExists('{{ $cookieConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            const buttons = document.getElementsByClassName('js-cookie-consent-agree');
            let rejectButton = document.getElementsByClassName("js-cookie-consent-reject");
            for (let i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }
            for (let i = 0; i < rejectButton.length; ++i) {
                rejectButton[i].addEventListener('click', consentWithCookies);
            }
            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();

        $('.cookie-see-more-btn').click(function() {
            $('.cookie-description').slideToggle();
            if ($('.cookie-see-more-btn').text() == "Read more") {
                $(this).html(`<b>${$readMore}</b>`)
            } else {
                $(this).html(`<b>${$readMore}</b>`)
            }
        });
    </script>
@endif
