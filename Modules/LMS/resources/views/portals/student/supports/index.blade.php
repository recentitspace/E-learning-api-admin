<x-dashboard-layout>
    <x-slot:title> {{ translate('Support Manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Support" page-to="Supports"
        action-route="{{ route('student.supports.create') }}" />

    <div class="card overflow-hidden">
        @if ($tickets->count() > 0)
            <x-portal::supports.ticket-list :tickets="$tickets" type="platform" action="student.reply" replyForm="false"
                user-type="student" icon="" />
        @else
            <x-portal::admin.empty-card title="You didn't create any Ticket" />
        @endif
    </div>
</x-dashboard-layout>
