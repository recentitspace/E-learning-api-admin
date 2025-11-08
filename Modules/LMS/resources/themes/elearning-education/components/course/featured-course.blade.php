<div class="relative bg-primary-50 py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 lg:pr-20 rtl:lg:pr-0 rtl:lg:pl-20">
                <h2 class="area-title mt-2">{{ translate('Our Featured Courses') }}</h2>
            </div>
            <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button type="button" aria-label="Course slider previous" class="slider-navigation style-two featured-courses-prev">
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button type="button" aria-label="Course slider next" class="slider-navigation style-two featured-courses-next">
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        <div
            class="swiper featured-course-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                {{-- Course Slider Card  --}}
                @foreach( $courses as $course )
                    <x-theme::cards.course.card-two :course="$course" />
                @endforeach
            </div>
        </div>
    </div>
</div>
