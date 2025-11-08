
@php $testimonials = $testimonials ?? []; @endphp

<div class="pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full text-center max-w-[594px] mx-auto">
                <div class="area-subtitle subtitle-outline style-three !text-secondary">{{ translate( 'Testimonials' ) }}</div>
                <h2 class="area-title mt-2">
                    {{ translate( 'What Our Students Say About us' ) }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        @if( ! empty( $testimonials ) && is_iterable( $testimonials ) )
            <div class="swiper testimonial-four-slider mt-10 lg:mt-[60px]">
                <div class="swiper-wrapper">
                    <!-- SINGLE TESTIMONIAL -->
                    @foreach( $testimonials as $testimonial )
                        <x-theme::cards.testimonial.card-four :testimonial="$testimonial" />
                    @endforeach
                </div>
            </div>
            <!-- SWIPER PAGINATION -->
            <div class="flex-center mt-10 lg:mt-[60px]">
                <div class="testimonial-four-pagination swiper-custom-pagination"></div>
            </div>
        @endif
    </div>
</div>