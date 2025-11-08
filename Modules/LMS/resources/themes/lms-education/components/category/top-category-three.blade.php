<!-- START CATEGORY AREA -->
<div class="mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="mx-[12px]">
        <div class="bg-primary py-16 sm:py-24 lg:py-[120px] max-w-[1600px] mx-auto rounded-3xl">
            <div class="container">
                <!-- HEADER -->
                <div class="grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-full text-center max-w-[594px] mx-auto">
                        <div class="area-subtitle subtitle-outline style-two !border-[#F4B826]/15 text-sm uppercase !text-secondary">
                            {{ translate('Courses Categories') }}
                        </div>
                        <h2 class="area-title text-white mt-2">
                            {{ translate('Explore Our Top Categories') }}
                        </h2>
                    </div>
                </div>
                <!-- BODY -->
                <div class="grid grid-cols-12 gap-x-4 xl:gap-x-7 gap-y-7 mt-[60px]">
                    @foreach( $categories as $category )
                        <x-theme::cards.category.card-three :category="$category" />
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CATEGORY AREA -->