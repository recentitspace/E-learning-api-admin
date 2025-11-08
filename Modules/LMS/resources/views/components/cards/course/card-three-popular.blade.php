<!-- COURSE CARD -->
@php
    if (!$course) {
        return;
    }
    $translations = $translations ?? parse_translation($course);
    $categoryTranslations = parse_translation($course->category);
    $reviews = review($course);
    $imagePath = 'lms/courses/thumbnails';
    $defaultThumbnail = 'lms/frontend/assets/images/370x396.svg';
    $thumbnail =
        !empty($course?->thumbnail) && fileExists($imagePath, $course->thumbnail)
            ? asset('storage/' . $imagePath . '/' . $course->thumbnail)
            : asset($defaultThumbnail);

    $currency = $course?->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<div class="swiper-slide">
    <div class="flex flex-col bg-white h-full rounded-xl custom-transition overflow-hidden group/course">
        <!-- COURSE THUMBNAIL -->
        <div class="relative aspect-[1.64] overflow-hidden shrink-0">
            <img data-src="{{ $thumbnail }}" alt="Course Thumbnail"
                class="size-full object-cover group-hover/course:scale-110 custom-transition" />

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
        </div>
        <!-- COURSE CONTENT -->
        <div class="px-5 py-6 border border-border border-t-0 rounded-b-xl grow">
            <div class="flex-center-between gap-2">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-0.5 text-secondary">
                        {!! show_rating($reviews['average_rating']) !!}
                    </div>
                    <p class="area-description text-sm !leading-none">
                        {{ dotZeroRemove($reviews['average_rating']) }}
                    </p>
                </div>
                <div class="badge badge-primary-light rounded-none">
                    {{ $categoryTranslations['title'] ?? $course->category->title }}
                </div>
            </div>
            <h6 class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                <a href="{{ route('course.detail', $course->slug) }}" aria-label="Course details link"
                    class="line-clamp-2">
                    {{ $translations['title'] ?? ($course->title ?? '') }}
                </a>
            </h6>
            <div class="flex-center-between gap-2 xl:gap-4 shrink-0 mt-5">
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-time-line"></i>
                    <span>{{ $course->duration ?? 0 }}</span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-book-line"></i>
                    <span>
                        {{ $course->chapters?->count() ?? 0 }} {{ translate('Lessons') }}
                    </span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-group-line"></i>
                    <span> {{ $course->students?->count() ?? 0 }} {{ translate('Students') }} </span>
                </div>
            </div>
            <div class="flex-center-between gap-2 pt-4 mt-6 border-t border-heading/10">
                @php
                    $instructors = $course?->instructors;
                @endphp
                @if (!empty($instructors))
                    @foreach ($instructors as $instructor)
                        @php
                            $user = $instructor->userable ?? null;
                            $imagePath = 'lms/instructors';
                            $defaultThumbnail = 'lms/assets/images/placeholder/profile.jpg';
                            $thumbnail =
                                !empty($user?->profile_img) && fileExists($imagePath, $user->profile_img)
                                    ? asset('storage/' . $imagePath . '/' . $user->profile_img)
                                    : asset($defaultThumbnail);

                            $userTranslations = parse_translation($user);
                        @endphp
                        <a href="{{ route('users.detail', $instructor->id) }}"
                            aria-label="Course instructor information"
                            class="flex items-center gap-2 area-title text-base font-semibold !leading-none shrink-0">
                            <div class="size-7 rounded-50 overflow-hidden">
                                <img data-src="{{ $thumbnail }}" alt="Course instructor"
                                    class="size-full object-cover" />
                            </div>
                            <span>
                                {{ $userTranslations['first_name'] ?? ($user->first_name ?? '') }}
                                {{ $userTranslations['last_name'] ?? ($user->last_name ?? '') }}
                            </span>
                        </a>
                    @endforeach
                @endif
                <div class="text-heading text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                    @php
                        $coursePrice = $course?->coursePrice;
                        $isDiscounted =
                            isset($coursePrice) &&
                            $coursePrice->discount_flag == 1 &&
                            !empty($coursePrice->discount_period) &&
                            dateCompare($coursePrice->discount_period);
                        $finalPrice = $isDiscounted
                            ? dotZeroRemove($coursePrice->discounted_price ?? 0)
                            : dotZeroRemove($coursePrice->price ?? 0);
                        $originalPrice = $isDiscounted ? dotZeroRemove($coursePrice->price ?? 0) : null;
                    @endphp
                    <span>{{ $currencySymbol }}{{ $finalPrice }}</span>
                    @if ($originalPrice)
                        <del
                            class="text-heading/50 text-[16px] font-semibold">{{ $currencySymbol }}{{ $originalPrice }}</del>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
