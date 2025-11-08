<div class="pt-16 sm:pt-24 lg:pt-[120px] mb-[-300px] relative z-[2]">
    <div class="container">
        <div class="bg-[#17423B] md:bg-[url('/lms/frontend/assets/images/cta/bg.png')] bg-no-repeat bg-contain bg-right rounded-2xl px-5 xl:px-[90px] rtl:rotate-xz-180">
            <div class="grid grid-cols-12 gap-7 rtl:rotate-xz-180">
                <div class="col-span-full md:col-span-8 lg:col-span-6">
                    <div class="py-7 xl:py-[80px]">
                        <h2 class="area-title text-white">
                            {{ translate('Where Every Child Shines -') }}
                            <span class="title-highlight-two !text-secondary">{{ translate('Admission Open') }}!</span>
                        </h2>
                        <div class="flex items-center flex-wrap gap-2 mt-8">
                            <a href="{{ route('course.list') }}"
                                class="btn b-solid btn-primary-solid btn-lg !text-[16px] font-bold"
                                aria-label="Enroll now">
                                {{ translate('Enroll Now') }}!
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
