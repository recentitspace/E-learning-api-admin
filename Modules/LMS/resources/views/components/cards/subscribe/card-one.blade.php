@php
    if (!($subscription && is_object($subscription))) {
        return;
    }

    $translations = parse_translation($subscription);
    $title = $translations['title'] ?? ($subscription->title ?? '');
    $description = $translations['description'] ?? ($subscription->description ?? '');
    $iconImg =
        $subscription->icon_img && fileExists('lms/subscribes', $subscription->icon_img)
            ? asset("storage/lms/subscribes/{$subscription->icon_img}")
            : '';

    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);

@endphp

<div class="col-span-full md:col-span-6 lg:col-span-4">
    <div class="flex flex-col bg-section px-4 sm:px-6 md:px-8 xl:px-10 py-8 md:py-10 xl:py-12 rounded-[10px] h-full relative duration-300">
        @if (!empty($iconImg))
            <div class="flex">
                <img data-src="{{ $iconImg }}" alt="Pricing plan image" class="max-w-[70px]">
            </div>
        @endif
        <h5 class="area-title text-[20px] sm:text-[22px] md:text-[24px] font-bold mt-4">{{ $title }}</h5>
        <div class="area-description text-sm sm:text-base mt-1.5">{!! clean($description) !!}</div>
        <div class="area-title font-bold xl:text-[40px] border-y border-heading/10 py-2 mt-7">
            {{ $currencySymbol }}{{ dotZeroRemove($subscription->price) }}
        </div>
        <ul class="text-sm sm:text-base font-medium ps-[22px] mt-8 mb-10 list-image-[url(../../assets/images/icons/pricing-list-1.svg)]">
            <li class="[&:not(:first-child)]:mt-3.5">{{ translate('Access up to') }} {{ $subscription->usable_count }} {{ translate('courses') }}</li>
            <li class="[&:not(:first-child)]:mt-3.5">{{ translate('Subscription valid for') }} {{ $subscription->days }} {{ translate('days') }}</li>
        </ul>
        <div class="mt-auto">
            @if (!authCheck())
                <a href="{{ route('login') }}" aria-label="Buy our subscription plan" class="btn b-solid btn-primary-solid btn-xl h-[50px] text-sm sm:text-base !rounded-full w-full">
                    {{ translate('Buy Now') }}
                </a>
            @else
                <form action="{{ route('subscription.payment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $subscription->id }}">
                    <button type="submit" aria-label="Buy our subscription plan" class="btn b-solid btn-primary-solid btn-xl h-[50px] text-sm sm:text-base !rounded-full w-full">
                        {{ translate('Buy Now') }}
                    </button>
                </form>
            @endif
        </div>
        <!-- BADGE -->
        @if ($subscription->is_popular)
            <div class="absolute top-0 left-1/2 -translate-x-1/2">
                <div class="text-sm uppercase leading-none font-bold bg-[#43D477] rounded-md rounded-t-none px-3.5 py-1.5 w-max">{{ translate('Popular') }}</div>
            </div>
        @endif
    </div>
</div>
