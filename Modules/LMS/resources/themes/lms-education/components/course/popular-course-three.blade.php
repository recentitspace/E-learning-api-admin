<!-- START POPULAR COURSE AREA -->
<div class="bg-white relative py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div class="area-subtitle subtitle-outline style-two text-sm uppercase" >
                    {{ translate('Popular Courses') }}
                </div>
                <h2 class="area-title mt-1">
                    {{ translate('Explore Our Popular Courses') }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 md:justify-self-end">
                <a
                    href="{{ route('course.list') }}" aria-label="View All Courses"
                    class="btn b-solid btn-primary-solid btn-xl font-bold"
                >
                    {{ translate('View All Courses') }}
                </a>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper popular-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach( $courses as $course )
                    <x-theme::cards.course.card-three-popular :course="$course" />
                @endforeach  
            </div>
        </div>
    </div>
</div>
<!-- END POPULAR COURSE AREA -->