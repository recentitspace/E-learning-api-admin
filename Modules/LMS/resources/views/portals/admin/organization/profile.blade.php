<x-dashboard-layout>
    <x-slot:title>{{ translate('View Profile') }}</x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb title="View Profile" page-to="Profile" back-url="{{ route('organization.index') }}" />
    <x-portal::admin.profile-detail :user=$user />
</x-dashboard-layout>
