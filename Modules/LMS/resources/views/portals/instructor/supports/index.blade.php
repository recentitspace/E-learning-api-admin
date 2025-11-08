<x-dashboard-layout>
    <x-slot:title> {{ translate('Support Manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Support" page-to="Supports"
        action-route="{{ route('instructor.supports.create') }}" />


    @if ($tickets->count() > 0 || $coursesTickets->count() > 0)
        @if ($tickets->count() > 0)
            <div class="card">

                <h1 class="card-title mb-4"> {{ translate('Platform Ticket') }} </h1>
                <x-portal::supports.ticket-list :tickets="$tickets" type="platform" action="instructor.reply"
                    replyForm="false" icon="view" />

            </div>
        @endif
        @if ($coursesTickets->count() > 0)
            <div class="card">

                <h1 class="card-title mb-4"> {{ translate('Courses Ticket') }} </h1>
                <x-portal::supports.ticket-list :tickets="$coursesTickets" type="course" userType="instructor"
                    action="instructor.reply" replyForm='false' icon="view" />

            </div>
        @endif
        </div>
    @else
        <x-portal::admin.empty-card title="No support ticket" action="{{ route('instructor.supports.create') }}"
            btnText="Add New" />
    @endif
</x-dashboard-layout>
