<x-dashboard-layout>
    <x-slot:title>{{ translate('Create') }} {{ translate('Bundle') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('instructor.bundle.index') }}" title="{{ 'Create' }} Bundle"
        page-to="Bundle" />
    <!-- Start Course Bundle Form -->

    <x-portal::course.bundle.basic-form action="{{ route('instructor.bundle.store') }}" />
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/bundle.js') }}"></script>
    @endpush
</x-dashboard-layout>
