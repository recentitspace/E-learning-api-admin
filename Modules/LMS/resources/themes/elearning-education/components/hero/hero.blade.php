@php
    $hero = get_theme_hero('elearning-education');
    $sliders = $hero->sliders ?? [];
    $totalStudents = get_all_student()?->count() ?? 0;
    $studentsInThousands = number_format($totalStudents / 1000, 1);
    $adjustedStudentCount = $totalStudents - 1;
@endphp

<!-- START BANNER AREA -->
@if( is_iterable( $sliders ) )
    <div class="relative bg-heading overflow-hidden">
        <div class="mx-[12px]">
            <div class="relative bg-[#1B253A] max-w-[1600px] mx-auto mb-28 overflow-hidden">
                <div class="container">
                    <div class="swiper banner-slider">
                        <div class="swiper-wrapper">
                            @foreach( $sliders as $slider )  
                                @php
                                    if ( ! $slider->status ) {
                                        continue;
                                    }
                                    
                                    $translations = parse_translation($slider);
                                    $title = $translations['title'] ?? $slider->title ?? '';
                                    $description = $translations['description'] ?? $slider->description ?? '';
                                    $translationButton = $translations['buttons'] ?? [];
                                    $button = $slider->buttons ?? [];
                                    $sliderImg = $slider->image ?? '';
                                    $thumbnail = $sliderImg && fileExists('lms/sliders', $sliderImg) == true ?
                                                asset("storage/lms/sliders/{$sliderImg}") :
                                                asset('lms/frontend/assets/images/banner/banner_placeholder_2.svg');
                                @endphp
                                <!-- SINGLE SLIDER ITEM -->
                                <div class="swiper-slide">
                                    <div class="grid grid-cols-12 gap-7 items-center py-20 lg:pb-[120px]">
                                        <div class="col-span-full lg:col-span-7">
                                            @if( !empty( $button ) )
                                            <div class="md:pr-20 xl:p-0">
                                                @if( $title )
                                                    <h1 class="area-title title-lg text-white">{{ $title }}</h1>
                                                @endif
                                                @if($description)
                                                    <p class="area-description desc-lg text-white/70 mt-2 xl:mt-5 sm:pr-20 rtl:sm:pr-0 rtl:sm:pl-20">{{ $description }}</p>
                                                @endif
                                                <a href="{{ $button['link'] ?? '#' }}" aria-label="Hero call to action" class="btn b-solid btn-primary-solid btn-lg !text-[16px] !rounded-none font-bold mt-7">
                                                    {{ $translationButton['name'] ?? $button['name'] ?? '' }}
                                                </a>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-span-full lg:col-span-5 hidden lg:block">
                                            <div class="aspect-[1/1.04] max-w-[450px] mx-auto bg-primary border-2 border-white shadow-secondary">
                                                <img data-src="{{ $thumbnail }}" alt="Banner image"  class="size-full object-cover" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- POSITIONAL STUDENT LIST -->
                <div class="absolute -bottom-32 left-1/2 lg:left-1/3 rtl:lg:right-1/3 z-10 hidden sm:flex-center !justify-start flex-col gap-2.5 text-center bg-heading px-4 py-10 size-64 rounded-50 border border-white/15 border-b-0">
                    <ul class="flex items-center [&>:not(:first-child)]:-ml-3 rtl:[&>:not(:first-child)]:ml-0 rtl:[&>:not(:last-child)]:-ml-3">
                        @php
                            $students = get_all_student('4');
                        @endphp
                        @foreach( $students as $student )
                            @php
                                $user= $student->userable ?? null;
                                $profileImg=  $user && fileExists('lms/students', $user->profile_img) == true ? 
                                    asset("storage/lms/students/{$user->profile_img}"):
                                    asset('lms/frontend/assets/images/370x396.svg')
                            @endphp
                            <li class="size-9 rounded-50 overflow-hidden flex-center bg-primary border-2 border-heading ">
                                <img data-src="{{$profileImg }}" class="size-full object-cover" alt="student">
                            </li>
                        @endforeach
                        <li class="size-9 rounded-50 overflow-hidden flex-center bg-primary border-2 border-heading">
                            <i class="ri-add-line text-white"></i>
                        </li>
                    </ul>
                    <div class="text-white font-semibold">
                        {{ $studentsInThousands < 1 ? $adjustedStudentCount : $studentsInThousands . translate('k') }}+
                        {{ translate('Happy') }}
                        {{ translate(Str::plural('Student', $totalStudents)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- END BANNER AREA -->