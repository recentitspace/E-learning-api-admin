<!-- START ORGANIZATION AREA -->
<div class="relative pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div
                    class="area-subtitle subtitle-outline style-two text-sm uppercase"
                >
                    {{ translate('Organizations') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Explore Best Organizations') }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button type="button" aria-label="Organization slider previous button"
                        class="slider-navigation style-two !rounded-md organization-prev"
                    >
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button type="button" aria-label="Organization slider next button"
                        class="slider-navigation style-two !rounded-md organization-next"
                    >
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper organization-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach( $organizations as $organization )
                    <x-theme::cards.organization.card-three :organization=" $organization " />
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- END ORGANIZATION AREA -->
