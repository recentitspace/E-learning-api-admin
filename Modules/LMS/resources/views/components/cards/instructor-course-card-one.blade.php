@foreach ($courses as $course)
    <!-- single item -->
    @php
        $reviews = review($course);
        $imagePath = 'lms/courses/thumbnails';
        $defaultThumbnail = 'lms/frontend/assets/images/420x252.svg';
        $thumbnail =
            $course?->thumbnail && fileExists($imagePath, $course->thumbnail)
                ? asset('storage/' . $imagePath . '/' . $course->thumbnail)
                : asset($defaultThumbnail);
    @endphp

    <div
        class="xl:col-span-4 sm:col-span-6 col-span-full card rounded-2xl shadow-courseCard overflow-hidden group/topCourse">
        <!-- card thumbnail -->
        <div class="overflow-hidden relative">
            <!-- main thumbnail -->
            <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
                class="w-full group-hover/topCourse:scale-110 duration-200">
        </div>
        <!-- card body -->
        <div class="p-4 pb-6">
            <!-- badge -->
            <div class="flex gap-2">
                <span class="badge">{{ $course?->category?->title }}</span>
                <span class="badge bg-[#47C363]">{{ $course->duration }}</span>
            </div>
            <!-- rating -->
            <div class="py-2 flex gap-2 items-center font-medium">

                @if ($reviews['average_rating'])
                    <span class="mt-1">{{ $reviews['average_rating'] }}</span>
                @endif

                <div class="flex items-center space-x-1 xl:text-lg text-[#F4B718]">
                    {!! show_rating($reviews['total_rating']) !!}
                </div>
            </div>
            <a href="{{ route('course.detail', $course->slug) }}" aria-label="Course title">
                <h3 class="course-title text-lg">{{ $course->title }}</h3>
            </a>
        </div>
    </div>
@endforeach
