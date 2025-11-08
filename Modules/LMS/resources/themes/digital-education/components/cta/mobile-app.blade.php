@php
    $setting = get_theme_option(key: 'general') ?? [];
@endphp

<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <div class="bg-banner-four rounded-2xl px-5 xl:px-[90px]">
            <div class="grid grid-cols-12 gap-7 items-center">
                <div class="col-span-full md:col-span-7 lg:col-span-6">
                    <div class="py-[130px]">
                        <h2 class="area-title text-white">
                            {{ translate('Are You Ready to Start Your Study?') }}
                        </h2>
                        <p class="area-description text-white mt-3">
                            {{ translate('Designing a user-friendly interface is essential for improving user engagement. Focus on simplicity, ensure accessibility, and create visually appealing elements.') }}
                        </p>
                        <div class="flex items-center flex-wrap gap-2 mt-8">
                            <a href="{{ $setting['app_store_link'] ?? '#' }}" aria-label="App store link"
                                class="btn b-solid btn-primary-solid btn-lg !text-[16px] font-bold !text-heading">
                                <i class="ri-apple-fill"></i>
                                {{ translate('App Store') }}
                            </a>
                            <a href="{{ $setting['play_store_link'] ?? '#' }}" aria-label="Play store link"
                                class="btn b-solid btn-primary-solid btn-lg !text-[16px] font-bold !bg-white !text-heading">
                                <i class="ri-google-play-fill"></i>
                                {{ translate('Play Store') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-span-full md:col-span-5 lg:col-span-6 hidden md:block">
                    <div class="flex items-end justify-center">
                        <img data-src="{{ asset('lms/frontend/assets/images/app-banner/mobile-app.webp') }}" alt="Mobile app banner"
                            class="md:max-w-[300px] lg:max-w-[400px]">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
