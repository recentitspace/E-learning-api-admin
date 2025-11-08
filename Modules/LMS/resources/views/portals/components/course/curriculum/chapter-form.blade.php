<!-- Start Course Chapter Modal -->
<div id="addCourseChapter" tabindex="-1"
    class="hidden fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="p-4 w-full max-w-lg max-h-full">
        <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
            <button type="button" data-modal-hide="addCourseChapter"
                class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center">
                <i class="ri-close-line text-gray-500 dark:text-dark-text text-xl leading-none"></i>
            </button>
            <div class="p-4 md:p-5">
                <div class="pb-4 border-b border-gray-200 dark:border-dark-border">
                    <h6 class="leading-none text-lg font-semibold text-heading" id="model-header">
                        {{ translate('Add New Chapter') }}
                    </h6>
                </div>
                <form action="{{ $action ?? '#' }}" class="flex flex-col gap-4 mt-6 form">
                    <input type="hidden" name="course_id" value="{{ $course->id ?? null }}">
                    <input type="hidden" name="id" id="chapterId">
                    @csrf
                    <div>
                        <label for="chapterTitle" class="form-label">
                            {{ translate('Title') }}
                        </label>
                        <input type="text" id="chapterTitle" class="form-input" name="title" autocomplete="off"
                            placeholder="{{ translate('Enter Chapter Name') }}" />

                        <span class="text-danger error-text  title_err"></span>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="btn b-solid btn-primary-solid cursor-pointer shadow-sm"
                            id="modal-btn">
                            {{ translate('Submit') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Course Chapter Modal -->
