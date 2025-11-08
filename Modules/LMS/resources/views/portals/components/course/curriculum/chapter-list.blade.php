@php
    $chapterEdit = 'chapter.edit';
    $chapterDelete = 'chapter.destroy';
    $topicDelete = 'topic.destroy';
    if (isInstructor()) {
        $chapterEdit = 'instructor.chapter.edit';
        $chapterDelete = 'instructor.chapter.destroy';
        $topicDelete = 'instructor.topic.destroy';
    } elseif (isOrganization()) {
        $chapterEdit = 'organization.chapter.edit';
        $chapterDelete = 'organization.chapter.destroy';
        $topicDelete = 'organization.topic.destroy';
    }
@endphp


@if (isset($course, $course->chapters) && !empty($course->chapters))
    <div class="space-y-10 mt-7 pt-0.5">
        <div id="chapterList">
            @foreach ($course->chapters as $key => $chapter)
                <!-- Start Chapter List -->
                <div class="leading-none mt-5 dk-border-one bg-gray-200/50 dark:bg-dark-body p-5 rounded-lg dk-theme-card-square chapter-item"
                    data-item-id="{{ $chapter->id }}">
                    <div class="flex-center-between">
                        <h6 class="text-gray-500 dark:text-dark-text text-lg font-semibold">
                            {{ $chapter->title }}
                        </h6>
                        <div class="flex items-center gap-2">
                            <button type="button"
                                class="btn shadow-md b-outline btn-info-outline cursor-move dragable-btn"
                                title="{{ translate('Sort Chapter') }}">
                                <i class="ri-drag-move-2-fill text-inherit"></i>
                            </button>
                            <button type="button"
                                class="btn b-outline-static btn-primary-outline shadow-md edit-chapter"
                                data-modal-target="addCourseChapter" data-modal-toggle="addCourseChapter"
                                data-action="{{ route($chapterEdit, $chapter->id) }}"
                                title="{{ translate('Edit Chapter') }}">
                                <i class="ri-edit-2-fill text-inherit"></i>
                            </button>
                            <button type="button"
                                class="btn b-outline-static btn-danger-outline shadow-md delete-btn-cs"
                                data-action="{{ route($chapterDelete, $chapter->id) }}"
                                title="{{ translate('Delete Chapter') }}">
                                <i class="ri-delete-bin-line text-inherit"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Topic List -->
                    <ul
                        class="*:leading-none *:p-3 *:rounded-10 *:dk-border-two space-y-5 mt-10 *:dk-theme-card-square topicList">
                        @foreach ($chapter->topics as $topic)
                            @if ($topic?->topicable?->topic_type?->slug == 'reading')
                                <li class="flex-center-between cursor-move topic-item"
                                    data-item-id="{{ $topic->id }}">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="size-8 rounded-50 bg-primary-200 dark:bg-dark-icon text-heading dark:text-white flex-center">
                                            <i class="ri-book-line text-[14px] text-inherit"></i>
                                        </div>
                                        <h6 class="text-heading dark:text-white font-bold">
                                            {{ ucfirst($topic?->topicable?->topic_type?->slug) }}
                                            :</h6>
                                        <h6 class="text-gray-500 dark:text-dark-text text-lg font-medium">
                                            <span class="text-gray-900 font-normal">
                                                {{ $topic?->topicable?->title }}
                                        </h6>
                                    </div>
                                    <div class="flex items-center gap-1.5">

                                        <!-- Edit Topic -->
                                        <button type="button" class="btn-icon btn-primary-icon-light size-8 topic-edit"
                                            data-modal-target="addCourseTopic" data-modal-toggle="addCourseTopic"
                                            data-topic-id="{{ $topic->id }}"
                                            data-topic-type="{{ $topic?->topicable?->topic_type?->slug }}"
                                            data-chapter-id="{{ $topic?->chapter_id }}">
                                            <i class="ri-pencil-fill text-inherit text-base"></i>
                                        </button>
                                        <!-- Delete Topic -->
                                        <button type="button"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route($topicDelete, $topic->id) }}">
                                            <i class="ri-close-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </li>
                            @endif

                            @if ($topic?->topicable?->topic_type?->slug == 'supplement')
                                <li class="flex-center-between cursor-move topic-item"
                                    data-item-id="{{ $topic->id }}">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="size-8 rounded-50 bg-primary-200 dark:bg-dark-icon text-heading dark:text-white flex-center">
                                            <i class="ri-book-line text-[14px] text-inherit"></i>
                                        </div>
                                        <h6 class="text-heading dark:text-white font-bold">
                                            {{ ucfirst($topic?->topicable?->topic_type?->slug) }}
                                            :</h6>
                                        <h6 class="text-gray-500 dark:text-dark-text text-lg font-medium">
                                            <span class="text-gray-900 font-normal">
                                                {{ $topic?->topicable?->title }}
                                        </h6>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        <!-- Edit Topic -->
                                        <button type="button" class="btn-icon btn-primary-icon-light size-8 topic-edit"
                                            data-modal-target="addCourseTopic" data-modal-toggle="addCourseTopic"
                                            data-topic-id="{{ $topic->id }}"
                                            data-topic-type="{{ $topic?->topicable?->topic_type?->slug }}"
                                            data-chapter-id="{{ $topic?->chapter_id }}">
                                            <i class="ri-pencil-fill text-inherit text-base"></i>
                                        </button>
                                        <!-- Delete Topic -->
                                        <button type="button"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route($topicDelete, $topic->id) }}">
                                            <i class="ri-close-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </li>
                            @endif

                            @if ($topic?->topicable?->topic_type?->slug == 'assignment')
                                <li class="flex-center-between cursor-move topic-item"
                                    data-item-id="{{ $topic->id }}">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="size-8 rounded-50 bg-primary-200 dark:bg-dark-icon text-heading dark:text-white flex-center">
                                            <i class="ri-file-pdf-2-line text-[14px] text-inherit"></i>
                                        </div>
                                        <h6 class="text-heading dark:text-white font-bold">
                                            {{ ucfirst($topic?->topicable?->topic_type?->slug) }}
                                            :</h6>
                                        <h6 class="text-gray-500 dark:text-dark-text text-lg font-medium">
                                            <span class="text-gray-900 font-normal">
                                                {{ $topic?->topicable?->title }}
                                        </h6>
                                    </div>
                                    <div class="flex items-center gap-1.5">


                                        <!-- Edit Topic -->
                                        <button type="button" class="btn-icon btn-primary-icon-light size-8 topic-edit"
                                            data-modal-target="addCourseTopic" data-modal-toggle="addCourseTopic"
                                            data-topic-id="{{ $topic->id }}"
                                            data-topic-type="{{ $topic?->topicable?->topic_type?->slug }}"
                                            data-chapter-id="{{ $topic?->chapter_id }}">
                                            <i class="ri-pencil-fill text-inherit text-base"></i>
                                        </button>
                                        <!-- Delete Topic -->
                                        <button type="button"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route($topicDelete, $topic->id) }}">
                                            <i class="ri-close-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </li>
                            @endif

                            @if ($topic?->topicable?->topic_type?->slug == 'video')
                                <li class="flex-center-between cursor-move topic-item"
                                    data-item-id="{{ $topic->id }}">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="size-8 rounded-50 bg-primary-200 dark:bg-dark-icon text-heading dark:text-white flex-center">
                                            <i class="ri-video-line text-[14px] text-inherit"></i>
                                        </div>
                                        <h6 class="text-heading dark:text-white font-bold">
                                            {{ ucfirst($topic?->topicable?->topic_type?->slug) }}
                                            :</h6>
                                        <h6 class="text-gray-500 dark:text-dark-text text-lg font-medium">
                                            <span class="text-gray-900 font-normal">
                                                {{ $topic?->topicable?->title }}
                                        </h6>
                                    </div>
                                    <div class="flex items-center gap-1.5">

                                        <!-- Edit Topic -->
                                        <button type="button" class="btn-icon btn-primary-icon-light size-8 topic-edit"
                                            data-modal-target="addCourseTopic" data-modal-toggle="addCourseTopic"
                                            data-topic-id="{{ $topic->id }}"
                                            data-topic-type="{{ $topic?->topicable?->topic_type?->slug }}"
                                            data-chapter-id="{{ $topic?->chapter_id }}">
                                            <i class="ri-pencil-fill text-inherit text-base"></i>
                                        </button>
                                        <!-- Delete Topic -->
                                        <button type="button"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route($topicDelete, $topic->id) }}">
                                            <i class="ri-close-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </li>
                            @endif

                            @if ($topic?->topicable?->topic_type?->slug == 'quiz')
                                <li class="flex-center-between cursor-move topic-item"
                                    data-item-id="{{ $topic->id }}">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="size-8 rounded-50 bg-primary-200 dark:bg-dark-icon text-heading dark:text-white flex-center">
                                            <i class="ri-questionnaire-line text-[14px] text-inherit"></i>
                                        </div>
                                        <h6 class="text-heading dark:text-white font-bold">
                                            {{ ucfirst($topic?->topicable?->topic_type?->slug) }}
                                            :</h6>
                                        <h6 class="text-gray-500 dark:text-dark-text text-lg font-medium">
                                            <span class="text-gray-900 font-normal">
                                                {{ $topic?->topicable?->title }}
                                        </h6>
                                    </div>
                                    <div class="flex items-center gap-1.5">

                                        <button type="button"
                                            class="btn-icon size-8 btn-primary-icon-light add-question"
                                            data-modal-target="editQuiz" data-modal-toggle="editQuiz"
                                            title='{{ translate('Add Question') }}'
                                            data-id="{{ $topic?->topicable?->id }}">
                                            <i class="ri-questionnaire-line text-[14px] text-inherit"></i>
                                        </button>
                                        <button type="button"
                                            class="btn-icon size-8 btn-primary-icon-light view-question"
                                            data-modal-target="questionViewList" data-modal-toggle="questionViewList"
                                            title='{{ translate('View Question') }}'
                                            data-id="{{ $topic?->topicable?->id }}">
                                            <i class="ri-eye-line text-[14px] text-inherit"></i>

                                        </button>
                                        <!-- Edit Topic -->
                                        <button type="button"
                                            class="btn-icon btn-primary-icon-light size-8 topic-edit"
                                            data-modal-target="addCourseTopic" data-modal-toggle="addCourseTopic"
                                            data-topic-id="{{ $topic->id }}"
                                            data-topic-type="{{ $topic?->topicable?->topic_type?->slug }}"
                                            data-chapter-id="{{ $topic?->chapter_id }}">
                                            <i class="ri-pencil-fill text-inherit text-base"></i>
                                        </button>
                                        <!-- Delete Topic -->
                                        <button type="button"
                                            class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route($topicDelete, $topic->id) }}">
                                            <i class="ri-close-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endif
