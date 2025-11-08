@php
    if (!($subscription && is_object($subscription))) {
        return;
    }

    $translations = parse_translation($subscription);
    $title = $translations['title'] ?? ($subscription->title ?? '');
    $description = $translations['description'] ?? ($subscription->description ?? '');

    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);

@endphp

<div class="col-span-full md:col-span-6 lg:col-span-4">
    <div class="flex flex-col bg-white px-4 sm:px-5 md:px-7 xl:px-[30px] py-7 md:py-8 xl:py-9 h-full shadow-pricing-five relative hover:bg-white hover:shadow-pricing-five-hover text-center rounded-[10px] z-0 before:absolute before:inset-0 before:bg-pricing-five before:z-[-1] before:duration-300 hover:before:opacity-0 overflow-hidden group/pricing duration-300">
        <h5 class="area-title text-base md:text-[18px] font-semibold">{{ $title }}</h5>
        <div class="area-title font-bold xl:text-[40px] !leading-none mt-3.5">
            {{ $currencySymbol }}{{ dotZeroRemove($subscription->price) }}
        </div>
        <div class="mt-9">
            @if (!authCheck())
                <a href="{{ route('login') }}" aria-label="Choose our subscription plan" class="flex-center h-11 px-4 bg-primary text-white rounded-full text-sm sm:text-base w-full">
                    {{ translate('Choose Plan') }}
                </a>
            @else
                <form action="{{ route('subscription.payment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $subscription->id }}">
                    <button type="submit" aria-label="Choose our subscription plan" class="flex-center h-11 px-4 bg-primary text-white rounded-full text-sm sm:text-base w-full">
                        {{ translate('Choose Plan') }}
                    </button>
                </form>
            @endif
        </div>
        <ul class="text-sm sm:text-base font-medium ps-7 mt-10 text-start">
            <li class="relative before:absolute before:top-0 before:-start-7 before:font-remix before:content-['\eb81'] before:text-primary sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Access up to') }} {{ $subscription->usable_count }} {{ translate('courses') }}
            </li>
            <li class="relative before:absolute before:top-0 before:-start-7 before:font-remix before:content-['\eb81'] before:text-primary sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Subscription valid for') }} {{ $subscription->days }} {{ translate('days') }}
            </li>
        </ul>
        <!-- BADGE -->
        @if ($subscription->is_popular)
            <div class="absolute top-[7%] sm:top-[5%] end-[-40%] xl:end-[-42%] rotate-45 rtl:-rotate-45 w-full">
                <div class="text-sm uppercase leading-none font-bold bg-primary group-hover/pricing:bg-secondary text-white px-3.5 py-1.5 duration-300 w-full">{{ translate('Popular') }}</div>
            </div>
        @endif
    </div>
</div>
