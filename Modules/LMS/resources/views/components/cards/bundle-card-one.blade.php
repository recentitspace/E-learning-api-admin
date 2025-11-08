@if (count($bundle->courses) > 0)

    @php
        $bundleTranslations = parse_translation($bundle);
        $currency = $bundle?->currency ?? 'USD-$';
        $currencySymbol = get_currency_symbol($currency);
    @endphp
    <div class="col-span-full lg:col-span-6">
        <div class="p-6 border border-border h-full rounded-xl hover:bg-primary-50 overflow-x-auto custom-transition">
            <table class="w-full table-auto whitespace-nowrap">
                <caption class="area-title text-xl text-left rtl:text-right mb-7">
                    {{ $bundleTranslations['title'] ?? $bundle->title }}
                </caption>
                <tbody class="divide-y divide-border">

                    @foreach ($bundle->courses as $course)
                        @php
                            $reviews = review($course);
                            $translations = parse_translation($course);
                            $thumbnail =
                                $course->thumbnail && fileExists('lms/courses/thumbnails', $course->thumbnail) == true
                                    ? asset("storage/lms/courses/thumbnails/{$course->thumbnail}")
                                    : asset('lms/frontend/assets/images/420x252.svg');

                            $courseCurrency = $course?->coursePrice?->currency ?? 'USD-$';
                            $courseCurrencySymbol = get_currency_symbol($courseCurrency);

                        @endphp
                        <tr>
                            <td class="py-5 text-left rtl:text-right">
                                <a href="{{ route('course.detail', $course->slug) }}" aria-label="Course bundle link"
                                    class="flex items-center gap-2">
                                    <div class="size-20 rounded-50 overflow-hidden dk-theme-card-square">
                                        <img data-src="{{ $thumbnail }}" alt="Course thumbnail"
                                            class="size-full object-cover">
                                    </div>
                                    <span>
                                        <span class="flex items-center gap-2">
                                            <span class="flex items-center gap-0.5 text-secondary">
                                                {!! show_rating($reviews['average_rating']) !!}
                                            </span>
                                            <p class="area-description text-sm !leading-none">
                                                ({{ dotZeroRemove($reviews['average_rating']) ?? 0 }}
                                                {{ translate('Rating') }})
                                            </p>

                                        </span>
                                        <span class="inline-block area-title text-lg !leading-none line-clamp-1 mt-4">
                                            {{ str_limit($translations['title'] ?? $course->title, 30, '..') }}
                                        </span>
                                    </span>
                                </a>
                            </td>
                            <td class="py-5 text-right rtl:text-left">
                                <div class="text-primary text-lg font-bold leading-none">
                                    @if ($course?->courseSetting?->is_free)
                                        {{ translate('Free') }}
                                    @else
                                        @if (isset($course?->coursePrice) &&
                                                $course?->coursePrice?->discount_flag == 1 &&
                                                $course?->coursePrice?->discount_period != '' &&
                                                dateCompare($course?->coursePrice?->discount_period) == true)
                                            {{ $courseCurrencySymbol }}{{ dotZeroRemove($course?->coursePrice?->discounted_price ?? 0) }}
                                            <del> {{ $courseCurrencySymbol }}
                                                {{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}</del>

                                            {{ discountPercentage($course?->coursePrice?->price, $course?->coursePrice?->discounted_price) }}%
                                            {{ translate('OFF') }}
                                        @else
                                            {{ $courseCurrencySymbol }}{{ dotZeroRemove($course?->coursePrice?->price ?? 0) }}
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="flex-center gap-4 mt-5">
                @if (purchaseCheck($bundle->id, type: 'bundle') !== true)
                    @if (is_free($bundle->id, type: 'bundle'))
                        <form action="{{ route('course.enrolled') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $bundle->id }}" name="id">
                            <input type="hidden" value="bundle" name="type">

                            <div class="flex gap-2">
                                <div
                                    class="btn b-outline border-border btn-xl h-12 bg-white hover:border-border hover:!text-heading dark:text-white !rounded-full font-medium">
                                    <b> {{ translate('Free') }} </b>
                                </div>
                                @auth
                                    <button type="submit"
                                        class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full font-medium"
                                        aria-label="Enroll The Bundle">
                                        {{ translate('Enroll The Bundle') }}
                                        <i class="ri-arrow-right-line text-inherit"></i>
                                    </button>
                                @endauth
                                @guest
                                    <button type="button"
                                        class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full font-medium auth-login"
                                        aria-label="Enroll The Bundle">
                                        {{ translate('Enroll The Bundle') }}
                                        <span class="hidden md:block">
                                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                                        </span> </button>
                                @endguest
                            </div>
                        </form>
                    @else
                        <div
                            class="btn b-outline border-border btn-xl h-12 bg-white hover:border-border hover:!text-heading dark:text-white !rounded-full font-medium">
                            {{ translate('Total') }}:
                            <b>{{ $currencySymbol }}{{ dotZeroRemove($bundle?->price ?? 0) }}</b>
                        </div>
                        <a class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full font-medium add-to-cart cursor-pointer"
                            data-course-id="{{ $bundle->id }}" data-type="bundle" aria-label="Buy the Bundle">
                            {{ translate('Buy the Bundle') }} <span class="hidden md:block">
                                <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                            </span> </a>
                    @endif
                @else
                    <a class="btn b-solid btn-primary-solid btn-xl h-12 !rounded-full font-medium" href="#"
                        aria-label="Click Bundle Course for learn">
                        {{ translate('Click Bundle Course for learn') }}
                        <span class="hidden md:block">
                            <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                        </span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
