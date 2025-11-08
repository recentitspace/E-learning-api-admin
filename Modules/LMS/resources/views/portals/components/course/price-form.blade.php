@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $platformFee = $backendSetting['platform_fee'] ?? 0;
    $coursePrice = $course?->coursePrice ?? '';
    $price = $coursePrice ? $coursePrice?->price - $coursePrice?->platform_fee : '';
    $discounted_price = $coursePrice ? $coursePrice?->discounted_price - $coursePrice?->platform_fee : '';

@endphp
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="pricing">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <input type="hidden" name="price_id" id="pricingId" value="{{ $course?->coursePrice?->id ?? null }}">
        <div class="grid grid-cols-12 gap-4 card">
            <div class="col-span-full lg:col-span-12">
                <h6 class="text-xl font-semibold text-heading">{{ translate('Course Pricing') }}</h6>
                <div class="mt-10">
                    <div class="leading-none mb-10 grid grid-cols-4 gap-4">
                        <div>
                            <label for="currency" class="form-label">{{ translate('Currency') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <select data-select id="currency" name="currency" class="singleSelect">
                                <option selected disabled data-display="{{ translate('Select Currency') }}">
                                    {{ translate('Select Currency') }} </option>
                                @foreach (all_currency() as $currency)
                                    @php
                                        $codeSymbol = $currency->code . '-' . $currency->symbol;
                                    @endphp
                                    <option value="{{ $currency->code . '-' . $currency->symbol }}"
                                        {{ isset($course?->coursePrice) && $course?->coursePrice?->currency == $codeSymbol ? 'selected' : '' }}>
                                        {{ $currency->symbol }} - {{ $currency->code }}
                                    </option>
                                @endforeach
                            </select>

                            <span class="text-danger error-text currency_err"></span>
                        </div>
                        <div>
                            <label for="price" class="form-label">
                                {{ translate('Course price') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="number" id="price" value="{{ $price }}"
                                class="form-input course-price-cal" required>
                            <span class="text-danger error-text price_err"></span>
                        </div>
                        <div>
                            <label for="platform_fee" class="form-label">
                                {{ translate('Platform Free') }}
                            </label>
                            <input type="number" id="platform_fee" name="platform_fee"
                                value="{{ $platformFee ?? '' }}" class="form-input" readonly required>
                        </div>
                        <div>
                            <label for="course_price" class="form-label">
                                {{ translate('Total Course Price') }}
                            </label>
                            <input type="number" id="total_price" name="price"
                                value="{{ $course?->coursePrice?->price }}" class="form-input" readonly required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="flex items-center gap-2 peer/multiple-instructor">
                            <input id="check-s-2" type="checkbox" name="is_multiple_instructor"
                                class="check check-primary-solid"
                                {{ isset($course) && $course?->is_multiple_instructor == 1 ? 'checked' : '' }}>
                            <label for="check-s-2" class="leading-none font-medium text-gray-500 dark:text-dark-text">
                                {{ translate('Multiple Instructor Share Percentage') }}
                            </label>
                        </div>
                        <span class="text-danger error-text is_multiple_instructor_err"></span>
                        <div class="leading-none mb-10 mt-2 hidden peer-has-[:checked]/multiple-instructor:block pt-4">
                            @foreach ($course->instructors as $key => $instructor)
                                @php
                                    $insUser = $instructor?->userable;
                                    $userTranslations = parse_translation($insUser);
                                @endphp
                                <div class="grid grid-cols-12 mt-2 gap-4 items-center">
                                    <div class="col-span-full lg:col-span-4">
                                        <label
                                            class="leading-none font-medium text-gray-500 dark:text-dark-text">{{ translate('Name') }}
                                        </label>
                                        <input type="hidden" name="instructors[{{ $key }}][id]"
                                            value="{{ $instructor->id }}" class="form-input" />
                                        <input type="text"
                                            value="{{ $userTranslations['first_name'] ?? $insUser->first_name }} {{ $userTranslations['last_name'] ?? $insUser->last_name }}"
                                            class="form-input mt-2" readonly />
                                    </div>

                                    <div class="col-span-full lg:col-span-4">
                                        <label
                                            class="leading-none font-medium text-gray-500 dark:text-dark-text">{{ translate(' Share Percentage') }}
                                        </label>
                                        <input type="text" name="instructors[{{ $key }}][percentage]"
                                            class="form-input mt-2 percentage-calculate"
                                            value="{{ $instructor?->pivot?->percentage ?? 0 }}" />
                                    </div>
                                    <div class="col-span-full lg:col-span-4">
                                        <div class="flex items-center gap-2">
                                            <input id="check-s-2{{ $key }}" type="checkbox"
                                                name="instructors[{{ $key }}][is_main]"
                                                class="check check-primary-solid"
                                                {{ $instructor?->pivot?->is_main == 1 ? 'checked' : '' }}>
                                            <label for="check-s-2{{ $key }}"
                                                class="leading-none font-medium text-gray-500 dark:text-dark-text">
                                                {{ translate('select main instructor') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 peer/discount">
                            <input id="check-s-discount" type="checkbox" name="discount_flag"
                                class="check check-primary-solid"
                                {{ isset($course) && $course?->coursePrice?->discount_flag == 1 ? 'checked' : '' }}>
                            <label for="check-s-discount"
                                class="leading-none font-medium text-gray-500 dark:text-dark-text">
                                {{ translate('Check if this course has a discount') }}
                            </label>
                        </div>
                        <div class="hidden peer-has-[:checked]/discount:block pt-4">

                            <div class="leading-none mb-10 grid grid-cols-4 gap-4">
                                <div class="leading-none">
                                    <label for="discountPrice"
                                        class="form-label">{{ translate('Discounted price') }}</label>
                                    <input type="number" id="discountPrice" placeholder="{{ translate('Discount') }}"
                                        class="form-input course-price-cal" required
                                        value="{{ $discounted_price ?? '' }}">
                                </div>
                                <div>
                                    <label for="platform_fee" class="form-label">
                                        {{ translate('Platform Free') }}
                                    </label>
                                    <input type="number" id="platform_fee" name="platform_fee"
                                        value="{{ $platformFee ?? '' }}" class="form-input" readonly required>
                                </div>
                                <div class="leading-none">
                                    <label for="discount"
                                        class="form-label">{{ translate('Discounted price') }}</label>
                                    <input type="number" id="total_price" name="discounted_price"
                                        placeholder="{{ translate('Discount') }}" class="form-input" required
                                        value="{{ $course?->coursePrice?->discounted_price ?? '' }}" readonly>
                                    <span class="text-danger error-text discounted_price_err"></span>
                                </div>
                            </div>
                            <div class="leading-none mt-7" id="discountPeriod">
                                <label for="discount" class="form-label">{{ translate('Discounted Period') }}</label>
                                <div class="flex">
                                    <span
                                        class="form-input-group input-icon bg-[#F8F8F8] dark:bg-dark-icon !text-gray-900 !rounded-r-none">
                                        <i class="ri-calendar-line text-inherit"></i> </span>
                                    <input type="datetime-local" class="form-input !rounded-l-none" required
                                        name="discount_period"
                                        value="{{ $course?->coursePrice?->discount_period ?? '' }}" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
