@php
    if (!$bundle) {
        return;
    }
    $bundle = $bundle ?? null;
    $translations = parse_translation($bundle);
    $auth = authCheck();
    if ($auth) {
        $purchaseCheck = purchaseCheck($bundle->id, 'bundle');
    }
    $courses = $bundle?->courses ?? [];
    $instructor = $bundle?->user ?? null;
@endphp
<x-frontend-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('lms/frontend/assets/vendor/css/plyr.min.css') }}">
    @endpush
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Bundle Details" pageName="Bundle Details" />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <!-- START COURSE DETAILS -->
            <div class="col-span-full lg:col-span-8">
                <h2 class="area-title xl:text-[40px] mt-4">
                    {{ $translations['title'] ?? ($bundle->title ?? '') }}
                </h2>
                <p class="area-description text-heading/80 mt-3">
                    {!! clean($translations['details'] ?? ($bundle->details ?? '')) !!}
                </p>
                <div class="mt-7 pt-4 border-t border-border">
                    <div class="flex items-center gap-5 flex-wrap divide-x rtl:divide-x-reverse divide-border">

                        <div class="flex items-center gap-3 flex-wrap pl-5 rtl:pl-0 rtl:pr-5">
                            <!-- BUNDLE LABEL -->
                            @foreach ($bundle->levels as $level)
                                @php $levelTranslations = parse_translation($level); @endphp
                                <div class="badge b-solid badge-secondary-solid rounded-full !text-heading">
                                    {{ $levelTranslations['name'] ?? ($level->name ?? '') }}</div>
                            @endforeach
                            <!-- BUNDLE CATEGORY -->
                            @if ($bundle?->category)
                                @php $categoryTranslations = parse_translation($bundle->category); @endphp
                                <div class="badge badge-heading-outline b-outline rounded-full shrink-0">
                                    {{ $categoryTranslations['title'] ?? ($bundle?->category?->title ?? '') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- BUNDLE DETAILS TAB -->
                <div class="mt-[60px]">
                    <div class="dashkit-tab bg-primary-50 flex items-center flex-wrap gap-4 p-4 rounded-t-xl border-b border-primary"
                        id="courseDetailsTab">
                        <button type="button" aria-label="Bundle Overview tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0 active"
                            id="courseOverview">
                            {{ translate('Bundle Overview') }}
                        </button>
                        <button type="button" aria-label="Course Curriculum tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseBundle">
                            {{ translate('Course') }}
                        </button>
                        <button type="button" aria-label="Course Instructor tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseInstructor">
                            {{ translate('Instructor') }}
                        </button>
                    </div>
                    <div class="dashkit-tab-content mt-[60px] *:hidden" id="courseDetailsTabContent">
                        <!-- BUNDLE OVERVIEW CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10 !block"
                            data-tab="courseOverview">
                            <x-theme::bundle.details.bundle-overview :bundle="$bundle" :translations="$translations" />
                            <x-theme::bundle.details.bundle-outcome :bundle="$bundle" />
                            <x-theme::bundle.details.bundle-faq :bundle="$bundle" />
                        </div>
                        <!-- COURSE CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10"
                            data-tab="courseBundle">
                            <x-theme::bundle.details.bundle-course :courses="$courses" />
                        </div>
                        <!-- COURSE CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10"
                            data-tab="courseInstructor">
                            <x-theme::bundle.details.bundle-instructor :instructor="$instructor" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- END COURSE DETAILS -->
            <!-- START CONTENT -->
            <x-theme::bundle.details.sidebar :bundle="$bundle" :auth="$auth ?? false" :hasPurchase="$hasPurchase ?? null" />
            <!-- END CONTENT -->
        </div>

    </div>
    <!-- END INNER CONTENT AREA -->

    @push('js')
        <script src="{{ asset('lms/frontend/assets/vendor/js/plyr.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/frontend/assets/js/modal.js') }}"></script>
        <script src="{{ edulab_asset('lms/frontend/assets/js/video-play.js') }}"></script>
    @endpush
</x-frontend-layout>
