<x-dashboard-layout>
    @push('css')
        <script src="{{ asset('lms/assets/js/vendor/sortable.min.js') }}"></script>
    @endpush
    <x-slot:title> {{ translate('Edit Course') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('organization.course.index') }}"title="Edit Course" page-to="Course" />
    <!-- Multi step Menu -->
    <x-portal::admin.stepper-menu type="edit" />
    <div class="mb-4">
        <div id="msform" class="*:hidden">
            <x-portal::course.basic-form :course=$course action="{{ route('organization.course.store') }}" />
            <x-portal::course.curriculum.curriculum-form action="{{ route('organization.course.store') }}"
                :course=$course />

            <x-portal::course.additional-form action="{{ route('organization.course.store') }}" :course=$course />

            <x-portal::course.price-form action="{{ route('organization.course.store') }}" :course=$course />

            <x-portal::course.media-form action="{{ route('organization.course.store') }}" :course=$course />

            <x-portal::course.meeting-form action="{{ route('organization.course.store') }}" :course=$course />

            <x-portal::course.notice-board-form action="{{ route('organization.course.store') }}" :course=$course />

            <x-portal::course.setting-form action="{{ route('organization.course.store') }}" :course=$course />

            <x-portal::course.finish action="{{ route('organization.course.index') }}" />
        </div>
    </div>

    <x-portal::course.curriculum.chapter-form action="{{ route('organization.chapter.store') }}" :course=$course />

    <x-portal::course.curriculum.topic-form />

    <x-portal::course.curriculum.quiz.quiz-form action="{{ route('organization.quiz-question.store') }}" />

    <x-portal::course.curriculum.quiz.question-view />

    <x-portal::course.tag-form action="{{ route('organization.tag.store') }}" />
    <input type="hidden" id="courseTags" value="{{ isset($course->courseTags) ? $course->courseTags : '' }}">
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/choices.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/course.js') }}"></script>
    @endpush
</x-dashboard-layout>
