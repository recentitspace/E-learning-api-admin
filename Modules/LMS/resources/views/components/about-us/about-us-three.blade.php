<!-- START ABOUT US AREA -->
@php
    $aboutUs = get_theme_option(key: 'about_us') ?? [];
    $aboutImg =
        isset($aboutUs['banner_img_digital']) &&
        fileExists($slider = 'lms/theme-options', $fileName = $aboutUs['banner_img_digital']) == true
            ? asset('storage/lms/theme-options/' . $aboutUs['banner_img_digital'])
            : asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
@endphp

<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 items-center">
            <div class="col-span-full lg:col-span-6">
                <img data-src="{{ $aboutImg }}" alt="About us Image">
            </div>
            <div class="col-span-full lg:col-span-6">
                <div class="lg:pl-[10%] rtl:lg:pl-0 rtl:lg:pr-[10%]">
                    <div class="area-subtitle subtitle-outline style-two text-sm uppercase">
                        {{ translate('About Us') }}
                    </div>
                    <h2 class="area-title mt-1">
                        {{ $aboutUs['title'] ?? '' }}
                    </h2>
                    <p class="area-description mt-2.5 line-clamp-2">
                        {{ clean($aboutUs['short_description'] ?? '') }}
                    </p>
                    {!! clean($aboutUs['add_description'] ?? '') !!}
                    <a href=" {{ route('about.us') }} "
                        class="btn b-solid btn-secondary-solid btn-lg !text-heading mt-11"
                        aria-label="View More Details">
                        {{ translate('View More Details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ABOUT US AREA -->
