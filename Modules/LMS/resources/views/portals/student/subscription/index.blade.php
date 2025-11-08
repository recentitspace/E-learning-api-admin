@php
    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);
@endphp
<x-dashboard-layout>
    <x-slot:title> {{ translate('My Wishlist') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="My Wishlist" page-to="wishlist" />
    <!-- Start Main Content -->
    <div class="overflow-hidden">
        <div class="overflow-x-auto scrollbar-table">

            @if ($activePlan)
                <div class="grid grid-cols-12 gap-4 h-full">
                    <div class="col-span-full md:col-span-4 card p-5 mb-0">
                        <div
                            class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                            <img src="http://127.0.0.1:8000/lms/assets/images/icons/course-overview/progress.svg"
                                alt="icon" class="dark:brightness-[5]">
                        </div>
                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $activePlan->title ?? '' }}
                        </p>
                        <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none">
                            <strong class="font-30 text-dark-blue font-weight-bold mt-5">
                                @if ($activePlan->infinite_use)
                                    {{ translate('Unlimited') }}
                                @else
                                    {{ $activePlan->usable_count - $activePlan->used_count }}
                                @endif
                            </strong>
                            <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none">
                                {{ translate('Remain Enroll') }}
                            </div>

                        </div>
                    </div>

                    <div class="col-span-full md:col-span-4 card p-5 mb-0">
                        <div
                            class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                            <img src="http://127.0.0.1:8000/lms/assets/images/icons/course-overview/progress.svg"
                                alt="icon" class="dark:brightness-[5]">
                        </div>
                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $activePlan->days - $dayOfUse }}
                        </p>
                        <div class="counter-value text-primary-500 text-[32px] font-semibold leading-none">

                            {{ translate('Remain Days') }}
                        </div>
                    </div>
                </div>
            @else
                <p>One</p>
                <p>One</p>
            @endif

            <div class="grid grid-cols-12 gap-4 h-full mt-10">
                @foreach ($subscribes as $subscribe)
                    @php
                        $subscribeTranslations = parse_translation($subscribe);
                        $iconImg =
                            $subscribe->icon_img && fileExists('lms/subscribes', $subscribe->icon_img)
                                ? asset("storage/lms/subscribes/{$subscribe->icon_img}")
                                : asset('lms/frontend/assets/images/450x300.svg');
                    @endphp
                    <div class="col-span-full md:col-span-4 card p-5 mb-0">
                        <div
                            class="size-11 flex-center bg-[#F7F3FF] dark:bg-dark-icon rounded-10 dk-theme-card-square mb-4">
                            @if ($subscribe->is_popular)
                                <span>Popular</span>
                            @endif
                            <img src="{{ $iconImg }}" alt="icon" class="dark:brightness-[5]">
                        </div>
                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $subscribeTranslations['title'] ?? $subscribe->title }}
                        </p>

                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $subscribeTranslations['description'] ?? $subscribe->description }}
                        </p>

                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $currencySymbol }}{{ $subscribe->price }}
                        </p>

                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $subscribe->usable_count }} {{ translate('days of subscription') }}
                        </p>

                        <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
                            {{ $subscribe->days }} {{ translate('Subscribes') }}
                        </p>

                        <div class="mt-3">
                            <form action="{{ route('subscription.payment') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $subscribe->id }}">
                                <button type="submit"
                                    class="btn b-solid btn-primary-solid !rounded-full font-medium text-[16px] md:text-[18px] mt-2">
                                    Purchase
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-dashboard-layout>
