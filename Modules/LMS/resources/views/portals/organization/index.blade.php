@php
    $user = authCheck()?->userable;
    $translations = parse_translation($user);

    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('dashboard') }} </x-slot:title>
    <div class="grid grid-cols-12 gap-x-4">
        <!-- Start Instructor Profile -->
        <div class="col-span-full lg:col-span-4 card p-0">
            <div class="rounded-15 overflow-hidden dk-theme-card-square">
                <x-portal::admin.show-card-profile-img />
                <div class="p-7 mt-6 text-center">
                    <h4 class="text-[22px] leading-none text-heading dark:text-white font-semibold">
                        {{ $translations['name'] ?? $user?->name }}
                    </h4>
                    <div
                        class="flex-center gap-3.5 font-spline_sans mt-5 border-b border-gray-200 dark:border-dark-border pb-4 flex-wrap">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="13" viewBox="0 0 15 13"
                                fill="none">
                                <path
                                    d="M13.6111 0H1.38889C1.02053 0 0.667263 0.146329 0.406796 0.406796C0.146329 0.667263 0 1.02053 0 1.38889V8.61111C0 8.97947 0.146329 9.33274 0.406796 9.5932C0.667263 9.85367 1.02053 10 1.38889 10H13.6111C13.9795 10 14.3327 9.85367 14.5932 9.5932C14.8537 9.33274 15 8.97947 15 8.61111V1.38889C15 1.02053 14.8537 0.667263 14.5932 0.406796C14.3327 0.146329 13.9795 0 13.6111 0ZM13.3333 8.33333H1.66667V1.66667H13.3333V8.33333ZM15 11.9444C15 12.1655 14.9122 12.3774 14.7559 12.5337C14.5996 12.69 14.3877 12.7778 14.1667 12.7778H0.833333C0.61232 12.7778 0.400358 12.69 0.244078 12.5337C0.0877974 12.3774 0 12.1655 0 11.9444C0 11.7234 0.0877974 11.5115 0.244078 11.3552C0.400358 11.1989 0.61232 11.1111 0.833333 11.1111H14.1667C14.3877 11.1111 14.5996 11.1989 14.7559 11.3552C14.9122 11.5115 15 11.7234 15 11.9444ZM5.83333 6.38889V3.61111C5.83328 3.46233 5.87306 3.31625 5.94855 3.18805C6.02403 3.05984 6.13246 2.95417 6.26257 2.88203C6.39269 2.80989 6.53974 2.77389 6.68847 2.77778C6.8372 2.78168 6.98217 2.82531 7.10833 2.90417L9.33056 4.29306C9.45053 4.36794 9.54948 4.47212 9.61808 4.5958C9.68668 4.71947 9.72267 4.85857 9.72267 5C9.72267 5.14143 9.68668 5.28053 9.61808 5.4042C9.54948 5.52788 9.45053 5.63206 9.33056 5.70694L7.10833 7.09583C6.98217 7.17468 6.8372 7.21832 6.68847 7.22222C6.53974 7.22611 6.39269 7.19011 6.26257 7.11797C6.13246 7.04582 6.02403 6.94016 5.94855 6.81195C5.87306 6.68374 5.83328 6.53767 5.83333 6.38889Z"
                                    fill="#795DED" />
                            </svg>
                            <div class="text-sm leading-none text-gray-500 dark:text-dark-text">
                                {{ $data['total_course'] }} {{ translate('Courses') }}
                            </div>
                        </div>
                    </div>
                    <div class="flex-center gap-2 mt-6 flex-wrap">
                        <a href="{{ route('organization.course.create') }}"
                            class="btn b-solid btn-primary-solid dk-theme-card-square">
                            <i class="ri-add-circle-line text-inherit"></i>
                            {{ translate('New course') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Instructor Profile -->

        <!-- Start Instructor Earning Overview -->


        <div class="col-span-full lg:col-span-8 card">
            <div class="grid grid-cols-12 gap-4 mb-4">
                <!-- Instructor Revenue Chart -->
                <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Purchase Amount') }} </h6>
                    </div>
                    <div
                        class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="pb-8 shrink-0">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="card-title text-2xl">
                                    {{ $currencySymbol }}<span class="counter-value"
                                        data-value="{{ $data['total_amount'] }}">{{ translate('0') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('PlatForm Fee') }} </h6>
                    </div>
                    <div
                        class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="pb-8 shrink-0">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="card-title text-2xl">
                                    {{ $currencySymbol }}<span class="counter-value"
                                        data-value="{{ $data['total_platform_fee'] }}">{{ translate('0') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Total Profit') }} </h6>
                    </div>
                    <div
                        class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="pb-8 shrink-0">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="card-title text-2xl">
                                    {{ $currencySymbol }}<span class="counter-value"
                                        data-value="{{ $data['total_amount'] - $data['total_platform_fee'] }}">{{ translate('0') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Available Balance') }} </h6>
                    </div>
                    <div
                        class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="pb-8 shrink-0">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="card-title text-2xl">
                                    {{ $currencySymbol }}<span class="counter-value"
                                        data-value="{{ $user->user_balance ?? 0 }}">{{ translate('0') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Instructor Course -->
                <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Total Course') }} </h6>
                    </div>
                    <div
                        class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="pb-8 shrink-0">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="card-title text-2xl">
                                    <span class="counter-value"
                                        data-value="{{ $data['total_course'] }}">{{ translate('0') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-full sm:col-span-4 p-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Total Bundles') }} </h6>
                    </div>
                    <div
                        class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="pb-8 shrink-0">
                            <div class="flex items-center gap-2 mb-3">
                                <div class="card-title text-2xl">
                                    <span class="counter-value"
                                        data-value="{{ $data['total_bundle'] }}">{{ translate('0') }}</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($topCourses) && !empty($topCourses))
            <div class="col-span-full card">
                <div class="flex-center-between mb-6">
                    <h6 class="card-title"> {{ translate('Top performing courses') }} </h6>
                    <a href="{{ route('organization.course.index') }}"
                        class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square">
                        {{ translate('See all') }}
                    </a>
                </div>
                <x-portal::admin.admin.top-course :topCourses="$data['best_total_course']" sales="true" />

            </div>
        @endif
    </div>
</x-dashboard-layout>
