@php
    $questionStore = 'quiz-question.store';
    $questionEdit = 'quiz-question.edit';
    $quizDelete = 'quiz-question.destroy';
    if (isInstructor()) {
        $questionStore = 'instructor.quiz-question.store';
        $questionEdit = 'instructor.quiz-question.edit';
        $questionDelete = 'instructor.quiz-question.destroy';
    } elseif (isOrganization()) {
        $questionStore = 'organization.quiz-question.store';
        $questionEdit = 'organization.quiz-question.edit';
        $questionDelete = 'organization.quiz-question.destroy';
    }
@endphp


@if ($mode == 'edit')
    <div class="pb-4 border-b border-gray-200">
        <h6 class="leading-none text-lg font-semibold text-heading">
            <button type="button" aria-label="Edit quiz question"
                class="btn b-solid btn-sm btn-primary-solid view-question mt-3 shadow-md"
                data-id="{{ $quizQuestion?->quiz_id }}">
                <i class="ri-arrow-left-s-line text-inherit"></i>
                {{ translate('Back') }}
            </button>
            {{ translate('Edit Question') }}
        </h6>
    </div>
    <form action="{{ route($questionStore) }}" class="flex flex-col gap-10 mt-6 form" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $quizQuestion->id }}">
        <input type="hidden" name="quiz_id" value="{{ $quizQuestion?->quiz_id }}">
        <div class="max-h-[80vh] overflow-auto">
            <div class="overflow-hidden">
                <div class="relative">
                    <label for="quiz-question" class="form-label">{{ translate('Question Title') }}</label>
                    <textarea name="title" rows="1" id="searchInput" data-search-type="question"
                        class="form-input search-suggestion"> {!! $quizQuestion?->question?->name !!} </textarea>
                    <div class="search-show"></div>
                    <span class="text-danger error-text title_err"></span>
                </div>
                <div class="mt-4">
                    <label for="quiz-grade" class="form-label">{{ translate('Quiz Mark') }}</label>
                    <input type="number" name="mark" value="{!! $quizQuestion->mark !!}" id="quiz-grade"
                        class="form-input"></input>
                    <span class="text-danger error-text mark_err"></span>
                </div>
                <div class="mt-4">
                    <label class="form-label">{{ translate('Quiz Type') }}</label>
                    <select class="singleSelect2 quiz-type-list" name="question_type" required>
                        <option selected disabled>{{ translate('Select quiz Question type') }}</option>
                        <option value="multiple-choice"
                            {{ $quizQuestion->question_type == \Modules\LMS\Enums\QuestionTypes::MULTIPLE ? 'selected' : '' }}>
                            {{ translate('Multiple choice') }}
                        </option>
                        <option value="single-choice"
                            {{ $quizQuestion->question_type == \Modules\LMS\Enums\QuestionTypes::SINGLE ? 'selected' : '' }}>
                            {{ translate('Single choice') }}
                        </option>
                        <option value="fill-in-blank"
                            {{ $quizQuestion->question_type == \Modules\LMS\Enums\QuestionTypes::FILL_IN_BLANK ? 'selected' : '' }}>
                            {{ translate('Fill in the blank') }}
                        </option>
                    </select>
                    <span class="text-danger error-text question_type_err"></span>
                </div>
                <div class="answer-list-area">
                    @if ($quizQuestion->question_type == \Modules\LMS\Enums\QuestionTypes::FILL_IN_BLANK)
                        @php
                            $list = [];
                            foreach ($quizQuestion->questionAnswers as $questionAnswer) {
                                $list[] = $questionAnswer?->answer?->name;
                            }
                        @endphp
                        <div class="mt-10 mb-11">
                            <label for="quiz-grade" class="form-label">
                                {{ translate('Select the word in your question you want to appear in blank') }}
                                (_______).
                            </label>
                            <input type="text" class="form-input choices-input" name="answers[]"
                                value="{{ implode(',', $list) }}">
                        </div>
                        <script>
                            var choiseInput = document.querySelectorAll(".choices-input");
                            choiseInput.forEach((input) => {
                                var example = new Choices(input, {
                                    removeItemButton: true,
                                    maxItemCount: 3,
                                    duplicateItemsAllowed: false,
                                    allowHTML: true,
                                    searchEnabled: true,
                                });
                            });
                        </script>
                    @else
                        <button type="button" aria-label="Add quiz answer option"
                            class="btn b-solid btn-primary-solid addQuizAns mt-3"
                            data-quiztype="{{ $quizQuestion->question_type }}"> {{ translate('Add Answer') }}
                        </button>
                        <ul class="flex flex-col gap-2 mt-5 quiz-ans-container"
                            data-length="{{ $quizQuestion?->questionAnswers?->count() }}">
                            @foreach ($quizQuestion->questionAnswers as $index => $questionAnswer)
                                <li class="border border-input-border rounded-lg p-2 removeable-parent">
                                    <div class="flex gap-2 relative">
                                        <textarea name="answers[{{ $index }}][name]" placeholder="Option 1" id="searchInput" data-search-type="answer"
                                            class="form-input search-suggestion" rows="1"> {!! $questionAnswer?->answer?->name !!}</textarea>

                                        <button type="button" aria-label="Remove option button"
                                            class="btn b-outline btn-danger-outline btn-sm max-h-10 remove-parent-button">
                                            <i class="ri-close-line text-inherit text-[13px]"></i>
                                        </button>
                                        <div class="search-show"></div>
                                    </div>
                                    <div class="leading-none flex items-center gap-2 mt-2">
                                        <label for="corrects{{ $index }}"
                                            class="inline-flex items-center cursor-pointer">
                                            @if ($quizQuestion->question_type == \Modules\LMS\Enums\QuestionTypes::MULTIPLE)
                                                <input type="checkbox" id="corrects{{ $index }}"
                                                    name="answers[{{ $index }}][correct]"
                                                    class="appearance-none peer"
                                                    {{ $questionAnswer->correct == 1 ? 'checked' : '' }}>
                                                <div class="switcher switcher-primary-solid"></div>
                                            @else
                                                <input type="radio" id="corrects{{ $index }}"
                                                    name="answers[{{ $index }}][correct]"
                                                    class="radio radio-primary"
                                                    {{ $questionAnswer->correct == 1 ? 'checked' : '' }}>
                                            @endif
                                        </label>
                                        <div class="text-gray-500 font-medium inline-block">
                                            {{ translate('Check if this is Correct') }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="flex-center">
            <button type="submit" aria-label="Update quiz"
                class="btn b-solid btn-primary-solid w-1/2">{{ translate('Update Quiz') }}</button>
        </div>
    </form>
    <script src="{{ asset('lms/assets/js/vendor/select2.min.js') }} "></script>

    <script>
        //===================== quiz type list

        $(document).on('change', '.quiz-type-list', function() {

            let ansList = $(".answer-list-area").html("");
            let quizType = $(this).val();
            if (quizType == "multiple-choice" || quizType == 'single-choice') {
                $(ansList).html(`<div class="mt-10">
                    <button type="button" aria-label="Add quiz answer option" class="btn b-solid btn-primary-solid addQuizAns" data-quiztype="${quizType}"> {{ translate('Add Answer') }} </button>
                    <ul class="flex flex-col gap-2 mt-5 quiz-ans-container" data-length="1">
                        <li class="border border-input-border rounded-lg p-2 removeable-parent">
                            <div class="flex gap-2 relative">
                                <textarea name="answers[0][name]" placeholder=" {{ translate('Option') }} 1" id="searchInput" data-search-type="answer" class="form-input search-suggestion" rows="1"></textarea>

                                <button type="button"
                                    aria-label="Remove option button"
                                    class="btn b-outline btn-danger-outline btn-sm max-h-10 remove-parent-button">
                                    <i class="ri-close-line text-inherit text-[13px]"></i>
                                </button>
                                <div class="search-show"></div>
                            </div>
                            <div class="leading-none flex items-center gap-2 mt-2">
                                <label for="corrects1" class="inline-flex items-center cursor-pointer">
                                    ${ quizType == "multiple-choice" ? '<input type="checkbox" id="corrects1" name="answers[0][correct]" class="appearance-none peer"> <div class="switcher switcher-primary-solid"></div>' : '<input type="radio"   id="correntans1" name="answers[0][correct]" class="radio radio-primary">' }

                                </label>
                                <div class="text-gray-500 font-medium inline-block">
                                    {{ translate('Check if this is Correct') }}
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>`)
            } else if (quizType == "fill-in-blank") {
                $(ansList).html(`
                <div class="mt-10 mb-11">
                    <label for="quiz-grade" class="form-label"> {{ translate('Select the word in your question you want to appear in blank') }} (_______).
                    </label>
                    <input type="text" class="form-input choices-input" name="answers[]" >
                </div>`)
                choicesInput()
            }
        })

        setTimeout(() => {
            $(".singleSelect2").select2({
                width: "100%",
            });
        }, 50);
    </script>
@else
    <div class="pb-4 border-b border-gray-200">
        <h6 class="leading-none text-lg font-semibold text-heading">{{ translate('Question') }}</h6>
    </div>
    <ul class="*:leading-none *:p-3 *:rounded-10 *:border *:border-input-border space-y-5 mt-10" id="questionList">
        @if (isset($quizQuestions) && !empty($quizQuestions))
            @foreach ($quizQuestions as $quizQuestion)
                <li class="flex-center-between cursor-move question-item" data-item-id="{{ $quizQuestion->id }}">
                    <div class="flex items-center gap-2.5">
                        <div class="size-8 rounded-50 bg-primary-100 flex-center">
                            <i class="ri-question-mark text-[14px] text-inherit"></i>
                        </div>
                        <b>{{ ucfirst($quizQuestion->question_type) }} :</b>
                        <h6 class="text-gray-500 text-lg font-medium">
                            <span class="text-gray-900 font-normal">
                                {{ $quizQuestion?->question?->name }}
                        </h6>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <!-- Edit Question -->
                        <button type="button" class="btn-icon size-8 btn-primary-icon-light edit-question"
                            data-action="{{ route($questionEdit, $quizQuestion->id) }}">
                            <i class="ri-pencil-fill text-inherit text-base"></i>
                        </button>
                        <!-- Delete Question -->
                        <button type="button" class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                            aria-label="Delete option" data-action="{{ route($quizDelete, $quizQuestion->id) }}">
                            <i class="ri-close-line text-inherit text-base"></i>
                        </button>
                    </div>
                </li>
            @endforeach
        @endif


    </ul>
    <script>
        new Sortable(questionList, {
            animation: 150,
            onSort: function(ui) {
                let item = $(ui.from).find('.question-item')
                let itemIds = [];
                $.each(item, function(key, val) {
                    let id = $(val).data('item-id');
                    itemIds.push(id);
                })
                let action = baseUrl + "/quizzes/quiz-question-sorted";
                $.ajax({
                    url: action,
                    method: 'GET',
                    data: {
                        itemIds: itemIds
                    },
                    dataType: "json",
                    success: function(data) {
                        Command: toastr["success"](`${data.data}`)
                    }
                });
            },
        });
    </script>
@endif
