
<div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
    <div class="container">
        <!-- HEADER -->
        <div class="grid grid-cols-12 gap-4 items-center">
            <div class="col-span-full md:col-span-7 xl:col-span-6 lg:pr-20 rtl:lg:pr-0 rtl:lg:pl-20">
                <div class="area-subtitle">
                    {{ translate('Our Instructors') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Meet Our Most Talented Team Member') }}
                </h2>
            </div>
            <div class="col-span-full md:col-span-5 xl:col-span-6 md:justify-self-end">
                <a href="{{ route('instructor.list') }}" aria-label="See all Teachers" class="btn b-outline btn-primary-outline btn-xl !rounded-none font-bold">
                    {{ translate('See all Teachers') }}
                </a>
            </div>
        </div>
        <!-- BODY -->
        <div class="swiper instructor-slider-two mt-[60px]">
            <div class="swiper-wrapper !ease-linear">
                <!-- SINGLE INSTRUCTOR -->
                @foreach( $instructors as $instructor )   
                    <x-theme::cards.instructor.card-two :instructor="$instructor" />
                @endforeach  
            </div> 
        </div>
    </div>
</div>
