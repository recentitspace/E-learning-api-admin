@php
    $aboutUs =
        get_theme_option('about_us' . active_language()) ?:
        get_theme_option('about_usen') ?? get_theme_option('about_us' . app('default_language'));

    $bannerImage = $aboutUs['banner_img_elearning'] ?? '';
    $aboutTitle = $aboutUs['title'] ?? '';
    $aboutDesc = $aboutUs['short_description'] ?? '';
    $bannerPath = 'lms/theme-options';
    $defaultBanner = 'lms/frontend/assets/images/banner/banner_placeholder_2.svg';

    $thumbnail =
        $bannerImage && fileExists($bannerPath, $bannerImage) == true
            ? asset("storage/$bannerPath/$bannerImage")
            : asset($defaultBanner);
@endphp

<div class="py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <div class="grid grid-cols-12 gap-4 xl:gap-7 items-center">
            <div class="col-span-full lg:col-span-6">
                <img data-src="{{ $thumbnail }}" alt="banner">
            </div>
            <div class="col-span-full lg:col-span-6">
                <div class="lg:pl-[10%] rtl:lg:pl-0 rtl:lg:pr-[10%]">
                    @if ($aboutTitle)
                        <h2 class="area-title">{{ $aboutTitle }}</h2>
                    @endif
                    @if ($aboutDesc)
                        <p class="area-description mt-2.5 line-clamp-2">{{ $aboutDesc }}</p>
                    @endif
                    <div class="flex [&>:not(:first-child)]:pl-10 rtl:[&>:not(:first-child)]:pl-0 rtl:[&>:not(:first-child)]:pr-10 space-x-10 rtl:space-x-reverse divide-x rtl:divide-x-reverse divide-border {{ $aboutTitle || $aboutDesc ? 'mt-10' : '' }}">
                        <div class="flex flex-col gap-2">
                            <div class="area-title">
                                <span class="lms-counter" data-value="12"> {{ $aboutUs['active_user'] ?? '' }} </span>
                                <span class="count-suffix uppercase">
                                    {{ translate('m+') }}
                                </span>
                            </div>
                            <div class="text-heading leading-none font-secondary uppercase">
                                {{ translate('Active users') }}
                            </div>
                            <p class="area-description line-clamp-2">
                                {{ $aboutUs['active_user_short_des'] ?? '' }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <div class="area-title">
                                <span class="lms-counter" data-value="70"> {{ $aboutUs['satisfied_student'] ?? '' }}
                                </span>
                                <span class="count-suffix uppercase">
                                    %
                                </span>
                            </div>
                            <div class="text-heading leading-none font-secondary uppercase">
                                {{ translate('Satisfied Students') }}
                            </div>
                            <p class="area-description line-clamp-2">
                                {{ $aboutUs['satisfied_user_short_des'] ?? '' }}
                            </p>
                        </div>
                    </div>
                    <a href="{{ route('about.us') }}" class="btn b-solid btn-primary-solid btn-lg !rounded-none mt-11" aria-label="Explore details">
                        {{ translate('Explore Details') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
