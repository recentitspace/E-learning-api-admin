<div id="course-content-drawer" class="bg-black/50 fixed size-full inset-0 invisible opacity-0 duration-300 z-[99] lg:bg-transparent lg:visible lg:opacity-100 lg:z-auto">
    <div class="course-content-drawer-inner bg-white p-0 fixed top-[theme('spacing.header')] right-0 rtl:right-auto rtl:left-0 bottom-0 translate-x-full rtl:-translate-x-full lg:translate-x-0 rtl:lg:translate-x-0 shrink-0 flex flex-col w-[19.5rem] xl:w-[28.6rem] lg:p-3 duration-500">
        <div class="px-4 py-4 shadow-md">
            <div class="flex-center-between">
                <h5 class="text-heading dark:text-white font-bold">
                    {{ translate('Course Content') }}
                </h5>
                <div class="lg:hidden">
                    <button type="button" class="course-content-drawer-close size-8 flex-center text-heading"
                        aria-label="Delete course content offcanvas">
                        <i class="ri-close-line"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="border border-border h-full overflow-y-auto">
            <div class="overflow-hidden">
                <div class="space-y-0 overflow-y-auto">
                    <x-theme::course.curriculum-list 
                        :course="$course" 
                        sideBarShow="video-play" 
                        :data="$data" 
                        :auth="$auth" 
                        purchaseCheck="{{ $purchaseCheck ?? false }}" 
                    />
                </div>
            </div>
        </div>
    </div>
</div>
