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
    <div class="flex flex-col bg-white border border-heading/10 px-4 sm:px-5 md:px-7 xl:px-[30px] py-7 md:py-8 xl:py-9 h-full relative duration-300 hover:bg-primary text-center rounded-xl overflow-hidden group/pricing">
        <div class="area-title font-bold xl:text-[36px] !leading-none group-hover/pricing:text-white duration-300">
            {{ $currencySymbol }}{{ dotZeroRemove($subscription->price) }}
        </div>
        <h5 class="area-title text-lg md:text-[20px] font-bold group-hover/pricing:text-white mt-5 duration-300">{{ $title }}</h5>
        <p class="area-description !font-normal text-sm group-hover/pricing:text-white/80 mt-2.5 duration-300">{!! clean($description) !!}</p>
        <ul class="text-sm sm:text-base font-medium group-hover/pricing:text-white ps-7 pt-6 mt-6 mb-10 text-start border-t-2 border-heading/10 group-hover/pricing:border-white/15 duration-300">
            <li class="relative before:absolute before:top-0 before:-start-7 before:font-remix before:content-['\eb80'] sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Access up to') }} {{ $subscription->usable_count }} {{ translate('courses') }}
            </li>
            <li class="relative before:absolute before:top-0 before:-start-7 before:font-remix before:content-['\eb80'] sm:before:text-lg [&:not(:first-child)]:mt-3.5">
                {{ translate('Subscription valid for') }} {{ $subscription->days }} {{ translate('days') }}
            </li>
        </ul>
        <div class="mt-auto">
            @if (!authCheck())
                <a href="{{ route('login') }}" aria-label="Select Our subscription plan" class="flex-center font-bold h-11 px-4 bg-heading group-hover/pricing:bg-secondary text-white group-hover/pricing:text-heading rounded-lg text-sm sm:text-base duration-300 w-full">
                    {{ translate('Select Our Plan') }}
                </a>
            @else
                <form action="{{ route('subscription.payment') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $subscription->id }}">
                    <button type="submit" aria-label="Select Our subscription plan" class="flex-center font-bold h-11 px-4 bg-heading group-hover/pricing:bg-secondary text-white group-hover/pricing:text-heading rounded-lg text-sm sm:text-base duration-300 w-full">
                        {{ translate('Select Our Plan') }}
                    </button>
                </form>
            @endif
        </div>
        <!-- BADGE -->
        @if ($subscription->is_popular)
            <div class="absolute top-[5%] start-[-37%] -rotate-45 rtl:rotate-45 w-full">
                <div class="text-sm uppercase leading-none font-bold bg-primary group-hover/pricing:bg-secondary text-white px-3.5 py-1.5 duration-300 w-full">{{ translate('Popular') }}</div>
            </div>
        @endif
    </div>
</div>
