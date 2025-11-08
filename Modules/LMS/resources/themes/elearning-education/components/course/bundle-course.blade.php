<div class="relative bg-section py-16 sm:py-24 lg:py-[120px] mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 lg:pr-20 rtl:lg:pr-0 rtl:lg:pl-20">
                <h2 class="area-title mt-2">{{ translate('Our Bundle Courses') }}</h2>
            </div>
            <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button type="button" aria-label="Course slider previous" class="slider-navigation style-two bundle-course-two-prev">
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button type="button" aria-label="Course slider next" class="slider-navigation style-two bundle-course-two-next">
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper bundle-course-two-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach ($bundles as $bundle)
                    <div class="swiper-slide">
                        <x-theme::cards.bundle.card-two :bundle="$bundle" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
