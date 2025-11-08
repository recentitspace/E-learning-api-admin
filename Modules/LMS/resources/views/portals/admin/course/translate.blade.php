@php
    $locale = request()->locale ?? app()->getLocale();
    $course = $course ?? null;

    if (!$course) {
        return;
    }
@endphp

<x-dashboard-layout>
    @push('css')
        <script src="{{ asset('lms/assets/js/vendor/sortable.min.js') }}"></script>
    @endpush
    <x-slot:title>{{ translate('Edit Course') }}</x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ route('course.index') }}" title="Edit" page-to="Course" />

    @if (is_active('course.translate') === 'active')
        <div class="flex items-center justify-end gap-4 mb-2">
            <h2 class="card-title">{{ translate('Translate Language') }}</h2>
            <form method="GET" class="sm:block" id="change-translate-language">
                <select onchange="window.location.href=this.options[this.selectedIndex].value" name="id"
                    class="text-gray-500 dark:text-dark-text dark:bg-dark-card-shade font-semibold bg-white focus:outline-none cursor-pointer select-none text-sm border dk-border-one px-2 py-2 rounded-md dk-theme-card-square">
                    @foreach (app('languages') as $lang)
                        <option value="{{ $lang->code }}"
                            {{ isset($locale) && $locale == $lang->code ? 'selected' : '' }}>
                            {{ $lang->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    @endif

    <div class="mb-4">
        <div id="msform" class="*:hidden">
            <x-portal::course.basic-form :course=$course action="{{ route('course.store') }}" />
        </div>
    </div>

    <x-portal::course.tag-form action="{{ route('tag.store') }}" />
    <input type="hidden" id="courseTags" value="{{ isset($course->courseTags) ? $course->courseTags : '' }}">

    <h1 id="chapterList" class="hidden"></h1>
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ asset('lms/assets/js/vendor/choices.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/course.js') }}"></script>
    @endpush
</x-dashboard-layout>
