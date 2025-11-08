<x-dashboard-layout>
    <x-slot:title> {{ translate('Support Manage') }} </x-slot:title>
    <!-- Page Breadcrumb -->
    <x-portal::admin.breadcrumb title="All Support" page-to="Supports"
        action-route="{{ route('organization.supports.create') }}" />

    @if ($tickets->count() > 0 || $coursesTickets->count() > 0)
        <div class="card">
            @if ($tickets->count() > 0)
                <h1 class="card-title mb-4"> {{ translate('Platform Ticket') }} </h1>
                <x-portal::supports.ticket-list :tickets="$tickets" type="platform" action="organization.reply"
                    replyForm="false" icon="view" />
            @endif
        </div>
        <div class="card">
            @if ($coursesTickets->count() > 0)
                <h1 class="card-title mb-4"> {{ translate('Courses Ticket') }} </h1>
                <x-portal::supports.ticket-list :tickets="$coursesTickets" type="course" action="organization.reply"
                    replyForm="false" icon="view" />
            @endif
        </div>
        </div>
    @else
        <x-portal::admin.empty-card title="No support ticket" action="{{ route('organization.supports.create') }}"
            btnText="Create support" />
    @endif
</x-dashboard-layout>
