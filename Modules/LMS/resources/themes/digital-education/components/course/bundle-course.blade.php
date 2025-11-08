<div class="relative bg-section py-16 sm:py-24 lg:py-[120px] mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">{{ translate( 'Bundle Courses' ) }}</div>
                <h2 class="area-title mt-2">
                    {{ translate( 'Our Bundle Courses' ) }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 md:justify-self-end">
                <div class="flex items-center gap-2">
                    <button type="button" aria-label="Course slider button previous" class="slider-navigation style-two hover:!text-heading !rounded-md bundle-course-four-prev">
                        <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    </button>
                    <button type="button" aria-label="Course slider button next" class="slider-navigation style-two hover:!text-heading !rounded-md bundle-course-four-next">
                        <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- BODY -->
        @if( !empty( $bundles ) && is_iterable( $bundles ) )
            <div class="swiper bundle-course-four-slider mt-10 lg:mt-[60px]">
                <div class="swiper-wrapper">
                    @foreach ($bundles as $bundle)
                        <div class="swiper-slide">
                            <x-theme::cards.bundle.card-four :bundle="$bundle" />
                        </div>
                    @endforeach
                </div>
            </div>
        @else
        <div class="bg-white border border-border rounded-xl h-[400px] mt-10 lg:mt-[60px] shadow-md">
            <div class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
                <h2 class="area-title xl:text-3xl">{{ translate( 'Oops, Nothing Here Yet!' ) }}</h2>
                <p class="area-description">
                    {{ translate( "It looks like we don't have any bundle courses right now. Feel free to browse other courses or let us know if there's something specific you'd like to learn!" ) }}
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
