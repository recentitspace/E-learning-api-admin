@php

    $aboutUs =
        get_theme_option('about_us' . active_language()) ?:
        get_theme_option('about_usen') ?? get_theme_option('about_us' . app('default_language'));
    $bannerImageOne = $aboutUs['banner_img_kindergarten'] ?? '';
    $bannerPath = "storage/lms/theme-options/{$bannerImageOne}";
    $defaultBanner = 'lms/frontend/assets/images/banner/banner_image_3.svg';

    // Check if the banner image exists and is not empty
    $bannerImage =
        !empty($bannerImageOne) && file_exists(public_path($bannerPath)) ? asset($bannerPath) : asset($defaultBanner);
@endphp

<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container relative">
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 items-center">
            <div class="col-span-full lg:col-span-6">
                <img data-src="{{ $bannerImage }}" alt="about">
            </div>
            <div class="col-span-full lg:col-span-6">
                <div class="lg:pl-[10%] rtl:lg:pl-0 rtl:lg:pr-[10%]">
                    <h2 class="area-title">
                        {{ $aboutUs['title'] ?? '' }}
                        <span class="title-highlight-two">
                            {{ $aboutUs['highlight_title'] ?? '' }}
                        </span>
                    </h2>
                    <div class="area-description mt-2.5 line-clamp-3">
                        {{ $aboutUs['short_description'] ?? '' }}
                    </div>
                    <div
                        class="font-medium text-sm leading-[1.44] mt-10 [&>:not(:first-child)]:mt-3 [&_li]:flex [&_li]:items-start [&_li]:gap-2 [&_li]:before:font-remix [&_li]:before:content-['\f0ff'] [&_li]:before:text-primary [&_li]:before:text-[18px]">
                        {!! clean($aboutUs['add_description'] ?? '') !!}
                    </div>
                    <a href="{{ route('about.us') }}" aria-label="Read More About"
                        title="{{ translate('Read More About us') }}"
                        class="btn b-solid btn-primary-solid btn-lg !px-7 !rounded-full !text-base font-bold shrink-0 mt-11">
                        {{ translate('Read More About') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 pt-10 sm:pt-16 lg:pt-[90px]">
            <div class="col-span-full lg:col-span-4">
                <div class="bg-[#F0F6E8] px-9 py-11 rounded-xl h-full">
                    <div class="flex items-start gap-3">
                        <div class="size-14 rounded-50 flex-center bg-primary text-white p-2 shrink-0">
                            <i class="ri-customer-service-2-line text-2xl"></i>
                        </div>
                        <div class="grow">
                            <h6 class="area-title text-xl !leading-none">{{ translate('Educator Support') }}</h6>
                            <div class="area-description text-base line-clamp-3 mt-3">
                                {{ translate('Majority have suffered alteration in some form, by injected humour There are many variations.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-4">
                <div class="bg-[#F4F4FF] px-9 py-11 rounded-xl h-full">
                    <div class="flex items-start gap-3">
                        <div class="size-14 rounded-50 flex-center bg-blue-700 text-white p-2 shrink-0">
                            <i class="ri-group-line text-2xl"></i>
                        </div>
                        <div class="grow">
                            <h6 class="area-title text-xl !leading-none">{{ translate('Top Instructors') }}</h6>
                            <div class="area-description text-base line-clamp-3 mt-3">
                                {{ translate('Majority have suffered alteration in some form, by injected humour There are many variations.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-4">
                <div class="bg-[#F0F6E8] px-9 py-11 rounded-xl h-full">
                    <div class="flex items-start gap-3">
                        <div class="size-14 rounded-50 flex-center bg-secondary text-white p-2 shrink-0">
                            <i class="ri-award-fill text-2xl"></i>
                        </div>
                        <div class="grow">
                            <h6 class="area-title text-xl !leading-none">{{ translate('Best Award Wining') }}</h6>
                            <div class="area-description text-base line-clamp-3 mt-3">
                                {{ translate('Majority have suffered alteration in some form, by injected humour There are many variations.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
