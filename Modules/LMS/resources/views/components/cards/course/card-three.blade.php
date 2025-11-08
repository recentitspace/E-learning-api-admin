@php
    if (!$course) {
        return;
    }
    $translations = $translations ?? parse_translation($course);
    $categoryTranslations = parse_translation($course->category);

    $currency = $course?->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp
<div class="swiper-slide">
    <div class="flex flex-col bg-white h-full custom-transition group/course">
        <!-- COURSE THUMBNAIL -->
        <div class="relative aspect-[1.64] overflow-hidden shrink-0">
            <img data-src="{{ $thumbnail }}"
                class="course-grid-thumb-img w-full group-hover/topCourse:scale-110 duration-300"
                alt="Course thumbnail" />

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
        <div class="px-5 py-6 border border-border border-t-0 grow">
            <div class="flex items-center flex-wrap gap-2 xl:gap-4">
                <div class="badge badge-primary-light rounded-none shrink-0">
                    {{ $categoryTranslations['title'] ?? ($course->category->title ?? '') }}
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0 ms-auto">
                    <i class="ri-time-line"></i>
                    <span>
                        {{ $course->duration ?? 0 }}
                    </span>
                </div>
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-group-line"></i>
                    <span>{{ $course?->totalPurchases?->count() ?? 0 }} {{ translate('Student') }}</span>
                </div>
            </div>
            <h6 class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                <a href="{{ route('course.detail', $course->slug) }}" aria-label="Course title" class="line-clamp-2">
                    {{ $translations['title'] ?? ($course->title ?? '') }}
                </a>
            </h6>

            @foreach ($course->instructors as $instructor)
                @php
                    $user = $instructor->userable ?? null;
                    $userTranslations = parse_translation($user);
                @endphp
                <a href="{{ route('users.detail', $instructor->id) }}" aria-label="Course instructor profile info"
                    class="flex items-center gap-2 area-title text-base font-semibold !leading-none shrink-0 mt-5">
                    <div class="size-7 rounded-50 overflow-hidden">
                        @php
                            $imagePath = 'lms/instructors';
                            $defaultThumbnail = 'lms/assets/images/placeholder/profile.jpg';
                            $thumbnail =
                                $user?->profile_img && fileExists($imagePath, $user->profile_img)
                                    ? asset('storage/' . $imagePath . '/' . $user->profile_img)
                                    : asset($defaultThumbnail);
                        @endphp
                        <img data-src="{{ $thumbnail }}" alt="Instructor profile" class="size-full object-cover" />
                    </div>
                    <span>{{ $userTranslations['first_name'] ?? ($user->first_name ?? '') }}</span>
                </a>
            @endforeach

            <div class="flex-center-between gap-2 pt-4 mt-6 border-t border-heading/10">
                <div class="flex items-center gap-2">
                    <div class="flex items-center gap-0.5 text-secondary">
                        {!! show_rating($reviews['average_rating']) !!}
                    </div>
                    <p class="area-description text-sm !leading-none">
                        @if ($reviews['total_rating'])
                            ({{ dotZeroRemove($reviews['average_rating']) ?? 0 }})
                        @endif
                    </p>
                </div>
                <div class="text-heading text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                    @if ($course?->courseSetting?->is_free)
                        <div
                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                            <span>
                                {{ translate('Free') }}
                            </span>
                        </div>
                    @else
                        <div
                            class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                            @if (isset($course?->coursePrice) &&
                                    $course?->coursePrice?->discount_flag == 1 &&
                                    $course?->coursePrice?->discount_period != '' &&
                                    dateCompare($course?->coursePrice?->discount_period) == true)
                                <span>{{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->discounted_price ?? 0) }}</span>
                                <span>
                                    <del class="text-heading/50 text-[16px] font-semibold">
                                        {{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}
                                    </del>
                                </span>
                            @else
                                <span>{{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
