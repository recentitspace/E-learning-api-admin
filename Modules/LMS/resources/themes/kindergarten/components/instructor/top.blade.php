@php
    $instructors = $instructors ?? [];
@endphp

<div class="relative py-16 sm:py-24 lg:py-[120px] bg-gradient-to-b from-[#FEFBF0] to-[#E6F3EB] mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container relative z-[1]">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-6 lg:pr-20">
                <h2 class="area-title">
                    {{ translate( 'Meet Our Top Creative' ) }}
                    <span class="title-highlight-two">{{ translate( 'School Instructors' ) }}</span>
                </h2>
            </div>
            <div class="col-span-full md:col-span-6 md:justify-self-end">
                <a href="{{ route('instructor.list') }}" aria-label="See All Teacher" class="btn b-solid btn-primary-solid btn-lg !text-base !px-8 !rounded-full font-bold">
                    {{ translate( 'See All Teacher' ) }}
                </a>
            </div>
        </div>
        <!-- BODY -->
        @if( count( $instructors ) > 0 )
            <div class="swiper instructor-slider mt-10 lg:mt-[60px]">
                <div class="swiper-wrapper">
                    <!-- SINGLE INSTRUCTOR CARD -->
                    @foreach( $instructors as $instructor )
                        <x-theme::cards.instructor.card-five :instructor="$instructor" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>