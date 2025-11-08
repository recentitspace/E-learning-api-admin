<x-dashboard-layout>
    <x-slot:title> {{ translate('Profile Settings') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Profile Settings" page-to="Profile" />
    <x-portal::profile.setting action="{{ route('instructor.profile.update') }}" />
</x-dashboard-layout>
