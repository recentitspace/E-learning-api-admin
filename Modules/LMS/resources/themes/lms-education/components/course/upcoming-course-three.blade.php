<!-- START UPCOMING COURSE AREA -->
<div class="relative bg-[#EFF4E0] py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div class="area-subtitle subtitle-outline style-two text-sm uppercase">
                    {{ translate('Upcoming Courses') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('See Our Upcoming Courses') }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="slider-navigation style-two !rounded-md featured-courses-prev"
                        aria-label="Previous course slider button"
                    >
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button
                        type="button"
                        class="slider-navigation style-two !rounded-md featured-courses-next"
                        aria-label="Next course slider button"
                    >
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper featured-course-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach( $courses as $course )
                    <x-theme::cards.course.upcoming-card-three :course="$course" />
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- END UPCOMING COURSE AREA --
