<x-dashboard-layout>
    @push('css')
        <script src="{{ asset('lms/assets/js/vendor/sortable.min.js') }}"></script>
    @endpush
    <x-slot:title>{{ translate('Edit Course') }}</x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ route('course.index') }}" title="Edit" page-to="Course" />

    <!-- Multistep Menu -->
    <x-portal::admin.stepper-menu type="edit" />

    <div class="mb-4">
        <div id="msform" class="*:hidden">
            <x-portal::course.basic-form :course=$course action="{{ route('course.store') }}" />
            <x-portal::course.curriculum.curriculum-form action="{{ route('course.store') }}" :course=$course />
            <x-portal::course.additional-form action="{{ route('course.store') }}" :course=$course />

            <x-portal::course.price-form action="{{ route('course.store') }}" :course=$course />

            <x-portal::course.media-form action="{{ route('course.store') }}" :course=$course />
            
            <x-portal::course.meeting-form action="{{ route('course.store') }}" :course=$course />

            <x-portal::course.notice-board-form action="{{ route('course.store') }}" :course=$course />

            <x-portal::course.setting-form action="{{ route('course.store') }}" :course=$course />
            
            <x-portal::course.finish action="{{ route('course.index') }}" />
        </div>
    </div>

    <x-portal::course.curriculum.chapter-form action="{{ route('chapter.store') }}" :course=$course />

    <x-portal::course.curriculum.topic-form />

    <x-portal::course.curriculum.quiz.quiz-form action="{{ route('quiz-question.store') }}" />

    <x-portal::course.curriculum.quiz.question-view />

    <x-portal::course.tag-form action="{{ route('tag.store') }}" />
    <input type="hidden" id="courseTags" value="{{ isset($course->courseTags) ? $course->courseTags : '' }}">
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/choices.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/course.js') }}"></script>
    @endpush
</x-dashboard-layout>
