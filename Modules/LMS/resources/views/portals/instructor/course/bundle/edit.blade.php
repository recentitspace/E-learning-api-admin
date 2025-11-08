<x-dashboard-layout>

    <x-slot:title>{{ translate('Edit Bundle') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('instructor.bundle.index') }}" title="bundle" page-to="Bundle" />
    <x-portal::course.bundle.stepper-menu />
    <div class="mb-4">
        <div id="msform" class="*:hidden">
            <x-portal::course.bundle.basic-form :bundle=$bundle action="{{ route('instructor.bundle.store') }}" />
            <x-portal::course.bundle.price-form action="{{ route('instructor.bundle.store') }}" :bundle=$bundle />
            <x-portal::course.bundle.media-form action="{{ route('instructor.bundle.store') }}" :bundle=$bundle />
            <x-portal::course.bundle.course-form action="{{ route('instructor.bundle.store') }}" :bundle=$bundle
                :courses=$courses />
            <x-portal::course.bundle.additional-form action="{{ route('instructor.bundle.store') }}" :bundle=$bundle />
            <x-portal::course.bundle.finish-form action="{{ route('instructor.bundle.index') }}" />
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/bundle.js') }}"></script>
    @endpush
</x-dashboard-layout>
