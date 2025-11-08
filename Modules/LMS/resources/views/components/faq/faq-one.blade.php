<!-- FAQ -->
@php
    $faq = get_theme_option(key: 'faq') ?? [];

    $faqImg = $faq['faq_img'] ?? '';
    $img =
        $faqImg && fileExists('lms/theme-options', $faqImg) == true
            ? asset("storage/lms/theme-options/{$faqImg}")
            : asset('lms/frontend/assets/images/faq/main-img.webp');
@endphp
<div class="relative overflow-hidden pt-60 sm:pb-130 pb-24">
    <div class="container grid sm:grid-cols-12 gap-10 items-center">
        <div class="lg:col-span-6 col-span-full relative">
            <img data-src="{{ $img }}" alt="LMS-HUB" class="sticky z-20 mx-auto">
            <!-- position item -->
            <img data-src="{{ asset('lms/frontend/assets/images/faq/element-left.webp') }}" alt="LMS-HUB"
                class="animate-shakeY absolute z-10 top-32 -left-28">
        </div>
        <div class="lg:col-span-6 col-span-full lg:mx-0 sm:mx-6 mx-0">
            <!-- section heading -->
            <div>
                <h1 class="section-heading xl:pr-64 sm:pr-44 pr-12 relative"> {{ $faq['title'] ?? '' }}
                    <span class="text-secondary"> {{ $faq['high_light'] ?? '' }}
                        <img data-src="{{ asset('lms/frontend/assets/images/icons/line.webp') }}" alt="line"
                            class="md:block hidden absolute lg:left-12 left-[17.5rem] lg:top-[100px] top-10 lg:w-4/12 w-1/5">
                    </span>
                </h1>
                <p class="section-para sm:pr-20">{{ $faq['sub_title'] ?? '' }}</p>
            </div>
            <div class="mt-4">
                <div class="divide-y">
                    <x-theme::faq.faq-list :faqs="$faqs" />
                </div>
                <a href="support.html" class="btn gap-2 xl:mt-8 mt-4">{{ $faq['btn_name'] ?? '' }}
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>
        </div>
    </div>
    <!-- position items -->
    <img data-src="{{ asset('lms/frontend/assets/images/faq/dot-elemt.webp') }}" alt="pattern"
        class="animate-shakeY absolute left-24 bottom-24 xl:block hidden">
    <img data-src="{{ asset('lms/frontend/assets/images/faq/union.webp') }}" alt="pattern"
        class="animate-shakeY absolute xl:right-28 right-8 xl:top-24 top-12 lg:block hidden">
</div>
