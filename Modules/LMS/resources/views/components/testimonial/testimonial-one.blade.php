@php
    if (empty( $testimonials )) {
        return;
    }
    $totalTestimonials = $testimonials->count() == 0 ? 0 : $testimonials->count() . ' +';
@endphp
<div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle">
                    {{ translate('Testimonials') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Edulab Received More than') }}
                    <span class="title-highlight-one">{{ $totalTestimonials }}</span>
                    {{ translate('Reviews') }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper testimonial-slider xl:mt-[60px]">
            <div class="swiper-wrapper">
                @foreach ($testimonials as $testimonial)
                    <x-theme::cards.testimonial-card-one :testimonial="$testimonial" />
                @endforeach
            </div>
        </div>
        <!-- SWIPER PAGINATION -->
        <div class="flex-center mt-10 lg:mt-[60px]">
            <div class="testimonial-pagination swiper-custom-pagination"></div>
        </div>
    </div>
</div>
