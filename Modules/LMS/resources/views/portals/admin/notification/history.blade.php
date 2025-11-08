<x-dashboard-layout>
    <x-slot:title> {{ translate('Notification History') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Notification History" page-to="Notification" />

    @if ($notifications->count() > 0)
        <x-portal::notification.notification-list :notifications=$notifications />
    @else
        <x-portal::admin.empty-card title="No notification available" />
    @endif
</x-dashboard-layout>
