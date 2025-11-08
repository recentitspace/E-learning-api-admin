<x-dashboard-layout>
    <x-slot:title>{{ translate('Manage Instructor') }}</x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb title="All Instructor" page-to="Instructor"
        action-route="{{ route('instructor.create') }}" />
    <div class="card">
        <div class="grid grid-cols-12 gap-4">
            <x-portal::admin.course-overview-card title="Total Instructor" value="{{ $reports['total_users'] }}" />
            <x-portal::admin.course-overview-card color-type="success" title="Active Instructor"
                value="{{ $reports['total_active'] }}" />
            <x-portal::admin.course-overview-card color-type="danger" title="Deactivate Instructor"
                value="{{ $reports['total_inactive'] }}" />
            <x-portal::admin.course-overview-card color-type="primary" title="Verified"
                value="{{ $reports['total_verified'] }}" />
            <x-portal::admin.course-overview-card color-type="danger" title="Unverified"
                value="{{ $reports['total_unverified'] }}" />
        </div>
    </div>
    <div class="card">
        <form method="get">
            <div class="grid grid-cols-4 gap-4">
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <input type="text" class="form-input" placeholder="{{ translate('Search name') }}"
                        name="name_search" value="{{ Request()->name_search ?? null }}">
                </div>
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <select class="singleSelect" name="status">
                        @php
                            $status = Request()->status ?? null;
                        @endphp
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}> {{ translate('All') }}
                        </option>
                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>
                            {{ translate('Active') }} </option>
                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>
                            {{ translate('Inactive') }} </option>
                    </select>
                </div>
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <select class="singleSelect" name="verify">
                        @php
                            $verify = Request()->verify ?? null;
                        @endphp
                        <option value="all" {{ $verify == 'all' ? 'selected' : '' }}> {{ translate('All') }}
                        </option>
                        <option value="verified" {{ $verify == 'verified' ? 'selected' : '' }}>
                            {{ translate('Verified') }} </option>
                        <option value="unverified" {{ $verify == 'unverified' ? 'selected' : '' }}>
                            {{ translate('Un Verified') }}
                        </option>
                    </select>
                </div>
                <div class="col-span-full md:col-span-2 lg:col-auto">
                    <div class="flex items-end">
                        <button class="btn b-solid btn-info-solid mr-3">
                            {{ translate('Filter') }}
                        </button>
                        <a href="{{ route('instructor.index') }}"
                            class="btn b-solid btn-info-solid">{{ translate('Refresh') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="flex items-center gap-2 pb-5 mb-5 border-b border-gray-200 dark:border-dark-border">
        <a href="{{ route('instructor.index', ['filter' => 'all']) }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'all' ? 'active' : '' }}">{{ translate('All') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['total'] ?? 0 }}</span>
        </a></a>
        <a href="{{ route('instructor.index') }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'published' ? 'active' : '' }}">
            {{ translate('Published') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['published'] ?? 0 }}</span></a>
        <a href="{{ route('instructor.index', ['filter' => 'trash']) }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'trash' ? 'active' : '' }}">
            {{ translate('Trash') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['trashed'] ?? 0 }}</span>
        </a>
    </div>

    @if ($instructors->count() > 0)
        <div class="card">
            <x-portal::instructor.instructor-list :instructors="$instructors" />
        </div>
    @else
        <x-portal::admin.empty-card title="No Instructor" />
    @endif
</x-dashboard-layout>
