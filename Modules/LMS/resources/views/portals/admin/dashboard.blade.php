<x-dashboard-layout>
    <x-slot:title>{{ translate('Dashboard') }}</x-slot:title>
    <div class="grid grid-cols-12 gap-x-4">
        <!-- Start Intro -->
        <x-portal::admin.admin.intro name="{{ auth()->user()->name }}" courseLink="{{ route('course.create') }}" />
        <!-- End Intro -->

        <!-- Start Short Progress Card -->
        <x-portal::admin.admin.overview :data="$data" />
        <!-- End Short Progress Card -->

        <!-- Start Statistics instructor & student  -->
        <x-portal::admin.admin.chat-instructor-student />
        <!-- End Average Statistics  Rate Chart -->

        <!-- Start Trending Category -->
        <x-portal::admin.admin.trending-category :topCategories="$data['top_category_courses']" />
        <!-- End Trending Category -->

        <div class="col-span-full 2xl:col-span-4 card">
            <div class="flex-center-between mb-6">
                <h6 class="card-title"> {{ translate('Top performing courses') }} </h6>
                @if (count($data['top_courses']) > 0)
                    <a href="{{ route('course.index') }}"
                        class="btn b-solid btn-primary-solid btn-sm dk-theme-card-square">
                        {{ translate('See all') }}
                    </a>
                @endif
            </div>
            <!-- Start Top Performing Course -->
            <x-portal::admin.admin.top-course :topCourses="$data['top_courses']" />
            <!-- End Top Performing Course -->
        </div>

        <!-- Start Support -->
        <x-portal::admin.admin.support :supports="$data['latest_supports']" />
        <!-- End Support -->
    </div>

    @php
        $instructorMonth = [];
        $getInstructorByMonth = [];
        if (count($data['instructor_reports']) > 0) {
            foreach ($data['instructor_reports'] as $key => $value) {
                $getInstructorByMonth[] = $value->total;
                $instructorMonth[] = "$value->dayMonthYears";
            }
        }
        $registerDate = [];
        $getStudentByDate = [];
        if (count($data['student_reports']) > 0) {
            foreach ($data['student_reports'] as $key => $value) {
                $getStudentByDate[] = $value->total;
                $registerDate[] = "$value->dayMonthYears";
            }
        }
    @endphp
    <input type="hidden" id="instructorMonth" value="{{ json_encode($instructorMonth) }}">
    <input type="hidden" id="getInstructorByMonth" value="{{ json_encode($getInstructorByMonth) }}">
    <input type="hidden" id="studentDate" value="{{ json_encode($registerDate) }}">
    <input type="hidden" id="getStudentByDate" value="{{ json_encode($getStudentByDate) }}">
    @push('js')
        <script src="{{ asset('lms/assets/js/vendor/apexcharts.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/pages/dashboard-admin.js') }}"></script>
    @endpush
</x-dashboard-layout>
