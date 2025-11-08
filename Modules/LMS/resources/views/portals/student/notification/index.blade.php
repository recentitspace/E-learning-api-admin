<x-dashboard-layout>
    <x-slot:title> {{ translate('notification history') }} </x-slot:title>
    @if ($notifications->count() > 0)
        <x-portal::notification.notification-list :notifications=$notifications />
    @else
        <x-portal::admin.empty-card title="You have no Notification" />
    @endif
</x-dashboard-layout>
