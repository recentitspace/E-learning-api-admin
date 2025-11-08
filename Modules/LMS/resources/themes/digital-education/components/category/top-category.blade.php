@php $categories = $categories ?? []; @endphp

<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container max-w-[1600px]">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">{{ translate( 'Courses Categories' ) }}</div>
                <h2 class="area-title mt-2">
                    {{ translate( 'Explore Our Top Categories' ) }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        @if( !empty( $categories ) && is_iterable( $categories ) )
        <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 mt-10 lg:mt-[60px]">
            @foreach( $categories as $category )
                <x-theme::cards.category.card-four :category="$category" />
            @endforeach
        </div>
        @endif
    </div>
</div>