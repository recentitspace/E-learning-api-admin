<!-- START TESTIMONIAL AREA -->
<div class="bg-primary rounded-3xl py-16 sm:py-24 lg:py-[120px] mx-[12px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 lg:pr-20">
                <div class="area-subtitle subtitle-outline style-two !border-[#F4B826]/15 text-sm !text-secondary uppercase">
                    {{ translate('Student Feedback') }}
                </div>
                <h2 class="area-title text-white mt-1">
                    {{ translate('What Our Students Says') }}
                </h2>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiperx testimonial-three-slider mt-10 lg:mt-[60px]">
            <div class="swiperx-wrapper">
                <!-- SINGLE TESTIMONIAL -->
                @if( !empty($testimonials ) )
                    @foreach($testimonials as $key => $testimonial)
                        @if($loop->first)
                            <x-theme::cards.testimonial.card-three :testimonial="$testimonial" />
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<!-- END TESTIMONIAL AREA -->