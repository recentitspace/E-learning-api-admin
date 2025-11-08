@php
    $quizQuestions = $quizQuestions ?? null;
    $quizQuestion = $quizQuestion ?? null;
@endphp

<x-portal::course.topic-type.question-list mode="{{ $mode }}" :quizQuestion="$quizQuestion" :quizQuestions="$quizQuestions" />
