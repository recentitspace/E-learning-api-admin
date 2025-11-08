@php
    $aboutUs =
        get_theme_option('about_us' . active_language()) ?:
        get_theme_option('about_usen') ?? get_theme_option('about_us' . app('default_language'));
    $bannerImageOne = $aboutUs['banner_img_digital'] ?? '';
    $bannerPath = "storage/lms/theme-options/{$bannerImageOne}";
    $defaultBanner = 'lms/frontend/assets/images/banner/banner_placeholder_2.svg';

    // Check if the banner image exists and is not empty
    $bannerImage =
        !empty($bannerImageOne) && file_exists(public_path($bannerPath)) ? asset($bannerPath) : asset($defaultBanner);
@endphp

<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 items-center">
            <div class="col-span-full lg:col-span-6">
                <img data-src="{{ $bannerImage }}" alt="about">
            </div>
            <div class="col-span-full lg:col-span-6">
                <div class="lg:pl-[10%] rtl:lg:pl-0 rtl:lg:pr-[10%]">
                    <h6 class="outline-text-one text-4xl lg:text-7xl">{{ translate('About Us') }}</h6>
                    <h2 class="area-title mt-1">
                        {{ $aboutUs['title'] ?? '' }}
                    </h2>
                    <div class="area-description mt-2.5 line-clamp-6">
                        {{ $aboutUs['short_description'] ?? '' }}
                    </div>
                    <a href="{{ route('about.us') }}" aria-label="Read More About us"
                        class="btn b-solid btn-primary-solid btn-lg !text-heading !text-base font-bold shrink-0 mt-11">
                        {{ translate('Read More About') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
