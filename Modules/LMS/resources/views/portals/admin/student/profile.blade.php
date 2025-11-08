<x-dashboard-layout>
    <x-slot:title>{{ translate('View Profile') }}</x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb back-url="{{ route('student.index') }}" title="View Profile" page-to="Profile" />
    <x-portal::admin.profile-detail :user=$user />
</x-dashboard-layout>
