<div class="bg-white relative pt-16 sm:pt-24 lg:pt-[120px] h-full">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <h2 class="area-title"> {{ translate('Our Popular Courses') }} </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper popular-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @if( !empty($courses) )
                @foreach($courses as $course)
                    @php
                        $reviews = review($course);
                        $imagePath = 'lms/courses/thumbnails';
                        $defaultThumbnail = 'lms/frontend/assets/images/420x252.svg';
                        $thumbnail =
                            !empty($course?->thumbnail) && fileExists($imagePath, $course->thumbnail)
                                ? asset('storage/' . $imagePath . '/' . $course->thumbnail)
                                : asset($defaultThumbnail);
                    @endphp
                    <x-theme::cards.course.card-three :course="$course" :thumbnail="$thumbnail" :reviews="$reviews" />
                @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- ALL COURSE LINK -->
    <div class="flex-center mt-10 lg:mt-[60px]">
        <a
            href="{{ route('course.list') }}"
            class="btn b-outline btn-primary-outline btn-xl !rounded-none font-bold"
            aria-label="View all courses"
        >
            {{ translate('View Courses') }}
        </a>
    </div>
</div>
