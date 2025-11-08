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
    $categoryTranslations = parse_translation($course->category);

    $currency = $course?->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<div class="col-span-full md:col-span-6 lg:col-span-4 h-full">
    <div class="flex flex-col h-full rounded-xl custom-transition overflow-hidden hover:shadow-md group/course {{ $cardBg ?? 'bg-white' }}">
        <!-- COURSE THUMBNAIL -->
        <div class="relative aspect-[1.71] overflow-hidden shrink-0">
            <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
                class="size-full object-cover group-hover/course:scale-110 custom-transition">
            <!-- ADD TO WISHLIST -->
            @auth
                @php
                    $class = user_wishlist_check($course->id) ? 'active' : '';
                @endphp
                <label for="course_{{ $course->id }}"
                    class="flex-center absolute top-3 end-3 size-9 rounded-50 bg-white cursor-pointer select-none z-[1] add-wishlist group/wishlist {{ $class }}"
                    data-id="{{ $course->id }}">
                    <input type="checkbox" id="course_{{ $course->id }}"
                        class="appearance-none flex-center before:font-remix before:content-['\ee0f'] before:leading-none before:text-heading group-[.active]/wishlist:before:text-secondary before:text-xl group-[.active]/wishlist:before:content-['\ee0e'] cursor-pointer">
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
        </div>
        <!-- COURSE CONTENT -->
        <div class="px-4 lg:px-5 py-6 rounded-b-xl grow">
            <div class="flex-center-between gap-2 flex-wrap">
                <div class="flex items-center gap-1.5 area-description !text-secondary text-sm !leading-none shrink-0">
                    <i class="ri-book-marked-fill"></i>
                    <span class="text-heading">{{ translate('Lesson') }} :
                        {{ $course->chapters?->count() ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-1.5 area-description !text-secondary text-sm !leading-none shrink-0">
                    <i class="ri-user-3-fill"></i>
                    <span class="text-heading">{{ translate('Student') }} :
                        {{ $course->students?->count() ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-1.5 area-description !text-secondary text-sm !leading-none shrink-0">
                    <i class="ri-graduation-cap-fill"></i>
                    <span
                        class="text-heading">{{ $categoryTranslations['title'] ?? ($course->category->title ?? '') }}</span>
                </div>
            </div>
            <h6 class="area-title font-bold !text-xl mt-5 group-hover/course:text-secondary custom-transition">
                <a href="{{ route('course.detail', $course->slug) }}" class="line-clamp-2"
                    aria-label="Course details link">
                    {{ $translations['title'] ?? ($course->title ?? '') }}
                </a>
            </h6>
            <div class="flex-center-between gap-2 pt-4 mt-6 border-t border-heading/10">
                <div class="text-heading text-xl !leading-none font-bold flex items-center flex-wrap gap-1.5">
                    @if (isset($course?->coursePrice) &&
                            $course?->coursePrice?->discount_flag == 1 &&
                            $course?->coursePrice?->discount_period != '' &&
                            dateCompare(data: $course?->coursePrice?->discount_period) == true)
                        <span>{{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->discounted_price ?? 0) }}</span>
                        <del class="text-heading/50 text-[16px] font-semibold">
                            {{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}
                        </del>
                    @else
                        <span>
                            {{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}
                        </span>
                    @endif
                </div>
                <div
                    class="size-10 flex-center border-[2.5px] border-dashed border-heading/10 rounded-50 ms-4 me-auto relative shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                        class="linear-circle size-[41px] circle-rating"
                        data-rating="{{ dotZeroRemove($reviews['average_rating']) ?? 0 }}">
                        <circle cx="20.5" cy="20.5" r="46%"></circle>
                    </svg>
                    <span
                        class="text-heading text-sm !leading-none font-bold">{{ dotZeroRemove($reviews['average_rating']) ?? 0 }}</span>
                    <span class="text-warning absolute top-[47%] -translate-y-1/2 -right-2.5">
                        <i class="ri-star-s-fill"></i>
                    </span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <a href="{{ route('course.detail', $course->slug) }}"
                        class="btn b-solid btn-primary-solid !text-heading font-bold capitalize"
                        aria-label="Buy course">
                        {{ translate('Buy course') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
