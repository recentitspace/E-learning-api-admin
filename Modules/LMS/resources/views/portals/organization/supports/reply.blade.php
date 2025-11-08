<x-dashboard-layout>
    <x-slot:title> {{ translate('support/reply') }} </x-slot:title>
    <x-portal::admin.breadcrumb title="reply Support" page-to="Supports"
        back-url="{{ route('organization.supports.index') }}" />


    <x-portal::supports.reply action="{{ route('organization.ticket.reply') }}" :ticket=$ticket
        replyForm="false" />
</x-dashboard-layout>
