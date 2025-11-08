<x-dashboard-layout>
    <x-slot:title>{{ isset($notice) ? translate('Edit') : translate('Create') }} {{ translate('Notices-board') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('instructor.noticeboard.index') }}"
        title="{{ isset($notice) ? 'Edit' : 'Create' }} Notice Board" page-to="Notice Board" />
    @php
        $notice = $notice ?? null;
    @endphp
    <x-portal::noticeboard.create-form :notice=$notice :courses=$courses
        action="{{ route('instructor.noticeboard.store') }}" />
</x-dashboard-layout>
