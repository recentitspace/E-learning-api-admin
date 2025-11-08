@php
    $general = $data['general'] ?? (get_theme_option(key: 'general') ?? []);
    $activeThemeSlug = key_snake_case(active_theme_slug());
    $footerLogo = $data['footer_logo'] ?? '';
@endphp

<div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7">
    <div class="col-span-full md:col-span-6 lg:col-span-3">
        <a href="{{ route('home.index') }}" class="flex-center w-max" aria-label="Footer logo">
            <img src="{{ $footerLogo }}" alt="Footer logo" class="max-w-40">
        </a>
    </div>
    <div class="col-span-full md:col-span-6 lg:col-span-3">
        <div class="flex items-center gap-4">
            <div class="size-12 flex-center rounded-50 bg-white/10 text-white overflow-hidden shrink-0">
                <i class="ri-customer-service-fill"></i>
            </div>
            <div class="grow">
                <h6 class="area-title text-base font-semibold text-white !leading-none"> {{ translate('Phone') }}</h6>
                <div class="area-description text-sm !leading-none text-white/60 mt-2">
                    <a href="tel:+{{ $general['phone'] ?? '' }}"
                        aria-label="Company phone">{{ $general['phone'] ?? '' }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-full md:col-span-6 lg:col-span-3">
        <div class="flex items-center gap-4">
            <div class="size-12 flex-center rounded-50 bg-white/10 text-white overflow-hidden shrink-0">
                <i class="ri-mail-send-fill"></i>
            </div>
            <div class="grow">
                <h6 class="area-title text-base font-semibold text-white !leading-none">{{ translate('Mail') }}</h6>
                <div class="area-description text-sm !leading-none text-white/60 mt-2">
                    <a href="mailto:{{ $general['email'] ?? '' }}"
                        aria-label="Company mail">{{ $general['email'] ?? '' }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-span-full md:col-span-6 lg:col-span-3">
        <div class="flex items-center gap-4">
            <div class="size-12 flex-center rounded-50 bg-white/10 text-white overflow-hidden shrink-0">
                <i class="ri-map-pin-fill"></i>
            </div>
            <div class="grow">
                <h6 class="area-title text-base font-semibold text-white !leading-none">{{ translate('Our Address') }}
                </h6>
                <div class="area-description text-sm !leading-none text-white/60 mt-2" aria-label="Company address">
                    {{ $general['address'] ?? '' }}
                </div>
            </div>
        </div>
    </div>
</div>
