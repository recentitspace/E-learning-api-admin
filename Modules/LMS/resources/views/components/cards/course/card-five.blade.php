@php
    if (!$course) {
        return;
    }
    $reviews = review($course);
    $imagePath = 'lms/courses/thumbnails';
    $thumbnail =
        !empty($course?->thumbnail) && fileExists($imagePath, $course->thumbnail)
            ? asset("storage/{$imagePath}/{$course->thumbnail}")
            : asset('lms/frontend/assets/images/420x252.svg');

    $translations = $translations ?? parse_translation($course);
@endphp

<div class="flex flex-col bg-white h-full hover:bg-primary px-5 py-6 image-mask mask-kid-course-wrapper custom-transition duration-300 group/kid-course">
    <!-- COURSE THUMBNAIL -->
    <div class="relative aspect-video image-mask mask-kid-course-thumb overflow-hidden shrink-0">
        <img data-src="{{ $thumbnail }}" alt="Course Thumbnail"
            class="size-full object-cover group-hover/kid-course:scale-110 custom-transition">
        @auth
            @php
                $class = user_wishlist_check($course->id) ? 'active' : '';
            @endphp
            <label for="course_{{ $course->id }}"
                class="flex-center absolute top-5 xl:top-7 end-8 xl:end-10 size-10 rounded-50 bg-white cursor-pointer select-none z-[1] add-wishlist group/wishlist {{ $class }}"
                data-id="{{ $course->id }}">
                <input type="checkbox" id="course_{{ $course->id }}"
                    class="appearance-none flex-center before:font-remix before:content-['\ee0f'] before:leading-none before:text-heading group-[.active]/wishlist:before:text-primary before:text-xl group-[.active]/wishlist:before:content-['\ee0e'] cursor-pointer">
            </label>
        @else
            <label for="course_{{ $course->id }}"
                class="flex-center absolute top-5 xl:top-7 end-8 xl:end-10 size-10 rounded-50 bg-white cursor-pointer select-none z-[1]"
                data-id="{{ $course->id }}">
                <a href="{{ route('auth.login') }}" id="course_{{ $course->id }}"
                    class="appearance-none flex-center before:font-remix before:content-['\ee0f'] before:leading-none before:text-heading before:text-xl checked:before:content-['\ee0e'] cursor-pointer">
                </a>
            </label>
        @endauth
    </div>
    <!-- COURSE CONTENT -->
    <div class="px-8 pb-5 mt-6 flex-center flex-col text-center grow">
        <h6
            class="area-title font-bold !text-xl group-hover/kid-course:text-white duration-300 hover:!text-heading custom-transition">
            <a href="{{ route('course.detail', $course->slug) }}" class="line-clamp-1"
                aria-label="Course category link">
                {{ $translations['title'] ?? ($course->title ?? '') }}
            </a>
        </h6>
        <div class="area-description group-hover/kid-course:text-white duration-300 line-clamp-3 mt-2.5">
            {!! clean($translations['description'] ?? ($course->description ?? '')) !!}
        </div>
        <a href="{{ route('course.detail', $course->slug) }}" aria-label="Course details link"
            class="btn b-outline btn-primary-outline px-6 group-hover/kid-course:bg-white hover:!text-heading !font-semibold rounded-full mt-6">
            {{ translate('See Details') }}
        </a>
    </div>
</div>
