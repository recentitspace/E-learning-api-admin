@php
    if (!$course) {
        return;
    }

    $currency = $course?->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);

    $translations = $translations ?? parse_translation($course);
    $badgeText = $course?->courseSetting?->is_free
        ? translate('Free')
        : (isset($course?->coursePrice) &&
        $course?->coursePrice?->discount_flag == 1 &&
        $course?->coursePrice?->discount_period != '' &&
        dateCompare($course?->coursePrice?->discount_period)
            ? $currencySymbol . dotZeroRemove($course?->coursePrice?->discounted_price ?? 0)
            : $currencySymbol . dotZeroRemove($course?->coursePrice?->price ?? 0));

    $coursePrice = $course->coursePrice ?? null;

    $imagePath = 'lms/courses/thumbnails';
    $defaultThumbnail = 'lms/frontend/assets/images/370x396.svg';
    $thumbnail =
        !empty($course?->thumbnail) && fileExists($imagePath, $course->thumbnail)
            ? asset('storage/' . $imagePath . '/' . $course->thumbnail)
            : asset($defaultThumbnail);
@endphp

<div class="swiper-slide">
    <div class="relative flex-center aspect-[1/1.16] overflow-hidden custom-transition group/course">
        <!-- PRICE -->
        <div
            class="badge b-solid badge-primary-solid font-bold rounded-none absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">
            {{ $badgeText }}
        </div>
        <!-- THUMBNAIL -->
        <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
            class="size-full object-cover object-left group-hover/course:scale-110 custom-transition">
        <!-- CONTENT -->

        @auth
            @php
                $class = user_wishlist_check($course->id) ? 'active' : '';
            @endphp
            <label for="course_{{ $course->id }}"
                class="flex-center absolute top-3 end-3 size-9 rounded-50 bg-white cursor-pointer select-none z-[1] add-wishlist group/wishlist {{ $class }}"
                data-id="{{ $course->id }}">
                <input type="checkbox" id="course_{{ $course->id }}"
                    class="appearance-none flex-center before:font-remix before:content-['\ee0f'] before:leading-none before:text-heading group-[.active]/wishlist:before:text-primary before:text-xl group-[.active]/wishlist:before:content-['\ee0e'] cursor-pointer">
            </label>
        @else
            <label for="course_{{ $course->id }}"
                class="flex-center absolute top-3 end-3 size-9 rounded-50 bg-white cursor-pointer select-none z-[1]"
                data-id="{{ $course->id }}">
                <a href="{{ route('auth.login') }}" id="course_{{ $course->id }}"
                    class="appearance-none flex-center before:font-remix before:content-['\ee0f'] before:leading-none before:text-heading before:text-xl checked:before:content-['\ee0e'] cursor-pointer">
                </a>
            </label>
        @endauth
        <div
            class="absolute right-0 bottom-0 translate-y-full group-hover/course:translate-y-0 left-0 p-7 pt-10 bg-heading overflow-hidden shrink-0 custom-transition">
            <h5 class="area-title text-lg text-white font-bold !leading-[1.44] text-center line-clamp-2">
                <a href="{{ route('course.detail', $course->slug) }}" aria-label="Course details link">
                    {{ $translations['title'] ?? ($course->title ?? '') }}
                </a>
            </h5>
            <div class="flex-center-between h-9 gap-4 bg-primary px-3.5 py-2 mt-4">
                <div class="flex items-center gap-1 area-description text-white text-sm !leading-none shrink-0">
                    <i class="ri-book-line"></i>
                    <span> {{ $course->chapters?->count() ?? 0 }} {{ translate('Lessons') }} </span>
                </div>
                <div class="flex items-center gap-1 area-description text-white text-sm !leading-none shrink-0">
                    <i class="ri-group-line"></i>
                    <span>
                        {{ $course->students?->count() ?? 0 }} {{ translate('Students') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
