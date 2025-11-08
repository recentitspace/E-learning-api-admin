<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one 
        pageTitle="Organization" 
        pageRoute="{{ route('organization.list') }}"
        pageName="Organization" 
    />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <x-theme::organization.filter-sidebar />
            <div class="col-span-full lg:col-span-8">
                <div class="flex-center-between">
                    <h3 class="area-title text-xl">{{ translate('Showing') }}
                        <span id="first-item">{{ $organizations->firstItem() }}</span>
                        -<span id="last-item">{{ $organizations->lastItem() }}</span>
                        {{ translate('of') }}
                        <span id="total-item"> {{ $organizations->total() }}</span> {{ translate('Results') }}
                    </h3>
                    <button type="button" aria-label="Organization filter drawer" data-offcanvas-id="org-filter-drawer" class="btn b-outline btn-secondary-outline lg:hidden">
                        <i class="ri-equalizer-line"></i>
                        {{ translate('Filter') }}
                    </button>
                </div>
                <div id="outputItemList">
                    <x-theme::organization.organization-list :organizations="$organizations" />
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/frontend/assets/js/filter.js') }}"></script>
    @endpush
</x-frontend-layout>
