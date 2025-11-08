<!-- Start Edit Quiz Modal -->
<div id="questionViewList" tabindex="-1"
    class="fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
    <div class="p-4 w-full max-w-3xl max-h-full">
        <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
            <button type="button" data-modal-hide="questionViewList"
                class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center">
                <i class="ri-close-fill text-gray-500 dark:text-dark-text text-xl leading-none"></i>
            </button>
            <div class="p-4 md:p-5">
                <div class="flex-center size-full bg-white dark:bg-dark-body min-h-[300px] my-3 sniper-loader">
                    <div
                        class="size-10 rounded-50 animate-spin border-4 border-dashed border-primary-500 border-t-transparent">
                    </div>
                </div>
                <div id="questionItem">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Quiz Modal -->
