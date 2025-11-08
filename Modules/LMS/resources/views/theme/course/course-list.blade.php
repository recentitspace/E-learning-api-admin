<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Our Courses" pageRoute="{{ route('course.list') }}"
        pageName="Courses" />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <input type="hidden" id="courseType">
            <x-theme::course.filter-sidebar />
            <!-- START CONTENT -->
            <div class="col-span-full lg:col-span-8">
                <div class="flex-center-between">
                    <h3 class="area-title text-xl">
                        {{ translate('Showing') }}
                        <span id="first-item">{{ $courses->firstItem() }}</span>
                        -
                        <span id="last-item">{{ $courses->lastItem() }}</span>
                        {{ translate('of') }}
                        <span id="total-item">{{ $courses->total() }}</span>
                        {{ translate('Results') }}
                    </h3>
                    <div class="flex-center gap-2">
                        <button type="button" aria-label="Course layout grid" data-layout="grid"
                            class="card-layout-button btn-icon bg-primary-50 text-heading dark:text-white [&.active]:bg-primary [&.active]:text-white hidden md:flex active">
                            <i class="ri-layout-grid-line"></i>
                        </button>
                        <button type="button" aria-label="Course layout list" data-layout="list"
                            class="card-layout-button btn-icon bg-primary-50 text-heading dark:text-white [&.active]:bg-primary [&.active]:text-white hidden md:flex">
                            <i class="ri-list-check"></i>
                        </button>
                        <button type="button" aria-label="Off-canvas filter drawer" data-offcanvas-id="filter-drawer"
                            class="btn b-outline btn-secondary-outline lg:hidden">
                            <i class="ri-equalizer-line"></i>
                            {{ translate('Filter') }}
                        </button>
                    </div>
                </div>
                <div id="outputItemList">
                    <x-theme::course.course-list :courses="$courses" />
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/frontend/assets/js/filter.js') }}"></script>
    @endpush
</x-frontend-layout>
