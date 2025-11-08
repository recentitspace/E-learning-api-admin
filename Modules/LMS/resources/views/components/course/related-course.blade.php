<div class="relative mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 md:pr-20">
                <div class="area-subtitle">
                    {{ translate('Related Course') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Explore Related') }}
                    <span class="title-highlight-one"> {{ translate('Courses') }} </span>
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button type="button" class="slider-navigation related-courses-prev" aria-label="Course slider previous button">
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button type="button" class="slider-navigation related-courses-next" aria-label="Course slider next button">
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper related-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                <x-theme::cards.course-card-one :courses="$courses" borderClass="true" />
            </div>
        </div>
    </div>
</div>
