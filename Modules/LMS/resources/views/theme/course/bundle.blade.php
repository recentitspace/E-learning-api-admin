<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one 
        pageTitle="Courses Bundle"        
        pageName="Courses Bundle" 
    />
    <div class="container">
        <div class="flex-center-between flex-col sm:flex-row gap-5">
            <h2 class="area-title text-xl">{{ translate('We Have') }} {{ $bundles->total() ?? '0' }} - {{ translate('Bundle Course Offer') }}!</h2>
            <form action="#" class="shrink-0">
                <label for="search-filter" class="relative flex">
                    <span class="text-heading/60 absolute top-1/2 -translate-y-1/2 left-4 z-[1]"><i
                            class="ri-search-2-line"></i></span>
                    <input type="search" id="search_title" name="title" placeholder="{{ translate('Search Here') }}..."
                        class="form-input text-heading/60 h-12 pl-10 bg-white search-keyword">
                </label>
            </form>
        </div>
        <div id="outputItemList">
            @if ($bundles->count() > 0)
                <x-theme::course.bundle-list :bundles="$bundles" />
            @else
                <x-theme::cards.empty title="No Bundle Available" />
            @endif
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/frontend/assets/js/filter.js') }}"></script>
    @endpush
</x-frontend-layout>
