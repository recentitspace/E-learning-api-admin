@php
    $subscriptions = $subscriptions ?? [];
@endphp

<div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-screen-sm mx-auto">
                <div class="area-subtitle">{{ translate('Subscription') }}</div>
                <h2 class="area-title mt-2">
                    {{ translate('Unlock Your Learning') }}
                    <span class="title-highlight-one">{{ translate('Potential') }}</span>
                    - {{ translate('Choose Your Plan') }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-[60px]">
            @foreach ($subscriptions as $subscription)
                <x-theme::cards.subscribe.card-one :subscription=$subscription />
            @endforeach
        </div>
    </div>
</div>
