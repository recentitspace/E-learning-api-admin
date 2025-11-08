<x-dashboard-layout>
    <x-slot:title> {{ translate('ticket/manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Support Ticket List" page-to="Support Ticket" />
    @if ($tickets->count() > 0 || $coursesTickets->count() > 0)
        <div class="card">
            @if ($tickets->count() > 0)
                <h1 class="card-title mb-4"> {{ translate('Platform Ticket') }} </h1>
                <x-portal::supports.ticket-list :tickets="$tickets" type="platform" action="support-ticket.reply"
                    icon="reply" userType="admin" />
            @endif
        </div>
        <div class="card">
            @if ($coursesTickets->count() > 0)
                <h1 class="card-title mb-4"> {{ translate('Courses Ticket') }} </h1>
                <x-portal::supports.ticket-list :tickets="$coursesTickets" type="course" action="support-ticket.reply"
                    icon="reply" />
            @endif
        </div>
    @else
        <x-portal::admin.empty-card title="Support Ticket" btnText="Add New" />
    @endif
</x-dashboard-layout>
