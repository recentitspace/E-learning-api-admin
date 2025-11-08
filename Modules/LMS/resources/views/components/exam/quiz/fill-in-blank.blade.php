@php
    $answers = [];
    $questionScore = $question['question_score'] ?? null;
@endphp
@foreach ($question['question_answers'] as $questionAnswer)
    @php
        $answers[] = $questionAnswer['answer']['name'];
    @endphp
    <label for="q-2-{{ $questionAnswer['id'] }}"
        class="flex items-start gap-3 dk-border-one rounded-lg p-3.5 cursor-pointer select-none">
        <input type="text" name="answers[{{ $question['id'] }}][{{ $questionAnswer['id'] }}][]"
            class="form-input focus-visible:outline-primary fill-in-blank"
            value="{{ $questionAnswer['take_answer']['value'] ?? '' }}" {{ $disabled }}>
    </label>
@endforeach

@if ($disabled == 'disabled')
    <x-theme::exam.quiz.result-show :questionScore="$questionScore" :answers="$answers" />
    @php
        reset($answers);
    @endphp
@endif
