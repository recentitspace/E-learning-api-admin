@php
    $auth = authCheck();
    if ($auth) {
        $purchaseCheck = purchaseCheck($course->id, 'course');
    }
@endphp

@include('theme::layouts.partials.head')
<link rel="stylesheet" href="{{ asset('lms/frontend/assets/vendor/css/plyr.min.css') }}">

<body>
    @include('theme::layouts.partials.header', [
        'style' => 'one',
        'class' => "flex-center bg-primary-50 shadow-md py-4 fixed inset-0 h-[theme('spacing.header')] z-[101]",
        'data' => [
            'components' => [
                'inner-header-top' => '',
            ],
            'header_class' =>
                "flex-center bg-primary-50 shadow-md py-4 fixed inset-0 h-[theme('spacing.header')] z-[101]",
        ],
    ])
    <!-- END HEADER AREA -->
    <main>
        <div class="flex mb-16 sm:mb-24 lg:mb-[120px]">
            <!-- START COURSE VIDEO AREA -->
            <div class="relative p-3 mt-[theme('spacing.header')] w-[100%] lg:w-[calc(100%_-_19.5rem)] xl:w-[calc(100%_-_28.6rem)] overflow-hidden z-10">
                <div class="relative overflow-hidden">
                    <!-- COURSE CONTENT BUTTON FOR SMALL DEVICE -->
                    <div class="flex-center lg:hidden shrink-0 absolute top-0 right-0 translate-x-[128px] hover:translate-x-0 z-10 custom-transition">
                        <button type="button" aria-label="Course off-canvas drawer"
                            data-offcanvas-id="course-content-drawer"
                            class="btn b-solid bg-heading !text-white font-normal border border-gray-500 rounded-none">
                            <i class="ri-arrow-left-line"></i>
                            {{ translate('Course Content') }}
                        </button>
                    </div>
                    <div class="rounded-xl overflow-hidden curriculum-content">
                        <x-theme::course.details.video-play :course="$course" />
                    </div>
                </div>
                <!-- COURSE DETAILS TAB -->
                <div class="mt-6">
                    <div class="dashkit-tab bg-primary-50 flex items-center justify-center flex-wrap gap-3 p-3 rounded-lg"
                        id="courseDetailsTab">
                        <button type="button" aria-label="Course overview tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0 active"
                            id="courseOverview">{{ translate('Course Overview') }}</button>
                        <button type="button" aria-label="Course assignment tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseAssignment">{{ translate('Assignments') }}
                            <span>({{ count($assignments) ?? 0 }})</span></button>
                        <button type="button" aria-label="Course review tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseReview">{{ translate('Reviews') }}</button>
                    </div>
                    <div class="dashkit-tab-content mt-7 *:hidden container max-w-screen-lg"
                        id="courseDetailsTabContent">
                        <!-- COURSE OVERVIEW CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10 [&>:not(:first-child)]:pt-10 [&>:not(:first-child)]:border-t [&>:not(:first-child)]:border-border !block"
                            data-tab="courseOverview">
                            <x-theme::course.short-info :course="$course" />
                            <x-theme::course.details.course-overview :course="$course" />
                            <x-theme::course.details.course-instructor :course="$course" />
                        </div>
                        <!-- COURSE ASSIGNMENT CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10 [&>:not(:first-child)]:pt-10 [&>:not(:first-child)]:border-t [&>:not(:first-child)]:border-border"
                            data-tab="courseAssignment">
                            @if (count($assignments) > 0)
                                <x-theme::course.assignment :assignments="$assignments" />
                            @else
                                <x-theme::cards.empty 
                                    title="No assignment"
                                    description="This course does not include any mandatory assignments, allowing you to focus on learning at your own pace without the pressure of submissions."
                                />
                            @endif
                        </div>
                        <!-- COURSE REVIEWS CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10 [&>:not(:first-child)]:pt-10 [&>:not(:first-child)]:border-t [&>:not(:first-child)]:border-border "
                            data-tab="courseReview">
                            <x-theme::course.details.course-review :course="$course" />

                            <x-theme::course.details.course-comment :course="$course" :auth="$auth ?? false"
                                :purchaseCheck="$purchaseCheck ?? false" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- COURSE CONTENT AREA -->
            <x-theme::course.topic-sidebar :course="$course" :data="$data" :auth="$auth ?? false" :purchaseCheck="$purchaseCheck ?? false" />
        </div>
    </main>

    <!-- END FOOTER AREA -->
    @include('theme::layouts.partials.footer-script')
    <script src="{{ asset('lms/frontend/assets/vendor/js/plyr.min.js') }}"></script>
    <script src="{{ edulab_asset('lms/frontend/assets/js/video-play.js') }}"></script>
</body>

</html>
