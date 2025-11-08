@php
    $logoName = get_theme_option(key: 'footer_logo', parent_key: 'theme_logo') ?? null;
    $footerLogo =
        $logoName && fileExists('lms/theme-options', $logoName) == true
            ? asset("storage/lms/theme-options/{$logoName}")
            : asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
    $top =
        get_theme_option('footer_top' . active_language()) ?:
        get_theme_option('footer_topen') ?? get_theme_option('footer_top' . app('default_language'));

    $footerLogo = $data['footer_logo'] ?? $footerLogo;
    $socials = get_theme_option(key: 'socials', parent_key: 'social') ?? [];

@endphp

<div class="py-24 lg:py-32">
    <div class="container">
        <div class="grid grid-cols-12 gap-7">
            <!-- FOOTER WIDGET ONE -->
            @if (isset($top['one_status']))
                <div class="col-span-full lg:col-span-4">
                    <a href="{{ url('/') }}" class="flex-center w-max">
                        <img src="{{ $footerLogo }}" alt="Footer logo" class="max-w-40">
                    </a>
                    <p class="text-white/70 text-lg mt-5 sm:max-w-[80%]">
                        {{ $top['one_title'] ?? '' }}
                    </p>
                    @if (isset($top['one_social_menu']))
                        @if ($socials)
                            <x-theme::social.social-list-one :socials="$socials" ulClass="flex items-center gap-2 mt-5"
                                itemClass="flex-center size-10 rounded-50 text-white bg-white/10 hover:bg-primary custom-transition" />
                        @endif
                    @endif
                </div>
            @endif

            @if (isset($top['two_status']))
                <!-- FOOTER WIDGET TWO -->
                <div class="col-span-full md:col-span-6 lg:col-span-2">
                    <h6 class="text-white text-xl font-bold leading-none">{{ $top['two_title'] ?? '' }}</h6>
                    <div class="footer-widget-one"> {!! clean($top['two_menu'] ?? '') !!}</div>
                </div>
            @endif

            @if (isset($top['three_status']))
                <!-- FOOTER WIDGET THREE -->
                <div class="col-span-full md:col-span-6 lg:col-span-2">
                    <h6 class="text-white text-xl font-bold leading-none">{{ $top['three_title'] ?? '' }}</h6>
                    <div class="footer-widget-one"> {!! clean($top['three_menu'] ?? '') !!}</div>
                </div>
            @endif

            @if (isset($top['five_status']))
                <!-- FOOTER WIDGET FOUR -->
                <div class="col-span-full lg:col-span-4">
                    <h6 class="text-white text-xl font-bold leading-none"> {{ $top['five_title'] ?? '' }}</h6>
                    <x-theme::subscribe.subscribe-form :data="$data ?? []" />
                </div>
            @endif
        </div>
    </div>
</div>
