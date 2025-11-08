@php
    $thumbnail =
        $course->thumbnail && fileExists('lms/courses/thumbnails', $course->thumbnail) == true
            ? asset("storage/lms/courses/thumbnails/{$course->thumbnail}")
            : asset('lms/frontend/assets/images/420x252.svg');

    $currency = $course?->coursePrice->currency ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
    $courseSetting = $course?->courseSetting ?? null;
@endphp

<div class="col-span-full lg:col-span-4">
    <div class="bg-primary-50 p-6 rounded-2xl">
        <div data-modal-id="demo-video-modal"
            class="flex-center relative cursor-pointer w-full aspect-video rounded-2xl overflow-hidden">
            <img data-src="{{ $thumbnail }}" alt="Course thumbnail" class="size-full object-cover">
            <!-- CONTROLLER -->
            <div class="flex-center size-full bg-[#D9D9D9]/30 rounded-2xl absolute inset-0 [&.hide]:invisible">
                <button type="button" aria-label="Open demo video modal button"
                    class="btn-icon size-9 b-solid btn-secondary-icon-solid !text-heading dark:text-white pulse-animation active:scale-105">
                    <i class="ri-play-fill text-base"></i>
                </button>
            </div>
        </div>
        <table class="w-full mt-7">
            <caption class="area-title text-xl text-left rtl:text-right"> {{ translate('This Course Includes') }}:
            </caption>
            <tbody class="divide-y divide-border mt-1">
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <i class="ri-time-line"></i>
                            <span class="text-heading dark:text-white mb-0.5"> {{ translate('Duration') }} </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading dark:text-white font-semibold leading-none">{{ $course->duration }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <i class="ri-bar-chart-2-line"></i>
                            <span class="text-heading dark:text-white mb-0.5">
                                {{ translate('Course Level') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading dark:text-white font-semibold leading-none">
                            @foreach ($course->levels as $level)
                                @php $levelTranslations = parse_translation($level); @endphp
                                {{ $levelTranslations['name'] ?? ($level->name ?? '') }}
                                @if (!$loop->first)
                                    ,
                                @endif
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <i class="ri-book-line"></i>
                            <span class="text-heading dark:text-white mb-0.5">
                                {{ translate('Lessons') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        <div class="text-heading dark:text-white font-semibold leading-none">
                            {{ count($course?->chapters) }}</div>
                    </td>
                </tr>
                @if (isset($course->courseTags) && !empty($course->courseTags))
                    <tr>
                        <td class="px-1 py-4 text-left rtl:text-right">
                            <div
                                class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                <i class="ri-price-tag-3-line"></i>
                                <span class="text-heading dark:text-white mb-0.5">
                                    {{ translate('Tags') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-1 py-4 text-right rtl:text-left">
                            <div class="text-heading dark:text-white font-semibold leading-none">
                                @foreach ($course?->courseTags->take(1) as $courseTag)
                                    @php $tagTranslations = parse_translation($courseTag); @endphp
                                    {{ $tagTranslations['name'] ?? $courseTag->name }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endif
                @if (isset($course->languages) && !empty($course->languages))
                    <tr>
                        <td class="px-1 py-4 text-left rtl:text-right">
                            <div
                                class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                <i class="ri-global-line"></i>
                                <span class="text-heading dark:text-white mb-0.5">
                                    {{ translate('Language') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-1 py-4 text-right rtl:text-left">
                            <div class="text-heading dark:text-white font-semibold leading-none">
                                @foreach ($course->languages as $language)
                                    {{ $language->name }}
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endif
                @if ($course?->courseSetting?->is_certificate)
                    <tr>
                        <td class="px-1 py-4 text-left rtl:text-right">
                            <div
                                class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                                <i class="ri-award-line"></i>
                                <span class="text-heading dark:text-white mb-0.5">
                                    {{ translate('Certificate') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-1 py-4 text-right rtl:text-left">
                            <div class="text-heading dark:text-white font-semibold leading-none">
                                {{ translate('Yes') }}
                            </div>
                        </td>
                    </tr>
                @endif

                <tr>
                    <td class="px-1 py-4 text-left rtl:text-right">
                        <div class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                            <span class="text-heading dark:text-white text-lg font-bold mb-0.5">
                                {{ translate('Price') }}
                            </span>
                        </div>
                    </td>
                    <td class="px-1 py-4 text-right rtl:text-left">
                        @if ($course?->courseSetting?->is_free == 1)
                            <div
                                class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center justify-end gap-1.5">
                                <span>
                                    {{ translate('Free') }}
                                </span>
                            </div>
                        @else
                            <div
                                class="text-primary text-xl !leading-none font-bold text-right shrink-0 flex items-center justify-end gap-1.5">
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
                    </td>
                </tr>
            </tbody>
        </table>

        @if ($purchaseCheck !== true)
            @if (is_free($course->id, 'course'))
                <form action="{{ route('course.enrolled') }}" class="form" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $course->id }}" name="id">
                    <input type="hidden" value="course" name="type">
                    @auth
                        @if ($course?->courseSetting?->is_upcoming)
                            <div class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12">
                                {{ translate('Up Coming') }}</div>
                        @else
                            <button type="submit" aria-label="Enroll the Course"
                                class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12">
                                {{ translate('Enroll the Course') }}
                                <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
                            </button>
                        @endif
                    @endauth
                    @guest
                        @if ($course?->courseSetting?->is_upcoming)
                            <div class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12">
                                {{ translate('Up Coming') }}</div>
                        @else
                            <a href="{{ route('login') }}"
                                class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12"
                                aria-label="Enroll the Course">
                                {{ translate('Enroll the Course') }}
                                <span class="hidden md:block">
                                    <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                </span>
                            </a>
                        @endif
                    @endguest
                </form>
            @else
                @if ($course?->courseSetting?->is_upcoming)
                    <div class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12">
                        {{ translate('Up Coming') }}</div>
                @else
                    <button type="button" aria-label="Enroll the Course"
                        class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12 add-to-cart"
                        data-course-id="{{ $course->id }}" data-type="course">
                        {{ translate('Add To Cart') }}
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
                    </button>
                @endif

            @endif
        @else
            <a class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12"
                aria-label="Go to Course video" href="{{ route('play.course', $course?->slug) }}">
                {{ translate('Go to Learn') }}
                <i class="ri-arrow-right-line rtl:before:content-['\ea60'] text-inherit"></i>
            </a>
        @endif
        @if ($courseSetting?->is_subscribe && !$hasPurchase && module_enable_check('subscribe'))
            <a class="btn b-solid btn-primary-solid btn-xl font-medium !rounded-full w-full h-12 mt-5"
                aria-label="Go to Course video" href="{{ route('subscribe.apply', $course?->slug) }}">
                {{ translate('Subscribe') }}
            </a>
        @endif
    </div>
</div>

<!-- START DEMO VIDEO MODAL -->
<x-theme::course.details.demo-video :course="$course" />
<!-- END DEMO VIDEO MODAL -->
