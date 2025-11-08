@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp


<div class="col-span-full 2xl:col-span-full card">
    <div class="grid grid-cols-12 gap-4 h-full">
        <!-- Total Sale Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total Sale') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">

                        <div class="card-title text-2xl">
                            {{ $currencySymbol }}<span class="counter-value"
                                data-value="{{ $data['total_amount'] }}">{{ translate('0') }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Total Platform Fee Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total Platform Fee') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">

                        <div class="card-title text-2xl">
                            {{ $currencySymbol }}<span class="counter-value"
                                data-value="{{ $data['total_platform_fee'] }}">{{ translate('0') }}</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Total Enrollments Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total enrollments') }}
                </h6>

            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_enrolled'] }}">
                            {{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Course Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total courses') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_courses'] }}">
                            {{ translate('0') }}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Instructor Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total instructors') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_instructor'] }}">
                            {{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Organization Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total organization') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_organization'] }}">
                            {{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Total Student Card -->
        <div class="col-span-full md:col-span-4 lg:col-span-3 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
            <div class="flex-center-between">
                <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                    {{ translate('Total students') }}
                </h6>
            </div>
            <div
                class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                <div class="pb-4 shrink-0">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="counter-value card-title text-2xl" data-value="{{ $data['total_student'] }}">
                            {{ translate('0') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
