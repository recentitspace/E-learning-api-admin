<button type="button" class="hidden" id="courseTagButton" data-modal-target="courseTag" data-modal-toggle="courseTag">
    {{ translate('Add New') }}
</button>
<!-- Start Add Course Tag Modal -->
<div id="courseTag" class="fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
    <div class="p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
            <button type="button" data-modal-hide="courseTag"
                class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center">
                <i class="ri-close-fill text-gray-500 dark:text-dark-text text-xl leading-none"></i>
            </button>
            <div class="p-4 md:p-5">
                <div class="pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h6 class="leading-none text-lg font-semibold text-heading">{{ translate('Add New Tag') }}</h6>
                </div>
                <form action="{{ $action ?? '#' }}" class="flex flex-col gap-10 mt-6 form">
                    @csrf
                    <input type="hidden" name="modal_type" value="yes">
                    <div>
                        <label for="tag" class="form-label">{{ translate('Name') }} <span class="text-danger"> * </span></label>
                        <input type="text" id="tag" class="form-input" name="name" autocomplete="off" />
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    <div class="flex-center">
                        <button type="submit" class="btn b-solid btn-primary-solid w-1/2 cursor-">
                            {{ translate('Save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Course Tag Modal -->
