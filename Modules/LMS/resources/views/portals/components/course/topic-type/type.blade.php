@php
    $topicRoute = 'topic.store';
    $assignmentRoute = 'assignment.file.delete';
    if (isInstructor()) {
        $topicRoute = 'instructor.topic.store';
        $assignmentRoute = 'instructor.assignment.file.delete';
    } elseif (isOrganization()) {
        $topicRoute = 'organization.topic.store';
        $assignmentRoute = 'organization.assignment.file.delete';
    }
@endphp

<form action="{{ route($topicRoute) }}" class="flex flex-col form pb-4" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="topic_type_id" value="{{ $topicId }}" />
    <input type="hidden" name="course_id" value="{{ $courseId }}" />
    <input type="hidden" name="topic_type" value="{{ $type }}">

    @if ($actionType)
        <label class="block mt-2 font-medium text-gray-500 dark:text-dark-text"> {{ translate('Topic type') }}
            <b>{{ $type }}</b></label>
    @endif
    <div class="mt-4">
        <label class="form-label">{{ translate('Chapter') }} <span class="text-danger">*</span></label>
        <select class="singleSelect2" name="chapter_id" required>
            <option disabled selected>{{ translate('Select Chapter') }}</option>
            @foreach ($chapters as $chapter)
                <option value="{{ $chapter->id }}"
                    {{ isset($chapterId) ? ($chapterId == $chapter->id ? 'selected' : '') : '' }}>
                    {{ $chapter->title }}
                </option>
            @endforeach
        </select>
        <span class="text-danger error-text chapter_id_err"></span>
    </div>
    <!-- FOR VIDEO TYPE -->
    @if ($type == 'video')
        @if (!empty($topic))
            <input type="hidden" name="video_id" value="{{ $topic?->topicable?->id }}" />
        @endif
        <div class="mt-4">
            <label for="v-title" class="form-label">{{ translate('Title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" id="v-title" class="form-input" name="title"
                value="{{ !empty($topic) ? $topic?->topicable?->title : '' }}" placeholder="{{ translate('Title') }}"
                autocomplete="off" />
            <span class="text-danger error-text title_err"></span>
        </div>
        <div id="courseTopicVideoDuration" class="mt-4">
            <label for="v-dutation" class="form-label"> {{ translate('Duration') }}</label>
            <input type="text" id="v-dutation" class="form-input"
                value="{{ !empty($topic) ? $topic?->topicable?->duration : '00:00:00' }}" name="duration"
                autocomplete="off" />
            <p class="text-xs leading-none text-gray-900 mt-2">{{ translate('Please follow the pattern') }} <span
                    class="text-gray-500 dark:text-dark-text">({{ translate('hh') }}:{{ translate('mm') }}:{{ translate('ss') }})</span>
            </p>

            <span class="text-danger error-text duration_err"></span>
        </div>
        <div class="mt-4">

            @php
                $sourceType = $topic?->topicable?->video_src_type ?? '';
            @endphp

            <label class="form-label">{{ translate('Video Source') }} <span class="text-danger">*</span></label>
            <select class="singleSelect2 source-type-select" name="video_src_type" required>
                <option disabled selected> {{ translate('Select Video Source') }}</option>
                <option value="youtube" {{ $sourceType == 'youtube' ? 'selected' : '' }}>{{ translate('Youtube') }}
                </option>
                <option value="vimeo" {{ $sourceType == 'vimeo' ? 'selected' : '' }}>{{ translate('Vimeo') }}
                </option>
                <option value="local" {{ $sourceType == 'local' ? 'selected' : '' }}>{{ translate('Local') }}
                </option>
            </select>
            <span class="text-danger error-text video_src_type_err"></span>
        </div>
        <div class="mt-4" id="courseTopicVideoFile">
            @if (!empty($topic))
                <div class="video mt-4">
                    @if ($topic?->topicable?->video_src_type == 'local')
                        @if (fileExists($folder = 'lms/courses/topics/videos', $fileName = $topic?->topicable?->system_video) == true &&
                                $topic?->topicable?->system_video !== '')
                            <video width="320" height="240" controls autoplay>
                                <source
                                    src="{{ asset('storage/lms/courses/topics/videos/' . $topic?->topicable?->system_video) }}">
                            </video>
                        @endif
                    @else
                        <label for="v-url" class="form-label"> {{ translate('Video Url') }} </label>
                        <input type="url" id="v-url" class="form-input"
                            placeholder="{{ translate('Video Url') }}"
                            value="{{ !empty($topic) ? $topic?->topicable?->video_url : '' }}" name="video_url"
                            autocomplete="off" />
                    @endif
                </div>
            @endif

        </div>
    @endif
    <!-- FOR READING TYPE -->
    @if ($type == 'reading')
        @if (!empty($topic))
            <input type="hidden" name="reading_id" value="{{ $topic?->topicable?->id }}" />
        @endif
        <div class="mt-4">
            <label for="v-title" class="form-label">{{ translate('Title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" id="v-title" class="form-input" placeholder="{{ translate('Title') }}"
                name="title" value="{{ $topic?->topicable?->title ?? '' }}" />
            <span class="text-danger error-text title_err"></span>
        </div>
        <div class="mt-4">
            <label class="form-label">{{ translate('Description') }} <span class="text-danger">*</span></label>
            <textarea name="description" class="summernote">{!! clean($topic?->topicable?->description ?? '') !!}</textarea>
            <span class="text-danger error-text description_err"></span>
        </div>
    @endif
    <!-- FOR ASSIGNMENT TYPE -->

    @if ($type == 'assignment')
        @if (!empty($topic))
            <input type="hidden" name="assignment_id" value="{{ $topic?->topicable?->id }}" />
        @endif
        <div class="mt-4">
            <label for="assignment-title" class="form-label">{{ translate('Title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" id="assignment-title" class="form-input" name="title" placeholder="Title"
                autocomplete="off" value="{{ !empty($topic) ? $topic?->topicable?->title : '' }}" />
            <span class="text-danger error-text title_err"></span>
        </div>
        <div class="mt-4">
            <label class="form-label">{{ translate('Instruction') }} <span class="text-danger">*</span></label>
            <textarea name="description" class="summernote">{!! clean($topic?->topicable?->description ?? '') !!}</textarea>
            <span class="text-danger error-text description_err"></span>
        </div>

        <div class="mt-4">
            <label class="form-label">{{ translate('Total Mark') }}</label>
            <input type="number" class="form-input" name="total_mark" autocomplete="off"
                value="{{ !empty($topic) ? $topic?->topicable?->total_mark : '' }}" />
            <span class="text-danger error-text total_mark_err"></span>
        </div>
        <div class="mt-4">
            <label class="form-label">{{ translate('Pass Mark') }}</label>
            <input type="number" class="form-input" name="pass_mark" autocomplete="off"
                value="{{ !empty($topic) ? $topic?->topicable?->pass_mark : '' }}" />
            <span class="text-danger error-text pass_mark_err"></span>
        </div>

        <div class="mt-4">
            <label class="form-label"> {{ translate('Retake Number') }}</label>
            <input type="number" class="form-input" name="retake_number"
                placeholder="{{ translate('Retake Number') }}" autocomplete="off"
                value="{{ !empty($topic) ? $topic?->topicable?->retake_number : '' }}" />
            <span class="text-danger error-text retake_number_err"></span>
        </div>
        <div class="mt-4" id="assignmentSubmitDate">
            <label for="sub-date" class="form-label"> {{ translate('Submission Date') }} <span
                    class="text-danger">*</span></label>
            <input type="datetime-local" id="sub-date" class="form-input" name="submission_date"
                placeholder="{{ translate('Submit Date') }}" autocomplete="off"
                value="{{ !empty($topic) ? $topic?->topicable?->submission_date : '' }}" />
            <span class="text-danger error-text submission_date_err"></span>
        </div>

        <div class="mt-4">
            <label for="assignment-duration" class="form-label"> {{ translate('Duration') }}</label>
            <input type="text" id="assignment-duration" name="duration" class="form-input"
                value="{{ !empty($topic) ? $topic?->topicable?->duration : '00:00:00' }}" />
            <p class="text-xs leading-none text-gray-900 mt-2"> {{ translate('Please follow the pattern') }} <span
                    class="text-gray-500 dark:text-dark-text">({{ translate('hh') }}:{{ translate('mm') }}:{{ translate('ss') }})</span>
            </p>
            <span class="text-danger error-text duration_err"></span>
        </div>
        <div class="mt-4">
            <label for="source_files" class="form-label"> {{ translate('Source Files') }} <span
                    class="text-danger">*</span></label>
            <input type="file" id="source_files" class="form-input" name="source_files[]" multiple />
            <span class="text-danger error-text source_files_err"></span>

            @if (!empty($topic))
                @if ($topic?->topicable?->sourceFiles->count() > 0)
                    <ul>
                        @foreach ($topic?->topicable?->sourceFiles as $sourceFile)
                            @if (fileExists($folder = 'lms/courses/topics/assignments', $fileName = $sourceFile->file) == true &&
                                    $sourceFile->file !== '')
                                <li class="img-thumb-wrapper">
                                    <span> {{ $sourceFile->file }}</span>
                                    <button type="button"
                                        class="btn-icon size-8 btn-danger-icon-light multiple-image-remove"
                                        data-action="{{ route($assignmentRoute, $sourceFile->id) }}">
                                        <i class="ri-close-line text-inherit text-base"></i>
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endif
        </div>
    @endif

    <!-- FOR SUPPLYMENT TYPE -->
    @if ($type == 'supplement')
        @if (!empty($topic))
            <input type="hidden" name="supplement_id" value="{{ $topic?->topicable?->id }}" />
        @endif
        <div class="mt-4">
            <label for="supplyment-title" class="form-label"> {{ translate('Title') }} <span
                    class="text-danger">*</span></label>
            <input type="text" id="supplyment-title" name="title" class="form-input" autocomplete="off"
                value="{{ $topic?->topicable?->title ?? '' }}" />
            <span class="text-danger error-text title_err"></span>
        </div>
        <div class="mt-4">
            <label class="form-label">{{ translate('Description') }} <span class="text-danger">*</span></label>
            <textarea name="description" class="summernote">{!! clean($topic?->topicable?->description ?? '') !!}</textarea>
            <span class="text-danger error-text description_err"></span>
        </div>
        <div class="mt-4">
            <label for="supplyment-duration" class="form-label"> {{ translate('Duration') }}</label>
            <input type="text" id="supplyment-duration" class="form-input" name="duration"
                value=" {{ $topic?->topicable?->duration ?? '00:00:00' }}  " autocomplete="off" />
            <p class="text-xs leading-none text-gray-900 mt-2"> {{ translate('Please follow the pattern') }} <span
                    class="text-gray-500 dark:text-dark-text">({{ translate('hh') }}:{{ translate('mm') }}:{{ translate('ss') }})</span>
            </p>
            <span class="text-danger error-text duration_err"></span>
        </div>
    @endif

    @if ($type == 'quiz')

        @if (!empty($topic))
            <input type="hidden" name="quiz_id" value="{{ $topic?->topicable?->id }}" />
        @endif
        <!-- FOR QUIZ TYPE -->
        <div class="mt-4">
            <label class="form-label"> {{ translate('Quiz Type') }} <span class="text-danger">*</span></label>
            <select class="singleSelect2" name="quiz_type_id" required>
                <option selected disabled>{{ translate('Select Type') }}</option>
                @foreach (get_all_quiz_type() as $quizType)
                    <option value="{{ $quizType->id }}"
                        {{ !empty($topic) ? ($topic?->topicable?->quiz_type_id == $quizType->id ? 'selected' : '') : '' }}>
                        {{ $quizType->name }}</option>
                @endforeach
            </select>
            <span class="text-danger error-text quiz_type_id_err"></span>
        </div>
        <div class="mt-4">
            <label for="quiz-title" class="form-label"> {{ translate('Quiz Title') }}<span
                    class="text-danger">*</span></label>
            <input type="text" id="quiz-title" class="form-input" autocomplete="off" name="title"
                value="{{ $topic?->topicable?->title ?? '' }}" />
            <span class="text-danger error-text title_err"></span>
        </div>
        <div class="mt-4">
            <label for="quiz-dutation" class="form-label"> {{ translate('Quiz Duration') }}<span
                    class="text-danger">*</span></label>
            <input type="text" id="quiz-dutation" class="form-input" name="duration"
                value="{{ $topic?->topicable?->duration ?? '' }}" />
            <p class="text-xs leading-none text-gray-900 mt-2">{{ translate('Please follow the pattern') }} <span
                    class="text-gray-500 dark:text-dark-text">{{ translate('minute') }}({{ translate('m') }})</span>
            </p>
            <span class="text-danger error-text duration_err"></span>
        </div>
        <div class="mt-4">
            <label for="quiz-total-mark" class="form-label"> {{ translate('Quiz Total Mark') }} <span
                    class="text-danger">*</span></label>
            <input type="number" id="quiz-total-mark" class="form-input" name="total_mark"
                value="{{ $topic?->topicable?->total_mark ?? '' }}" autocomplete="off" />
            <span class="text-danger error-text total_mark_err"></span>
        </div>
        <div class="mt-4">
            <label for="quiz-pass-mark" class="form-label"> {{ translate('Quiz Pass Mark') }} <span
                    class="text-danger">*</span></label>
            <input type="number" id="quiz-pass-mark" class="form-input" name="pass_mark" autocomplete="off"
                value="{{ $topic?->topicable?->pass_mark ?? '' }}" />
            <span class="text-danger error-text pass_mark_err"></span>
        </div>
        <div class="mt-4">
            <label for="quiz-attempt" class="form-label">{{ translate('Quiz Attempt') }}</label>
            <input type="number" id="quiz-attempt" class="form-input" name="total_retake" autocomplete="off"
                value="{{ $topic?->topicable?->total_retake ?? '' }}" />
            <span class="text-danger error-text total_retake_err"></span>
        </div>
        <div class="mt-4" id="quizExpireDate">
            <label for="expire-date" class="form-label">{{ translate('Quiz Expire Date') }}</label>
            <input type="datetime-local" id="expire-date" class="form-input"
                placeholder="{{ translate('Expire Date') }}" name="expire_date"
                value="{{ $topic?->topicable?->expire_date ?? '' }}" />
            <span class="text-danger error-text expire_date_err"></span>
        </div>
        <div class="mt-4">
            <label for="quiz-instruction" class="form-label">{{ translate('Quiz Instruction') }}</label>
            <textarea name="instruction" class="form-input summernote">{!! clean($topic?->topicable?->instruction ?? '') !!}</textarea>
            <span class="text-danger error-text instruction_err"></span>
        </div>
    @endif
    <div class="flex-center mt-4">
        <button type="submit" class="btn b-solid btn-primary-solid w-1/2">
            {{ !empty($topic) ? translate('Edit Topic') : translate('Add Topic') }} </button>
    </div>
</form>


<script src="{{ asset('lms/assets/js/vendor/summernote.min.js') }}"></script>
<script src="{{ asset('lms/assets/js/vendor/select2.min.js') }} "></script>

<script>
    $(function() {

        $(".singleSelect2").select2({
            width: "100%",
        });

        $(".summernote").summernote({
            placeholder: "{{ translate('Write your description here') }}...",
            height: 220,
            toolbar: [
                ["style", ["style"]],
                ["fontsize", ["fontsize"]],
                ["font", ["bold", "italic", "underline", "clear"]],
                ["fontname", ["fontname"]],
                ["color", ["color"]],
                ["para", ["paragraph"]],
                ["height", ["height"]],
                ["insert", ["hr", "link"]],
            ],
            styleTags: ["p", "h1", "h2", "h3", "h4", "h5", "h6"],
            lineHeights: ["0.5", "1.0", "1.1", "1.2", "1.3", "1.4"],
            fontSizes: [
                "8",
                "9",
                "10",
                "11",
                "12",
                "13",
                "14",
                "15",
                "16",
                "18",
                "24",
                "36",
                "48",
                "64",
                "82",
                "150",
            ],
        });

        $(document).on('change', '.source-type-select', function() {

            if ($(this).val() !== "local") {
                $("#courseTopicVideoFile").html(`
                  <label for="v-url" class="form-label"> {{ translate('Video Url') }} </label>  
                  <input type="text" id="v-url" class="form-input" placeholder="{{ translate('Video Url') }}"  name="video_url"  value="{{ $video_url ?? '' }}"  autocomplete="off" />
                 `)
            } else {

                $("#courseTopicVideoFile").html(
                    `<label for="v-url" class="form-label">{{ translate('Upload File') }}</label><div class="border border-input-border rounded-md px-2 py-1.5">
                    <input type="file" id="v-url" class="w-full" name="video"> </div> <span class="text-danger error-text video_err"></span> 
                    
                    
                    @if (!empty($topic))
                    <div class="video mt-4">
                        @if (fileExists($folder = 'lms/courses/topics/videos', $fileName = $topic?->topicable?->system_video) == true &&
                                $topic?->topicable?->system_video !== '')
                            <video width="320" height="240" controls autoplay>
                                <source
                                    src="{{ asset('storage/lms/courses/topics/videos/' . $topic?->topicable?->system_video) }}">
                            </video>
                        @endif
                    </div>
                @endif
                    
                    `
                );
            }
        })
    })
</script>
