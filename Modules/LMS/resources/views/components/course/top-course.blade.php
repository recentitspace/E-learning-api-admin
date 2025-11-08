@php
    $courses = $courses ?? [];
    $totalCourses = count($courses);

    $courseRoute = '';
    $courseBtnText = '';

    if ($totalCourses > 0) {
        $courseRoute = 'course.list';
        $courseBtnText = 'View all course';
    }

    if (isAdmin() && $totalCourses < 1) {
        $courseRoute = 'course.create';
        $courseBtnText = 'Add Course';
    }
@endphp


<div class="relative bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                <div class="area-subtitle">
                    {{ translate('Popular Course') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('See Our Popular') }}
                    <span class="title-highlight-one">
                        {{ translate('Courses') }}
                    </span>
                </h2>
            </div>

            @if ($courseRoute && $courseBtnText)
                <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                    <a href="{{ route($courseRoute) }}" title="{{ $courseBtnText }}"
                        class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                        aria-label="{{ $courseBtnText }}">
                        {{ translate($courseBtnText) }}
                        <span class="hidden md:block">
                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                        </span>
                    </a>
                </div>
            @endif
        </div>
        <!-- BODY -->
        <div class="swiper popular-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                <x-theme::cards.course-card-one :courses="$courses" />
            </div>
        </div>
    </div>
    <!-- SWIPER PAGINATION -->
</div>
