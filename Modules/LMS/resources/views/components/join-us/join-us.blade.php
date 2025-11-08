<div
    class="relative pt-16 sm:pt-24 lg:pt-[120px] pb-24 lg:pb-40 xl:pb-[200px] before:absolute before:size-full before:inset-0 before:bg-video before:blur-[100px] before:opacity-10 overflow-hidden">
    <div class="container relative z-10">
        <div class="grid grid-cols-12 gap-7">
            <div class="col-span-full lg:col-span-7 self-end relative">
                <div class="area-subtitle">
                    {{ translate('Intro') }}
                </div>
                <h2 class="area-title mt-2">
                    {{ translate('Become an ') }}
                    <span class="title-highlight-one">
                        {{ translate('Instructor') }}
                    </span>
                </h2>
                <div class="mt-10 rounded-2xl overflow-hidden">
                    <div class="swiper online-video-slider">
                        <div class="swiper-wrapper">
                            <!-- SINGLE ITEM -->
                            <div class="swiper-slide">
                                <div
                                    class="flex-center relative video-wrapper w-full h-[430px] rounded-2xl overflow-hidden">
                                    <video class="size-full object-cover rounded-2xl cursor-pointer">
                                        <source src="{{ asset('lms/frontend/assets/video/video.mp4') }}"
                                            type="video/mp4">
                                    </video>
                                    <!-- CONTROLLER -->
                                    <div
                                        class="controll-wrapper flex-center size-full bg-[#D9D9D9]/30 rounded-2xl absolute inset-0 [&.hide]:invisible">
                                        <button type="button"
                                            aria-label="Video popup button"
                                            class="controller btn-icon size-[60px] b-solid btn-secondary-icon-solid !text-heading dark:text-white pulse-animation active:scale-105">
                                            <i class="ri-play-fill text-2xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- SINGLE ITEM -->
                            <div class="swiper-slide">
                                <div
                                    class="flex-center relative video-wrapper w-full h-[430px] rounded-2xl overflow-hidden">
                                    <video class="size-full object-cover rounded-2xl cursor-pointer">
                                        <source src="{{ asset('lms/frontend/assets/video/video.mp4') }}"
                                            type="video/mp4">
                                    </video>
                                    <!-- CONTROLLER -->
                                    <div
                                        class="controll-wrapper flex-center size-full bg-[#D9D9D9]/30 rounded-2xl absolute inset-0 [&.hide]:invisible">
                                        <button type="button"
                                            aria-label="Video popup button"
                                            class="controller btn-icon size-[60px] b-solid btn-secondary-icon-solid !text-heading dark:text-white pulse-animation active:scale-105">
                                            <i class="ri-play-fill text-2xl"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- PAGINATION -->
                    <div
                        class="online-video-slider-pagination swiper-custom-pagination absolute w-full z-10 !-bottom-12 hidden lg:flex">
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-5 self-end">
                <div class="bg-white px-7 py-12 text-center rounded-xl shadow-md">
                    <h5 class="area-title text-[24px] font-bold">
                        {{ translate('Join now') }}
                    </h5>
                    <x-theme::form.join-us.form />
                </div>
            </div>
        </div>
    </div>
    <!-- WAVE ANIMATION -->
    <div class="w-full absolute bottom-0 left-0 right-0">
        <img data-src="{{ asset('lms/frontend/assets/images/online-video/wave-two.png') }}" class="w-full" alt="wave-two">
    </div>
</div>
