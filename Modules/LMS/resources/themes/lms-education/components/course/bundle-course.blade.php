<div class="bg-white relative pb-16 sm:pb-24 lg:pb-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div class="area-subtitle subtitle-outline style-two text-sm uppercase" >
                    {{ translate('Bundle Courses') }}
                </div>
                <h2 class="area-title mt-1">
                    {{ translate('See Our Bundle Courses') }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 md:justify-self-end">
                <a
                    href="{{ route('bundle.list') }}" aria-label="View All Bundle Courses"
                    class="btn b-solid btn-primary-solid btn-xl font-bold"
                >
                    {{ translate('View All Bundles') }}
                </a>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper popular-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach ($bundles as $bundle)
                    <div class="swiper-slide">
                        <x-theme::cards.bundle.card-three :bundle="$bundle" />
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
