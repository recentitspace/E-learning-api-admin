@php $courses = $courses ?? []; @endphp

<div class="relative bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">{{ translate( 'New Courses' ) }}</div>
                <h2 class="area-title mt-2">
                    {{ translate( 'Our New Courses' ) }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button type="button" aria-label="Course slider button previous" class="slider-navigation style-two hover:!text-heading !rounded-md new-courses-prev">
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button type="button" aria-label="Course slider button next" class="slider-navigation style-two hover:!text-heading !rounded-md new-courses-next">
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        @if( !empty( $courses ) && is_iterable( $courses ) )
        <div class="swiper new-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                <!-- COURSE CARD -->
                @foreach( $courses as $course )
                <div class="swiper-slide">
                    <x-theme::cards.course.card-four :course="$course" card-bg="bg-section" />
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="bg-white border border-border rounded-xl h-[400px] shadow-md">
            <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
                <h2 class="area-title xl:text-3xl">{{ translate( 'Oops, Nothing Here Yet!' ) }}</h2>
                <p class="area-description">
                    {{ translate( "It looks like we don't have any courses in this category right now. Feel free to browse other categories or let us know if there's something specific you'd like to learn!" ) }}
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
