<x-dashboard-layout>
    <x-slot:title> {{ translate('Create Support') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Create Support" page-to="Support"
        back-url="{{ route('instructor.supports.index') }}" />
    <x-portal::supports.create action="{{ route('instructor.supports.store') }}" :courses="$courses" />
</x-dashboard-layout>
