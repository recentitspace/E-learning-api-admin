<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Instructors" pageRoute="{{ route('instructor.list') }}"
        pageName="Instructors" />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <x-theme::instructor.filter-sidebar />
            <!-- START CONTENT -->
            <div class="col-span-full lg:col-span-8">
                <div class="flex-center-between">
                    <h3 class="area-title text-xl">{{ translate('Showing') }}
                        <span id="first-item">{{ $instructors->firstItem() }}</span> -
                        <span id="last-item">{{ $instructors->lastItem() }}</span>
                        {{ translate('of') }}
                        <span id="total-item"> {{ $instructors->total() }} </span> {{ translate('Results') }}
                    </h3>
                    <div class="flex-center gap-2">
                        <button type="button" aria-label="Off-canvas filter drawer" data-offcanvas-id="filter-drawer"
                            class="btn b-outline btn-secondary-outline lg:hidden">
                            <i class="ri-equalizer-line"></i>
                            {{ translate('Filter') }}
                        </button>
                    </div>
                </div>
                <div id="outputItemList">
                    <x-theme::instructor.instructor-list :instructors="$instructors" />
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    <!-- END INNER CONTENT AREA -->

    @push('js')
        <script src="{{ edulab_asset('lms/frontend/assets/js/filter.js') }}"></script>
    @endpush
</x-frontend-layout>
