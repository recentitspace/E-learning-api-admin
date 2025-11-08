<div class="bg-primary-50 px-3 max-w-[1600px] mx-auto mt-16 sm:mt-24 lg:mt-[120px]">
    <div class="container">
        <div class="py-16 sm:py-24 lg:py-[120px]">
            <div class="grid grid-cols-12 gap-4 xl:gap-7">
                <div class="col-span-full lg:col-span-5">
                    <h2 class="area-title">
                        {{ translate("What Students say's About EduVen to take their service") }}
                    </h2>
                    <p class="area-description mt-2.5">
                        {{ translate('Students praise EduVen for its easy-to-use interface, interactive courses, and effective learning tools.') }}
                    </p>
                    <div class="flex items-center justify-end lg:justify-start gap-2 mt-11">
                        <button type="button" aria-label="Testimonial previous slider button" class="slider-navigation style-two testimonial-two-prev">
                            <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                        </button>
                        <button type="button" aria-label="Testimonial next slider button" class="slider-navigation style-two testimonial-two-next">
                            <i class="ri-arrow-right-line rtl:before:content-['\ea60']"></i>
                        </button>
                    </div>
                </div>
                <div class="col-span-full lg:col-span-7">
                    <div class="swiper relative testimonial-two-slider">
                        <div class="swiper-wrapper">
                            <!-- SINGLE TESTIMONIAL -->
                            @if( !empty($testimonials) )
                                @php
                                    $testimonials =  $testimonials->take(4);
                                @endphp
                                @foreach($testimonials as $testimonial)
                                    <x-theme::cards.testimonial.card-two :testimonial="$testimonial" />
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
