<x-dashboard-layout>
    <x-slot:title> {{ translate('support/reply') }} </x-slot:title>

    <x-portal::admin.breadcrumb back-url="{{ route('instructor.supports.index') }}" title="Ticket Reply"
        page-to="Ticket Reply" />

    <x-portal::supports.reply action="{{ route('instructor.ticket.reply') }}" :ticket=$ticket replyForm="false" />
</x-dashboard-layout>
