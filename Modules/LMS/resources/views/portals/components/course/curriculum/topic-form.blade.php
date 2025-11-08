<!-- Start Course Topic Modal -->
<div id="addCourseTopic" tabindex="-1"
    class="fixed inset-0 z-modal flex-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full hidden">
    <div class="p-4 w-full max-w-2xl max-h-full">
        <div class="relative bg-white dark:bg-dark-card-two rounded-lg dk-theme-card-square shadow">
            <button type="button" data-modal-hide="addCourseTopic"
                class="absolute top-3 end-2.5 hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center">
                <i class="ri-close-fill text-gray-500 dark:text-dark-text text-xl leading-none"></i>
            </button>
            <div class="max-h-[80vh] overflow-auto">
                <div class="overflow-hidden">
                    <div class="p-4 md:p-5">
                        <div class="pb-4 border-b border-gray-200 dark:border-dark-border">
                            <h6 class="leading-none text-lg font-semibold text-heading" id="topic-header-modal">
                                {{ translate('Add New Topic') }}
                            </h6>
                        </div>
                        <div>
                            <div id="topicTypeList">
                                <labe class="form-label">
                                    {{ translate('Topic type') }}
                                </labe>
                                <select class="singleSelect topic-type-list" name="topic_type" required>
                                    <option selected disabled>{{ translate('Select Type') }}</option>
                                    @foreach (get_all_topic_type() as $topicType)
                                        <option value="{{ $topicType->slug }}">{{ $topicType->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text topic_type_err"></span>
                            </div>
                            <div
                                class="flex-center size-full bg-white dark:bg-dark-card-shade min-h-[300px] absolute inset-0 z-[1000] sniper-loader">
                                <div
                                    class="size-10 rounded-50 animate-spin border-4 border-dashed border-primary-500 border-t-transparent">
                                </div>
                            </div>
                            <div class="form-field-area">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Course Topic Modal -->
