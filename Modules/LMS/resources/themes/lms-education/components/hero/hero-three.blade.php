@php
    $hero = get_theme_hero('lms-education');
    $sliders = $hero->sliders ?? [];
@endphp

@if (is_iterable($sliders))
    <div class="relative bg-primary bg-no-repeat bg-contain bg-left rounded-3xl py-16 sm:py-24 lg:py-[120px] mx-[12px] px-[12px]"
        style="background-image: url({{ asset('lms/frontend/assets/images/banner/wave-bg.png') }});">
        <div class="max-w-[1600px] mx-auto px-[7vw] lg:px-0">
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
                            $description = $translations['description'] ?? $slider->description ?? '';
                            $sliderImg = $slider->image ?? '';
                            $thumbnail =
                                $sliderImg && fileExists('lms/sliders', $sliderImg) == true
                                    ? asset("storage/lms/sliders/{$sliderImg}")
                                    : asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
                        @endphp
                        <div class="swiper-slide">
                            <div class="grid grid-cols-12 gap-5 items-center">
                                <div class="col-span-full lg:col-span-6">
                                    @if ($subTitle)
                                        <div class="area-subtitle subtitle-outline style-two bg-white/5 !border-white/15 !text-secondary">
                                            {{ $subTitle }}
                                        </div>
                                    @endif
                                    @if($title)
                                        <h1 class="area-title title-lg text-white mt-2 xl:mt-4">
                                            {{ $title }}
                                        </h1>
                                    @endif
                                    @if($description)
                                        <p class="area-description desc-lg text-white/70 mt-1.5 xl:mt-2.5 sm:pr-20 rtl:sm:pr-0 rtl:sm:pl-20 line-clamp-3">
                                            {{ $description }}
                                        </p>
                                    @endif
                                    <form action=" {{ route('newsletter.subscribe') }}" class="bg-white/10 border border-white/15 rounded-lg p-2 focus-within:border-white custom-transition max-w-screen-sm mt-10 form">
                                        @csrf
                                        <div class="flex flex-col sm:flex-row gap-2">
                                            <input type="email"
                                                placeholder="{{ translate('Enter your email') }}"
                                                name="email"
                                                class="bg-transparent text-white/70 h-12 px-4 border border-primary sm:border-transparent focus:outline-none grow" />
                                            <button type="submit" class="btn b-solid btn-secondary-solid !text-heading shrink-0"
                                                aria-label="Sign Up Now">
                                                {{ translate('Sign Up Now') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-span-full lg:col-span-6 hidden lg:block">
                                    <div class="max-w-full max-h-full flex justify-end">
                                        <img data-src="{{ $thumbnail }}" alt="Banner placeholder">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- SWIPER PAGINATION -->
        <div class="absolute w-full !bottom-6 sm:!bottom-10 xl:!bottom-20 z-10 hidden sm:block">
            <div class="banner-slider-pagination swiper-custom-pagination-two version-white"></div>
        </div>
    </div>
@endif
<!-- END BANNER AREA -->
