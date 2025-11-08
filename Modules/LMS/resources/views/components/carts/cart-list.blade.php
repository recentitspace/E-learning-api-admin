<table class="table-auto w-full whitespace-nowrap text-left rtl:text-right">
    <thead class="border-b border-border">
        <tr>
            <th class="px-3.5 py-4"> {{ translate('Course') }} </th>
            <th class="px-3.5 py-4 w-20"> {{ translate('Price') }} </th>
            <th class="px-3.5 py-4 w-10">{{ translate('Action') }}</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-border">

        @foreach ($cartCourses as $cartCourse)
            @php
                $route =
                    $cartCourse['type'] == 'course'
                        ? route('course.detail', $cartCourse['slug'])
                        : route('bundle.detail', $cartCourse['slug']);

                $currencySymbol = get_currency_symbol($cartCourse['currency']);
            @endphp
            <tr>
                <td class="px-3.5 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ $route }}" class="size-20 rounded-50 overflow-hidden"
                            aria-label="Course information">
                            @if (
                                $cartCourse['type'] == 'course' &&
                                    fileExists('lms/courses/thumbnails', $cartCourse['image']) == true &&
                                    $cartCourse['image'] != '')
                                <img data-src="{{ asset('storage/lms/courses/thumbnails/' . $cartCourse['image']) }}"
                                    alt="Course thumbnail" class="size-full object-cover">
                            @elseif (
                                $cartCourse['type'] == 'bundle' &&
                                    fileExists('lms/courses/bundles', $cartCourse['image']) == true &&
                                    $cartCourse['image'] != '')
                                <img data-src="{{ asset('storage/lms/courses/bundles/' . $cartCourse['image']) }}"
                                    alt="Course thumbnail" class="size-full object-cover">
                            @else
                                <img data-src="{{ asset('lms/frontend/assets/images/420x252.svg') }}"
                                    alt="Course thumbnail" class="size-full object-cover">
                            @endif
                        </a>
                        <div>
                            <h6
                                class="text-lg leading-none text-heading dark:text-white font-semibold hover:underline custom-transition mb-1.5 line-clamp-1">
                                <a href="{{ $route }}" aria-label="Course title">
                                    @if ($cartCourse['type'] == 'course')
                                        {{ str_limit($courseTranslations['title'] ?? $cartCourse['title'], 30) }}
                                    @else
                                        {{ str_limit($cartCourse['title'], 30) }}
                                    @endif

                                </a>
                            </h6>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center gap-1">
                                    <i class="ri-star-fill text-sm !text-secondary"></i>
                                    <span
                                        class="text-xs font-semibold leading-none">{{ $cartCourse['review']['average_rating'] ?? 0 }}</span>
                                </div>
                                <p class="font-normal text-xs text-heading/70">{{ translate('Author') }} -
                                    {{ $cartCourse['author'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-3.5 py-4">
                    <span class="text-primary font-semibold">
                        @if (isset($cartCourse['discount_price']) && $cartCourse['discount_price'] !== 0)
                            {{ $currencySymbol }}{{ $cartCourse['currency'] }}
                            <del>
                                {{ $currencySymbol }}{{ $cartCourse['price'] }}</del>
                        @else
                            {{ $currencySymbol }}{{ $cartCourse['price'] }}
                        @endif
                    </span>
                </td>
                <td class="px-3.5 py-4">
                    <button type="button" class="btn text-danger font-bold remove-cart"
                        data-id="{{ $cartCourse['id'] }}" aria-label="Remove course from list"
                        data-action="{{ route('remove.cart') }}">
                        {{ translate('Remove') }}
                    </button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
