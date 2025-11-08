<x-dashboard-layout>
    <x-slot:title>{{ translate('support/reply') }}</x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ route('support-ticket.ticket.index') }}" title="Ticket reply"
        page-to="Ticket reply" />
    <x-portal::supports.reply action="{{ route('support-ticket.ticket.reply') }}" replyForm="true" userType="admin"
        :ticket=$ticket />
</x-dashboard-layout>
