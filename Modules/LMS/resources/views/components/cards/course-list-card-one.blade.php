<!-- single item -->
@php
    $reviews = review($course);
    $thumbnail =
        $course->thumbnail && fileExists('lms/courses/thumbnails', $course->thumbnail) == true
            ? asset("storage/lms/courses/thumbnails/{$course->thumbnail}")
            : asset('lms/frontend/assets/images/420x252.svg');

    $translations = $translations ?? parse_translation($course);
    $categoryTranslations = parse_translation($course->category);

    $currency = $course?->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);

@endphp
<div class="col-span-full md:col-span-6 group-data-[card-layout=list]:!col-span-full">
    <div
        class="flex flex-col bg-white rounded-2xl p-5 h-full card-border sm:group-data-[card-layout=list]:flex-row [&.card-border]:border [&.card-border]:border-border [&.card-border]:hover:shadow-md custom-transition group/course">
        <!-- COURSE THUMBNAIL -->
        <div class="relative aspect-video sm:group-data-[card-layout=list]:max-w-52 rounded-xl overflow-hidden shrink-0">
            <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
                class="size-full object-cover group-hover/course:scale-110 custom-transition">
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
            <!-- badge -->
            @foreach ($course->levels as $level)
                @php
                    $levelTranslation = parse_translation($level);
                @endphp
                <span
                    class="badge b-solid badge-secondary-solid rounded-full !text-heading dark:text-white absolute top-4 left-4 rtl:left-auto rtl:right-4 z-10">
                    {{ $levelTranslation['name'] ?? ($level->name ?? '') }}</span>
            @endforeach
        </div>
        <div
            class="mt-6 sm:group-data-[card-layout=list]:mt-0 sm:group-data-[card-layout=list]:ml-6 rtl:sm:group-data-[card-layout=list]:ml-0 rtl:sm:group-data-[card-layout=list]:mr-6 grow">
            <div class="flex-center-between">
                <div class="badge badge-heading-outline b-outline rounded-full shrink-0">
                    {{ $categoryTranslations['title'] ?? $course?->category?->title }}
                </div>
                @if ($course?->courseSetting?->is_free)
                    <div
                        class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center gap-1.5">
                        <span>{{ translate('Free') }}</span>
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
                                <del
                                    class="text-heading/50 text-[16px] font-semibold">{{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}</del>
                            </span>
                        @else
                            <span>{{ $currencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}</span>
                        @endif
                    </div>
                @endif
            </div>
            <h6 class="area-title font-bold !text-xl mt-3 group-hover/course:text-primary custom-transition">
                <a href="{{ route('course.detail', $course->slug) }}" class="line-clamp-2" aria-label="Course title">
                    {{ $translations['title'] ?? ($course->title ?? '') }}</a>
            </h6>

            @if (!isset($isComing))
                <div class="flex items-center gap-2 mt-3">
                    <div class="flex items-center gap-0.5 text-secondary">
                        {!! show_rating($reviews['average_rating']) !!}
                    </div>
                    <p class="area-description text-sm !leading-none">
                        ({{ dotZeroRemove($reviews['average_rating']) ?? 0 }} {{ translate('Rating') }})
                    </p>

                </div>
            @endif

            <div class="flex-center-between gap-2 pt-4 mt-6 border-t border-heading/10">
                <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                    <i class="ri-time-line"></i>
                    <span>{{ $course->duration }} </span>
                </div>
                <div class="flex items-center gap-4 shrink-0">
                    <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                        <i class="ri-book-line"></i>
                        <span>{{ $course?->chapters?->count() ?? 0 }} {{ translate('Lessons') }} </span>
                    </div>

                    @if (!isset($isComing))
                        <div class="flex items-center gap-1 area-description text-sm !leading-none shrink-0">
                            <i class="ri-group-line"></i>
                            <span> {{ $course?->totalPurchases?->count() ?? 0 }} {{ translate('Student') }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
