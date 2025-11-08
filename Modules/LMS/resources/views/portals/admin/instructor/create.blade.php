<x-dashboard-layout>
    <x-slot:title>{{ translate('Create Instructor') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('instructor.index') }}" title="Create" page-to="Instructor" />
    <x-portal::instructor.create action="{{ route('instructor.store') }}" />
</x-dashboard-layout>
