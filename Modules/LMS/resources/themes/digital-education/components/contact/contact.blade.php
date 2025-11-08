<div class="pt-16 sm:pt-24 lg:pt-[170px] mx-[12px]">
    <div class="relative max-w-[1600px] mx-auto flex flex-col">
        <div class="relative w-full bg-no-repeat bg-center bg-cover min-h-[470px] py-44 before:absolute before:size-full before:inset-0 before:z-[1] before:bg-video-overlay overflow-hidden rounded-2xl"
            style="background-image: url({{ asset('lms/frontend/assets/images/online-video/video-banner.webp') }});">
            <!-- It will empty -->
        </div>
        <div
            class="container relative mt-[-70%] sm:mt-[-50%] md:mt-[-40%] lg:mt-0 lg:absolute lg:top-[-10%] lg:left-1/2 lg:-translate-x-1/2 z-[1]">
            <div class="grid grid-cols-12 gap-7">
                <div class="col-span-full lg:col-span-6 xl:col-span-4 order-2 lg:order-none">
                    <div class="bg-white px-7 py-16 border border-heading/15 rounded-xl shadow-md">
                        <h5 class="area-title text-[30px] font-bold">
                            {{ translate('Join as an instructor for online course.') }}
                        </h5>
                        <x-digital-education:theme::form.join-us.form />
                    </div>
                </div>
                <div class="col-span-full lg:col-span-6 xl:col-span-8 order-1 lg:order-none">
                    <div class="h-full flex-center">
                        <button type="button" aria-label="Demo video model" data-modal-id="demo-video-modal"
                            class="btn-icon size-16 b-solid btn-primary-icon-solid !text-heading pulse-animation active:scale-105">
                            <i class="ri-play-fill text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <h2 class="outline-text-two text-6xl sm:text-8xl xl:text-[170px] order-[-1] lg:order-none lg:ms-auto mb-10 xl:mb-0">
            {{ translate('Free Course') }}
        </h2>
    </div>
</div>
