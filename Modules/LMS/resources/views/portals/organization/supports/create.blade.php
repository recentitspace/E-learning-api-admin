<x-dashboard-layout>
    <x-slot:title> {{ translate('Create Support') }} </x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb title="Create Support" page-to="Supports"
        back-url="{{ route('organization.supports.index') }}" />
    <x-portal::supports.create action="{{ route('organization.supports.store') }}" :courses="$courses" />
</x-dashboard-layout>
