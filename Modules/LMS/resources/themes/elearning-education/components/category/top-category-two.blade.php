<div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle">{{ translate('Categories') }}</div>
                <h2 class="area-title mt-2">
                    {{ translate('Our Top Categories') }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="grid grid-cols-12 gap-4 xl:gap-7 mt-10 lg:mt-[60px]">
            @foreach( $categories as $category )
                <x-theme::cards.category.card-two :category="$category" />
            @endforeach
        </div>
    </div>
</div>