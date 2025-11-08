<x-dashboard-layout>
    <x-slot:title> {{ translate('Create Instructor') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('organization.instructor.index') }}" title="Create Instructor" page-to="Instructor" />
    <x-portal::instructor.create action="{{ route('organization.instructor.store') }}" />
</x-dashboard-layout>
