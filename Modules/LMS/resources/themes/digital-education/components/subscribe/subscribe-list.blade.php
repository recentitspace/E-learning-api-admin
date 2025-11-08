@php
    $subscriptions = $subscriptions ?? [];
@endphp

<div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">{{ translate('Pricing Plan') }}</div>
                <h2 class="area-title mt-2">{{ translate('Flexible Pricing Plans to Suit Your Needs') }}</h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-[60px]">
            @foreach ($subscriptions as $subscription)
                <x-theme::cards.subscribe.card-four :subscription=$subscription />
            @endforeach
        </div>
    </div>
</div>
