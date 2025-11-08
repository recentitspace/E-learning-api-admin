<x-dashboard-layout>
    <x-slot:title> {{ translate('Bundle manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Course Bundle" page-to="Bundle"
        action-route="{{ route('organization.bundle.create') }}" />


    <div class="flex items-center gap-2 pb-5 mb-5 border-b border-gray-200 dark:border-dark-border">
        <a href="{{ route('organization.bundle.index', ['filter' => 'all']) }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'all' ? 'active' : '' }}">{{ translate('All') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['total'] ?? 0 }}</span>
        </a></a>
        <a href="{{ route('organization.bundle.index') }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'published' ? 'active' : '' }}">
            {{ translate('Published') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['published'] ?? 0 }}</span></a>
        <a href="{{ route('organization.bundle.index', ['filter' => 'trash']) }}"
            class="badge badge-primary-outline b-outline group/b-counter is-hover-active rounded-full dk-theme-card-square {{ get_active_filter_tab() === 'trash' ? 'active' : '' }}">
            {{ translate('Trash') }}
            <span class="badge-counter rounded-full dk-theme-card-square">{{ $countData['trashed'] ?? 0 }}</span>
        </a>
    </div>

    @if ($bundles->count() > 0)
        <div class="card overflow-hidden">
            <x-portal::course.bundle.index :bundles=$bundles />
        </div>
    @else
        <x-portal::admin.empty-card title="No bundle. Let's create a bundle."
            action="{{ route('organization.bundle.create') }}" btnText="Create bundle" />
    @endif
</x-dashboard-layout>
