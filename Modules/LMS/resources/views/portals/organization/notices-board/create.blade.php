<x-dashboard-layout>
    <x-slot:title>{{ isset($notice) ? translate('Edit') : translate('Create') }} {{ translate('Notice Board') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($notice) ? 'Edit' : 'Create' }} Notice Board" page-to="Notice Board" />
    @php
        $notice = $notice ?? null;
    @endphp
    <x-portal::noticeboard.create-form :notice=$notice :courses=$courses
        action="{{ route('organization.noticeboard.store') }}" />
</x-dashboard-layout>
