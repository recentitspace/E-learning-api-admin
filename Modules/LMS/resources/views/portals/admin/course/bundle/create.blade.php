<x-dashboard-layout>

    <x-slot:title>{{ translate('Create Bundle') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('bundle.index') }}" title="bundle" page-to="Bundle" />
    <div class="mb-4">
        <div id="msform">
            <x-portal::course.bundle.basic-form action="{{ route('bundle.store') }}" />
        </div>
    </div>
    @push('js')
        <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/bundle.js') }}"></script>
    @endpush
</x-dashboard-layout>
