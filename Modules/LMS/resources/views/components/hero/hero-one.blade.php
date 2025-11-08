@php
    $hero = get_theme_hero('default');
    $sliders = $hero->sliders ?? [];
    $socials = get_theme_option(key: 'socials', parent_key: 'social') ?? [];
@endphp

<div class="relative bg-primary-50 pt-24 pb-48 xl:pt-40 xl:pb-80 overflow-hidden">
    <div class="container">
        <div class="swiper banner-slider">
            <div class="swiper-wrapper">
                @foreach ($sliders as $slider)
                    @php       
                        if ( ! $slider->status ) {
                            continue;
                        }
                        $translations = parse_translation($slider);
                        $subTitle = $translations['sub_title'] ?? $slider->sub_title ?? '';
                        $title = $translations['title'] ?? $slider->title ?? '';
                        $highlightText = $translations['highlight_text'] ?? $slider->highlight_text ?? '';
                        $description = $translations['description'] ?? $slider->description ?? '';
                        $button = $slider->buttons ?? [];
                        $buttonTranslations = $translations['buttons'] ?? [];
                        $sliderImg = $slider->image ?? '';
                        $thumbnail =
                            $sliderImg && fileExists('lms/sliders', $sliderImg) == true
                                ? asset("storage/lms/sliders/{$sliderImg}")
                                : asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
                    @endphp
                    <!-- SINGLE SLIDER ITEM -->
                    <div class="swiper-slide">
                        <div class="grid grid-cols-12 gap-7">
                            <div class="col-span-full lg:col-span-7">
                                <div class="area-subtitle subtitle-outline">{{ $translations['sub_title'] ?? $slider->sub_title ?? '' }}</div>
                                @if($title)
                                    <h1 class="area-title title-lg mt-2 xl:mt-4">
                                        {{ $title }}
                                        @if($highlightText)
                                            <span class="title-highlight-one">{{ $highlightText }}</span>
                                        @endif
                                    </h1>
                                @endif
                                @if($description)
                                    <p class="area-description desc-lg mt-2 xl:mt-5 sm:pr-20 rtl:sm:pr-0 rtl:sm:pl-20">{{ $description }}</p>
                                @endif
                                @if (!empty($button))
                                    <a href="{{ $button['link'] ?? '' }}" aria-label="Hero call to action" class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium mt-7">
                                        {{ $buttonTranslations['name'] ?? $button['name'] ?? '' }}
                                        <span class="hidden md:block">
                                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span>
                                    </a>
                                @endif
                            </div>
                            <div class="col-span-full lg:col-span-5 hidden lg:block">
                                <div class="bg-white border-[12px] border-heading rounded-[20px] overflow-hidden">
                                    <img src="{{ $thumbnail }}" alt="Hero image">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- SWIPER PAGINATION -->
    <div class="banner-slider-pagination swiper-custom-pagination absolute w-full !bottom-24 xl:!bottom-36 z-10">
    </div>
    <!-- SOCIAL MEDIA -->


    @if ($socials)
        <div class="px-3 py-2 border border-white rounded-full hidden min-[1536px]:flex items-center gap-4 w-max text-orientation-mixed writing-mode absolute left-4 top-1/2 !-translate-y-1/2 z-10">
            <div class="text-heading dark:text-white font-bold leading-none"> {{ translate('Follow Us') }} -</div>
            <x-theme::social.social-list-one 
                :socials="$socials" 
                ulClass="flex items-center gap-2"
                itemClass="size-10 rounded-50 bg-white text-heading dark:text-white flex-center hover:bg-primary hover:text-white custom-transition" 
            />
        </div>
    @endif
    <!-- POSITIONAL ELEMENTS -->
    <ul>
        <!-- TOP LEFT -->
        <li class="block size-[550px] rounded-50 bg-[#1AEBC5]/15 blur-[200px] absolute -top-[20%] -left-[10%]"></li>
        <!-- BOTTOM CENTER -->
        <li class="block size-[550px] rounded-50 bg-[#F98272]/15 blur-[200px] absolute -bottom-[30%] left-1/2 -translate-x-1/2"></li>
        <!-- TOP RIGHT -->
        <li class="block size-[550px] rounded-50 bg-[#5F3EED]/20 blur-[200px] absolute -top-[20%] -right-[10%]"></li>
    </ul>
    <!-- WAVE ANIMATION -->
    <div class="w-full absolute bottom-0 left-0 right-0">
        <img data-src="{{ asset('lms/frontend/assets/images/banner/wave.png') }}" class="w-full" alt="wave">
    </div>
</div>
