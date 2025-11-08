<x-dashboard-layout>
    <x-slot:title>{{ translate('View Profile') }}</x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb back-url="{{ route('instructor.index') }}" title="View Profile" page-to="Profile"
        action-route="{{ route('instructor.create') }}" />
    <x-portal::admin.profile-detail :user=$user />
</x-dashboard-layout>
