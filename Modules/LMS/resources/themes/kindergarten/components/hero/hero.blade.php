@php
    $hero = get_theme_hero('kindergarten');
    $sliders = $hero->sliders ?? [];
    $students = get_all_student('3') ?? [];
    $totalStudents = get_all_student()?->count() ?? 0;
    $studentsInThousands = number_format($totalStudents / 1000, 1);
    $adjustedStudentCount = $totalStudents - 1;
@endphp

@if (count($sliders) > 0)
    <div class="relative bg-gradient-to-b from-[#FEFBF0] to-[#E6F3EB] overflow-hidden">
        <div class="container">
            <div class="swiper banner-slider">
                <div class="swiper-wrapper">
                    <!-- SINGLE SLIDER ITEM -->
                    @foreach ($sliders as $slider)
                        @php
                            if (!$slider->status) {
                                continue;
                            }

                            $translations = parse_translation($slider);
                            $buttonTranslations = $translations['buttons'] ?? [];
                            $subTitle = $translations['sub_title'] ?? ($slider->sub_title ?? '');
                            $title = $translations['title'] ?? ($slider->title ?? '');
                            $highlightText = $translations['highlight_text'] ?? ($slider->highlight_text ?? '');
                            $description = $translations['description'] ?? ($slider->description ?? '');
                            $button = $slider->buttons ?? [];
                            $sliderImg = $slider->image ?? '';
                            $thumbnail =
                                $sliderImg && fileExists('lms/sliders', $sliderImg) == true
                                    ? asset("storage/lms/sliders/{$sliderImg}")
                                    : asset('lms/frontend/assets/images/banner/banner_image_3.svg');
                        @endphp
                        <div class="swiper-slide">
                            <div class="grid grid-cols-12 gap-7 items-center pt-24 pb-48 xl:pt-40 xl:pb-56">
                                <div class="col-span-full lg:col-span-7 xl:col-span-6 xl:pr-10">
                                    @if ($title)
                                        <h1 class="area-title title-lg">
                                            {{ $title }}
                                            @if ($highlightText)
                                                <span class="title-highlight-two">{{ $highlightText }}</span>
                                            @endif
                                        </h1>
                                    @endif
                                    @if ($description)
                                        <p
                                            class="area-description desc-lg mt-1 xl:mt-2.5 sm:pr-20 rtl:sm:pr-0 rtl:sm:pl-20">
                                            {{ $description }}</p>
                                    @endif
                                    @if (!empty($button))
                                        <a href="{{ $button['link'] ?? '#' }}" aria-label="Hero call to action"
                                            class="btn b-solid btn-primary-solid btn-lg !rounded-full !text-[16px] !px-6 font-medium mt-8">
                                            {{ $buttonTranslations['name'] ?? ($button['name'] ?? '') }}
                                        </a>
                                    @endif
                                    <!-- TRUSTED STUDENT LIST -->
                                    @if (count($students) > 0)
                                        <div class="flex items-center gap-2.5 mt-8">
                                            <ul
                                                class="flex items-center [&>:not(:first-child)]:-ml-3 rtl:[&>:not(:first-child)]:ml-0 rtl:[&>:not(:first-child)]:-mr-3">
                                                @foreach ($students as $student)
                                                    @php
                                                        $user = $student->userable ?? null;
                                                        $profileImg =
                                                            $user &&
                                                            fileExists('lms/students', $user->profile_img) == true
                                                                ? asset('storage/lms/students/' . $user->profile_img)
                                                                : asset('lms/frontend/assets/images/370x396.svg');
                                                    @endphp
                                                    <li
                                                        class="size-10 rounded-50 overflow-hidden flex-center bg-primary border-2 border-white">
                                                        <img data-src="{{ $profileImg }}" alt="student">
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="text-heading font-semibold">
                                                {{ translate('Joined') }}
                                                <span class="text-primary">
                                                    {{ $studentsInThousands < 1 ? $adjustedStudentCount : $studentsInThousands . translate('k') }}+
                                                </span>
                                                {{ translate(Str::plural('Student', $totalStudents)) }}
                                                {{ translate('already') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-span-full lg:col-span-5 xl:col-span-6 hidden lg:block justify-self-end">
                                    <div
                                        class="flex items-center justify-end relative before:absolute before:right-0 before:bottom-0 before:size-[110%] xl:before:h-[115%] before:bg-[url('/lms/frontend/assets/images/banner/home-five/brush-bg.png')] before:bg-no-repeat before:bg-cover before:bg-center">
                                        <div
                                            class="aspect-square max-w-[550px] image-mask mask-banner-thumb overflow-hidden">
                                            <img data-src="{{ $thumbnail }}" alt="Hero banner"
                                                class="size-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- POSITIONAL ELEMENT -->
        <ul>
            <!-- TOP LEFT -->
            <li
                class="block size-[29vw] rounded-50 bg-[#D2EB1A]/15 blur-[200px] absolute top-0 xl:-top-20 left-0 xl:-left-20 z-0">
            </li>
            <!-- TOP RIGHT -->
            <li
                class="block size-[29vw] rounded-50 bg-[#B326F4]/15 blur-[200px] absolute top-0 xl:-top-20 right-0 xl:-right-20 z-0">
            </li>
            <!-- BOTTOM RIGHT -->
            <li class="absolute bottom-0 right-0 rtl:right-auto rtl:left-0 z-0"><img
                    data-src="{{ asset('lms/frontend/assets/images/banner/home-five/color-paint.png') }}"
                    alt="color paint"></li>
        </ul>
    </div>
@endif
