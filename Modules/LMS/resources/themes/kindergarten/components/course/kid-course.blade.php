@php 
    $courses = $courses ?? [];
    $courseCategories = $courseCategories ?? [];
@endphp

<div class="relative py-16 sm:py-24 lg:py-[120px] bg-gradient-to-b from-[#FEFBF0] to-[#E6F3EB] mt-16 sm:mt-24 lg:mt-[120px] overflow-hidden">
    <div class="container relative z-[1]">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[670px] mx-auto">
                <h2 class="area-title">
                    {{ translate( 'We Engage Kids at Their Level, No Matter' ) }}
                    <span class="title-highlight-two">{{ translate( 'Their Stage' ) }}</span>
                </h2>
            </div>
        </div>
        <!-- BODY -->
        @if( count( $courses ) > 0 )
            <div class="swiper child-course-slider mt-10 lg:mt-[60px]">
                <div class="swiper-wrapper">
                    <!-- SINGLE CHILD COURSE CARD -->
                    @foreach( $courses as $course )
                        <div class="swiper-slide">
                            <x-theme::cards.course.card-five :course="$course" />
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- SWIPER PAGINATION -->
            <div class="flex-center mt-10 lg:mt-[60px]">
                <div class="child-course-pagination swiper-custom-pagination"></div>
            </div>
        @endif
    </div>
    <!-- POSITIONAL ELEMENT -->
    <ul>
        <!-- TOP LEFT -->
        <li class="block size-[29vw] rounded-50 bg-[#D2EB1A]/15 blur-[200px] absolute top-0 xl:-top-20 left-0 xl:-left-20"></li>
        <li class="absolute top-32 left-[10%]"><img data-src="{{ asset( 'lms/frontend/assets/images/icons/triangle.svg' ) }}" alt="triangle"></li>
        <!-- TOP RIGHT -->
        <li class="block size-[29vw] rounded-50 bg-[#B326F4]/15 blur-[200px] absolute top-0 xl:-top-20 right-0 xl:-right-20"></li>
        <li class="absolute top-32 right-[17%]"><img data-src="{{ asset('lms/frontend/assets/images/icons/role-ab.svg') }}" alt="role-ab"></li>
        <!-- BOTTOM RIGHT -->
        <li class="absolute bottom-32 right-[12%]"><img data-src="{{ asset('lms/frontend/assets/images/icons/compas.svg') }}" alt="compass"></li>
    </ul>
</div>