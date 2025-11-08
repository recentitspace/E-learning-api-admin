@php
    $upcomingCourses = $upcomingCourses ?? [];
    $totalCourses = count($upcomingCourses);

    $courseRoute = '';
    $courseBtnText = '';

    if ($totalCourses > 0) {
        $courseRoute = route('course.list', ['upcoming' => true]);
        $courseBtnText = 'View Upcoming Course';
    }

    if (isAdmin() && $totalCourses < 1) {
        $courseRoute = route('course.create');
        $courseBtnText = 'Add Course';
    }
@endphp

<div class="bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle">
                    {{ translate('Upcoming Courses') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Our Upcoming') }}
                    <span class="title-highlight-one">
                        {{ translate('Courses') }}
                    </span>
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper up-coming-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                <x-theme::cards.course-card-one isComing="true" :courses="$upcomingCourses" />
            </div>
        </div>

        @if ($courseRoute && $courseBtnText)
            <div class="flex-center mt-10 lg:mt-[60px]">
                <a href="{{ $courseRoute }}" title="{{ $courseBtnText }}"
                    class="btn b-outline btn-primary-outline btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                    aria-label="{{ $courseBtnText }}">
                    {{ translate($courseBtnText) }}
                    <span class="hidden md:block">
                        <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                    </span>
                </a>
            </div>
        @endif
    </div>
</div>
