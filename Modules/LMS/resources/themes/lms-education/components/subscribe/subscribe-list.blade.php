@php
    $subscriptions = $subscriptions ?? [];
@endphp

<div class="bg-pricing-three py-16 sm:py-24 lg:py-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle subtitle-outline style-two text-sm uppercase">{{ translate('Pricing Plan') }}</div>
                <h2 class="area-title mt-1">{{ translate('Simple Pricing for Everyone') }}</h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-[60px]">
            @foreach ($subscriptions as $subscription)
                <x-theme::cards.subscribe.card-three :subscription=$subscription />
            @endforeach
        </div>
    </div>
</div>
