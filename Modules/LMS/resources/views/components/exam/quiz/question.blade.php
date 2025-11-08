@foreach ($questionList as $key => $question)
    <form
        action="{{ route('user.submit.quiz.answer', ['quiz_id' => $quizId, 'question_id' => $question['id'], 'type' => $question['question_type']]) }}"
        id="{{ $question['id'] }}" method="POST"
        class="col-span-full lg:col-span-1 bg-white rounded-20 shadow-sm p-7 border border-primary-200 relative">

        <!-- SINGLE QUESTION -->
        <span class="badge badge-info-light absolute top-0 right-0 rtl:right-auto rtl:left-0 m-1 !font-bold !text-heading">
             {{ translate('Mark') }}</span>
        <div class="question area-title text-lg">
            <span class="mr-2">{{ $key + 1 }}.</span>
            {{ $question['question']['name'] }}
        </div>
        <ul class="question-options mt-6">
            @if ($question['question_type'] != 'fill-in-blank')
                <x-theme::exam.quiz.single-multiple-question :question="$question" disabled="{{ $disabled }}" />
            @else
                <x-theme::exam.quiz.fill-in-blank :question="$question" disabled="{{ $disabled }}" />
            @endif
        </ul>

    </form>
@endforeach
