@php
    if (!$course) {
        return;
    }
    $course = $course ?? null;
    $reviews = review($course);
    $translations = parse_translation($course);
    $auth = authCheck();
    if ($auth) {
        $purchaseCheck = purchaseCheck($course->id, 'course');
    }

@endphp
<x-frontend-layout>
    @push('css')
        <link rel="stylesheet" href="{{ asset('lms/frontend/assets/vendor/css/plyr.min.css') }}">
    @endpush
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Course Details" pageName="Course Details" />
    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <div class="grid grid-cols-12 gap-5">
            <!-- START COURSE DETAILS -->
            <div class="col-span-full lg:col-span-8">
                <div class="flex items-start gap-2.5">
                    <div class="flex items-center gap-0.5 text-secondary">
                        {!! show_rating($reviews['average_rating']) !!}
                    </div>
                    <span class="text-heading/70 text-sm font-medium leading-none">({{ $reviews['total_rating'] ?? 0 }})
                        {{ translate('Rating') }}
                    </span>
                </div>
                <h2 class="area-title xl:text-[40px] mt-4">
                    {{ $translations['title'] ?? ($course->title ?? '') }}
                </h2>
                <p class="area-description text-heading/80 mt-3">
                    {!! clean($translations['short_description'] ?? ($course->short_description ?? '')) !!}
                </p>
                <div class="mt-7 pt-4 border-t border-border">
                    <div class="flex items-center gap-5 flex-wrap divide-x rtl:divide-x-reverse divide-border">
                        @foreach ($course->instructors as $instructor)
                            @if ($loop->first)
                                @php
                                    $user = $instructor->userable ?? null;
                                    $profile_img = $user?->profile_img ?? null;
                                    $profileImg =
                                        $profile_img && fileExists('lms/instructors', $profile_img) == true
                                            ? asset('storage/lms/instructors/' . $profile_img)
                                            : asset('lms/frontend/assets/images/370x396.svg');

                                    $userTranslations = parse_translation($user);

                                    if ($userTranslations) {
                                        $name = $userTranslations['first_name'] . ' ' . $userTranslations['last_name'];
                                    }
                                @endphp
                                <a href="{{ route('users.detail', $instructor->id) }}"
                                    class="flex items-center gap-2.5 hover:underline">
                                    <div class="size-8 rounded-50 overflow-hidden shrink-0">
                                        <img data-src="{{ $profileImg }}" alt="Instructor profile image"
                                            class="size-full object-cover">
                                    </div>
                                    <h6 class="leading-none text-heading dark:text-white font-semibold line-clamp-1">
                                        {{ $name ?? $user?->first_name . ' ' . $user?->last_name }}</h6>
                                    </h6>
                                </a>
                            @endif
                        @endforeach
                        <div class="flex items-center gap-3 flex-wrap pl-5 rtl:pl-0 rtl:pr-5">
                            <!-- COURSE LABEL -->
                            @foreach ($course->levels as $level)
                                @php $levelTranslations = parse_translation($level); @endphp
                                <div class="badge b-solid badge-secondary-solid rounded-full !text-heading">
                                    {{ $levelTranslations['name'] ?? ($level->name ?? '') }}</div>
                            @endforeach
                            <!-- COURSE CATEGORY -->
                            @if ($course?->category)
                                @php $categoryTranslations = parse_translation($course->category); @endphp
                                <div class="badge badge-heading-outline b-outline rounded-full shrink-0">
                                    {{ $categoryTranslations['title'] ?? ($course?->category?->title ?? '') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- COURSE DETAILS TAB -->
                <div class="mt-[60px]">
                    <div class="dashkit-tab bg-primary-50 flex items-center flex-wrap gap-4 p-4 rounded-t-xl border-b border-primary"
                        id="courseDetailsTab">
                        <button type="button" aria-label="Course Overview tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0 active"
                            id="courseOverview">
                            {{ translate('Course Overview') }}
                        </button>
                        <button type="button" aria-label="Course Curriculum tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseCurriculum">
                            {{ translate('Curriculum') }}
                        </button>
                        <button type="button" aria-label="Course Instructor tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseInstructor">
                            {{ translate('Instructor') }}
                        </button>
                        <button type="button" aria-label="Course Review tab"
                            class="dashkit-tab-btn btn b-outline btn-primary-outline rounded-full [&.active]:bg-primary [&.active]:text-white [&.active]:border-transparent shrink-0"
                            id="courseReview">
                            {{ translate('Reviews') }}
                        </button>
                    </div>
                    <div class="dashkit-tab-content mt-[60px] *:hidden" id="courseDetailsTabContent">
                        <!-- COURSE OVERVIEW CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10 !block"
                            data-tab="courseOverview">
                            <x-theme::course.details.course-overview :course="$course" :translations="$translations" />

                            <x-theme::course.details.course-outcome :course="$course" />

                            <x-theme::course.details.course-requirement :course="$course" />

                            <x-theme::course.details.course-faq :course="$course" />
                        </div>

                        <!-- COURSE CURRICULUM CONTENT -->
                        <x-theme::course.details.course-curriculum :course="$course" :auth="$auth ?? false"
                            :purchaseCheck="$purchaseCheck ?? false" />

                        <!-- COURSE INSTRUCTOR CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10"
                            data-tab="courseInstructor">
                            <x-theme::course.details.course-instructor :course="$course" />
                        </div>

                        <!-- COURSE REVIEWS CONTENT -->
                        <div class="dashkit-tab-pane course-details-tab-content [&>:not(:first-child)]:mt-10"
                            data-tab="courseReview">
                            <x-theme::course.details.course-review :course="$course" />
                            <x-theme::course.details.course-comment :course="$course" :auth="$auth ?? false"
                                :purchaseCheck="$purchaseCheck ?? false" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- END COURSE DETAILS -->

            <!-- START CONTENT -->
            <x-theme::course.details.sidebar :course="$course" :auth="$auth ?? false" :purchaseCheck="$purchaseCheck ?? false"
                :hasPurchase="$hasPurchase" />
            <!-- END CONTENT -->
        </div>
        <!-- START RELATED COURSE AREA -->
        @if ($relatedCourses->count() > 0)
            <x-theme::course.related-course :courses="$relatedCourses" />
        @endif
        <!-- END RELATED COURSE AREA -->
    </div>
    <!-- END INNER CONTENT AREA -->

    @push('js')
        <script src="{{ asset('lms/frontend/assets/vendor/js/plyr.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/frontend/assets/js/modal.js') }}"></script>
        <script src="{{ edulab_asset('lms/frontend/assets/js/video-play.js') }}"></script>
    @endpush
</x-frontend-layout>
