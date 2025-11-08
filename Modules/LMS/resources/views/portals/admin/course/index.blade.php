<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Course') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Course" page-to="Course" />
    <div class="card">
        <div class="grid grid-cols-12 gap-4">
            <x-portal::admin.course-overview-card color-type="primary" title="Total Course"
                value="{{ $reports['total_course'] }}" />
            <x-portal::admin.course-overview-card color-type="success" title="Approved Course"
                value="{{ $reports['total_approved'] }}" />
            <x-portal::admin.course-overview-card title="Pending Course" value="{{ $reports['total_pending'] }}" />
            <x-portal::admin.course-overview-card color-type="danger" title="Rejected Course"
                value="{{ $reports['total_rejected'] }}" />
            <x-portal::admin.course-overview-card color-type="primary" title="Free Course"
                value="{{ $reports['total_free'] }}" />
        </div>
    </div>
    <!-- Course Filete Option -->
    <x-portal::course.filter />
    <div class="rounded-15 overflow-hidden bg-white dark:bg-dark-body dk-theme-card-square">
        <div
            class="flex flex-col gap-2 sm:flex-center-between sm:flex-row px-4 py-5 md:p-6 bg-gray-200/30 dark:bg-dark-card-shade">
            <div>
                <h6 class="card-title">{{ translate('Course list') }}</h6>
                <p class="card-description">{{ translate('All Course Here') }}</p>
            </div>
            <a href="{{ route('course.create') }}" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Add Course') }}
            </a>
        </div>

        <div
            class="flex items-center gap-2 pt-5 pb-5 pl-4 md:pl-6 mb-5 border-b border-gray-200 dark:border-dark-border">
            <a href="{{ route('course.index', ['filter' => 'all']) }}"
                class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'all' ? 'active' : '' }}">{{ translate('All') }}
                <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['total'] ?? 0 }}</span>
            </a></a>
            <a href="{{ route('course.index') }}"
                class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'published' ? 'active' : '' }}">
                {{ translate('Published') }}
                <span
                    class="badge-counter rounded-full dk-theme-card-square">{{ $countData['published'] ?? 0 }}</span></a>
            <a href="{{ route('course.index', ['filter' => 'trash']) }}"
                class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'trash' ? 'active' : '' }}">
                {{ translate('Trash') }}
                <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['trashed'] ?? 0 }}</span>
            </a>
        </div>
        <div class="card">
            <x-portal::course.course-list :courses=$courses />
        </div>
    </div>
</x-dashboard-layout>
