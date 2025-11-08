@php
    $bundles = $bundles ?? [];
    $totalBundle = count($bundles);

    $bundleRoute = '';
    $bundleBtnText = '';

    if ($totalBundle > 0) {
        $bundleRoute = '';
        $bundleBtnText = 'View all bundle';
    }

    if (isAdmin() && $totalBundle < 1) {
        $bundleRoute = 'bundle.create';
        $bundleBtnText = 'Add Bundle';
    }
@endphp

<div class="bg-section pb-16 sm:pb-24 lg:pb-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle">
                    {{ translate('Latest Bundle') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('See Our Popular') }}
                    <span class="title-highlight-one">
                        {{ translate('Bundle') }}
                    </span>
                    {{ translate('Courses') }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper up-coming-courses-slider mt-10 lg:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach ($bundles as $bundle)
                    <div class="swiper-slide col-span-full group-data-[card-layout=list]:!col-span-full">
                        <x-theme::cards.bundle.card-one :bundle="$bundle" />
                    </div>
                @endforeach
            </div>
        </div>
        @if ($bundleRoute && $bundleRoute)
            <div class="flex-center mt-10 lg:mt-[60px]">
                <a
                    href="{{ route($bundleRoute) }}"
                    title="{{ $bundleRoute }}"
                    class="btn b-solid btn-primary-solid btn-xl !rounded-full font-medium text-[16px] md:text-[18px]"
                    aria-label="{{ $bundleRoute }}"
                >
                    {{ translate($bundleBtnText) }}
                    <span class="hidden md:block">
                        <i class="ri-arrow-right-up-line text-[20px] rtl:before:content-['\ea66']"></i>
                    </span>
                </a>
            </div>
        @endif
    </div>
</div>
