@php
    $students = get_all_student('4');
    $hero = get_theme_hero('digital-education');
    $sliders = $hero->sliders ?? [];
    $totalStudents = get_all_student()?->count() ?? 0;
    $studentsInThousands = number_format($totalStudents / 1000, 1);
    $adjustedStudentCount = $totalStudents - 1;
@endphp

<div class="relative bg-banner-four pb-16 sm:pb-24 lg:pb-[120px] pt-36 sm:pt-36 lg:pt-[220px]">
    <div class="container relative">
        @if (!empty($sliders) && is_iterable($sliders))
            <div class="swiper banner-slider">
                <div class="swiper-wrapper">
                    <!-- BANNER SLIDER ITEM -->
                    @foreach ($sliders as $slider)
                        @php
                            if ( ! $slider->status ) {
                                continue;
                            }

                            $translations = parse_translation($slider);
                            $buttonTranslation = $translations['buttons'] ?? [];
                            $subTitle = $translations['sub_title'] ?? $slider->sub_title ?? '';
                            $title = $translations['title'] ?? $slider->title ?? '';
                            $highlightText = $translations['highlight_text'] ?? $slider->highlight_text ?? '';
                            $description = $translations['description'] ?? $slider->description ?? '';
                            $button = $slider->buttons ?? [];
                            $sliderImg = $slider->image ?? '';
                            $thumbnail =
                                $sliderImg && fileExists('lms/sliders', $sliderImg) == true
                                    ? asset("storage/lms/sliders/{$sliderImg}")
                                    : asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
                        @endphp
                        <div class="swiper-slide">
                            <div class="grid grid-cols-12 gap-7 items-center">
                                <div class="col-span-full lg:col-span-7">
                                    @if ($subTitle)
                                        <div class="area-subtitle xl:text-lg subtitle-outline style-three !text-white !bg-primary/10 !border-l-primary rtl:!border-r-primary">
                                            {{ $translations['sub_title'] ?? $slider->sub_title ?? '' }}
                                        </div>
                                    @endif
                                    @if( $title )
                                    <h1 class="area-title title-lg text-white mt-2">
                                        {{ $title }}
                                        @if ($highlightText)
                                            <span class="outline-text">{{ $highlightText }}</span>
                                        @endif
                                    </h1>
                                    @endif
                                    @if($description)
                                    <p
                                        class="area-description desc-lg text-white/70 mt-1.5 xl:mt-2.5 sm:pr-20 line-clamp-3">
                                        {{ $description }}
                                    </p>
                                    @endif
                                    @if (!empty($button))
                                        <div class="mt-10">
                                            <a href="{{ $button['link'] ?? '#' }}" aria-label="Hero call to action"
                                                class="btn b-solid btn-primary-solid btn-lg !text-heading !text-base font-bold shrink-0">
                                                {{ $buttonTranslation['name'] ?? $button['name'] ?? '' }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-span-full lg:col-span-5 hidden lg:block">
                                    <div class="max-w-full max-h-full flex items-end justify-end">
                                        <img data-src="{{ $thumbnail }}" alt="Banner image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- SWIPER PAGINATION -->
            <div class="absolute size-max top-1/2 -translate-y-1/2 -right-[10%] rtl:right-auto rtl:-left-[10%] rotate-90 z-10 hidden min-[1536px]:block">
                <div class="banner-slider-pagination swiper-custom-pagination-two version-yellow"></div>
            </div>
        @endif
    </div>
    <!-- POSITIONAL STUDENT LIST -->
    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 z-20 hidden md:flex-center !justify-start flex-col gap-2.5 text-center bg-white/20 backdrop-blur-sm px-4 py-5 rounded-[20px] rounded-b-none border border-b-0 border-white/20">
        <div class="text-white font-semibold">
            {{ $studentsInThousands < 1 ? $adjustedStudentCount : $studentsInThousands . translate('k') }}+
            {{ translate('Happy') }}
            {{ translate(Str::plural('Student', $totalStudents)) }}
        </div>
        <ul class="flex items-center [&>:not(:first-child)]:-ml-3 rtl:[&>:not(:first-child)]:ml-0 rtl:[&>:not(:first-child)]:-mr-3">
            @foreach ($students as $student)
                @php
                    $user = $student->userable ?? null;
                    $profileImg =
                        $user && fileExists('lms/students', $user->profile_img) == true
                            ? asset('storage/lms/students/' . $user->profile_img)
                            : asset('lms/frontend/assets/images/370x396.svg');
                @endphp
                <li class="size-9 rounded-50 overflow-hidden flex-center bg-primary border-2 border-white ">
                    <img data-src="{{ $profileImg }}" alt="student" class="size-full object-cover">
                </li>
            @endforeach
            <li class="size-9 rounded-50 overflow-hidden flex-center bg-primary border-2 border-white">
                <i class="ri-add-line text-heading"></i>
            </li>
        </ul>
    </div>
    <!-- POSITIONAL ELEMENTS -->
    <ul>
        <!-- TOP LEFT -->
        <li class="block size-[20vw] rounded-50 bg-[#94EB1A]/50 blur-[200px] absolute -top-[16%] -left-[8%]"></li>
        <!-- BOTTOM LEFT -->
        <li class="hidden xl:block absolute bottom-0 left-0 rtl:left-auto rtl:right-0 rtl:rotate-y-180">
            <img data-src="{{ asset('lms/frontend/assets/images/banner/home-four/dot-plane.svg') }}" alt="plane">
        </li>
    </ul>
</div>
