<x-dashboard-layout>
    <x-slot:title> {{ translate('View Profile') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('organization.instructor.index') }}" title="View Profile"
        page-to="Instructor" />
    <x-portal::admin.profile-detail :user=$user />
</x-dashboard-layout>
