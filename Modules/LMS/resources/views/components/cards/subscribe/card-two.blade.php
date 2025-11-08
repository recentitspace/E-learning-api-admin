@php
    if (!($subscription && is_object($subscription))) {
        return;
    }

    $translations = parse_translation($subscription);
    $title = $translations['title'] ?? ($subscription->title ?? '');

    $backendSetting = get_theme_option(key: 'backend_general') ?? null;
    $currency = $backendSetting['currency'] ?? 'USD-$';
    $currencySymbol = get_currency_symbol($currency);

@endphp

<div class="col-span-full md:col-span-6 lg:col-span-4">
    <div class="flex flex-col bg-section px-4 sm:px-6 md:px-8 xl:px-10 py-8 md:py-10 xl:py-12 h-full relative duration-300 hover:bg-heading group/pricing">
        <h5 class="area-title text-[20px] sm:text-[22px] md:text-[24px] font-bold group-hover/pricing:text-white mt-4 duration-300">{{ $title }}</h5>
        <div class="area-title font-bold xl:text-[60px] !leading-none border-b border-heading/10 group-hover/pricing:border-white/15 group-hover/pricing:text-white pb-5 mt-7 duration-300">
            {{ $currencySymbol }}{{ dotZeroRemove($subscription->price) }}
        </div>
        <ul class="text-sm sm:text-base font-medium group-hover/pricing:text-white ps-[22px] mt-10 mb-[60px] duration-300">
            <li class="relative before:absolute before:top-0 before:-start-6 before:font-remix before:content-['\eb7b'] sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Access up to') }} {{ $subscription->usable_count }} {{ translate('courses') }}
            </li>
            <li class="relative before:absolute before:top-0 before:-start-6 before:font-remix before:content-['\eb7b'] sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Subscription valid for') }} {{ $subscription->days }} {{ translate('days') }}
            </li>
        </ul>
        <div class="mt-auto">
            @if (!authCheck())
                <a href="{{ route('login') }}" aria-label="Select Our subscription plan" class="flex-center h-12 px-4 border-2 border-heading/10 group-hover/pricing:bg-primary group-hover/pricing:!border-transparent group-hover/pricing:text-white !rounded-none text-sm sm:text-base duration-300 w-full">
                    {{ translate('Select Our Plan') }}
                </a>
            @else
                <form action="{{ route('subscription.payment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $subscription->id }}">
                    <button type="submit" aria-label="Select Our subscription plan" class="flex-center h-12 px-4 border-2 border-heading/10 group-hover/pricing:bg-primary group-hover/pricing:!border-transparent group-hover/pricing:text-white !rounded-none text-sm sm:text-base duration-300 w-full">
                        {{ translate('Select Our Plan') }}
                    </button>
                </form>
            @endif
        </div>
        <!-- BADGE -->
        @if ($subscription->is_popular)
            <div class="absolute top-0 left-1/2 -translate-x-1/2">
                <div class="text-sm uppercase leading-none font-bold bg-primary text-white rounded-md rounded-t-none px-3.5 py-1.5 w-max">{{ translate('Popular') }}</div>
            </div>
        @endif
    </div>
</div>
