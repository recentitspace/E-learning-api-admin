<!-- START ABOUT US AREA -->
@php
    $aboutUs =
        get_theme_option('about_us' . active_language()) ?:
        get_theme_option('about_usen') ?? get_theme_option('about_us' . app('default_language'));
    $bannerImageOne = $aboutUs['banner_img_lms'] ?? '';
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
                <img data-src="{{ $bannerImage }}" alt="About us banner">
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
                        {{ $aboutUs['short_description'] ?? '' }}
                    </p>
                    <div
                        class="font-secondary font-medium text-sm leading-[1.44] mt-10 [&>:not(:first-child)]:mt-3 [&_li]:flex [&_li]:items-start [&_li]:gap-2 [&_li]:before:font-remix [&_li]:before:content-['\eb7a'] [&_li]:before:text-[18px]">
                        {!! clean($aboutUs['add_description'] ?? '') !!}
                    </div>
                    <a href="{{ route('about.us') }}" title="{{ translate('View more details about us') }}"
                        aria-label="View more details about us"
                        class="btn b-solid btn-secondary-solid btn-lg !text-heading mt-11">
                        {{ translate('View More Details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ABOUT US AREA -->
