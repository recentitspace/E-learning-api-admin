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
    <div class="flex flex-col bg-white px-4 sm:px-5 md:px-7 xl:px-[30px] py-7 md:py-8 xl:py-9 h-full shadow-pricing-four relative hover:bg-white hover:shadow-pricing-five-hover rounded-[10px] group/pricing duration-300">
        <div class="flex-center-between gap-4 flex-wrap">
            <h5 class="area-title text-base !leading-none font-semibold">
                <span class="flex items-center gap-2 border border-heading/10 rounded-full px-3.5 py-1.5">
                    <i class="ri-checkbox-blank-circle-fill text-[9px] text-secondary"></i>
                    {{ $title }}
                </span>
            </h5>
            <!-- BADGE -->
            @if ($subscription->is_popular)
                <span class="badge b-solid badge-secondary-solid rounded-full h-[27px]">{{ translate('Popular') }}</span>
            @endif
        </div>
        <div class="area-title font-bold xl:text-[40px] !leading-none mt-6">
            {{ $currencySymbol }}{{ dotZeroRemove($subscription->price) }}
        </div>
        <p class="area-description text-sm sm:text-base mt-2">{!! clean($description) !!}</p>
        <ul class="text-sm sm:text-base font-medium ps-7 mt-10 mb-7 pt-7 border-t border-heading/10">
            <li class="relative before:absolute before:top-0 before:-start-7 before:font-remix before:content-['\eb80'] before:text-secondary sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Access up to') }} {{ $subscription->usable_count }} {{ translate('courses') }}
            </li>
            <li class="relative before:absolute before:top-0 before:-start-7 before:font-remix before:content-['\eb80'] before:text-secondary sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Subscription valid for') }} {{ $subscription->days }} {{ translate('days') }}
            </li>
        </ul>
        <div class="pt-7 border-t border-heading/10 mt-auto">
            @if (!authCheck())
                <a href="{{ route('login') }}" aria-label="Choose our subscription plan" class="font-bold text-sm sm:text-base flex-center h-12 px-4 border border-heading/25 group-hover/pricing:bg-primary group-hover/pricing:!border-transparent group-hover/pricing:text-heading rounded-full duration-300 w-full">
                    {{ translate('Choose Plan') }}
                </a>
            @else
                <form action="{{ route('subscription.payment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $subscription->id }}">
                    <button type="submit" aria-label="Choose our subscription plan" class="font-bold text-sm sm:text-base flex-center h-12 px-4 border border-heading/25 group-hover/pricing:bg-primary group-hover/pricing:!border-transparent group-hover/pricing:text-heading rounded-full duration-300 w-full">
                        {{ translate('Choose Plan') }}
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
