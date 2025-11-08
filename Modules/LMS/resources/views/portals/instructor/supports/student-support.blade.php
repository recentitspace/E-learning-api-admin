<x-dashboard-layout>
    <x-slot:title> {{ translate('Support Manage') }} </x-slot:title>
    <!-- BREADCRUMB -->
    @if ($tickets->count() > 0)
        <div class="card">
            <h1 class="mb-4"> {{ translate('Platform Ticket') }} </h1>
            <x-portal::supports.student-support :tickets="$tickets" action="instructor.student.support.reply"
                userType="instructor" replyForm="true" icon="reply" />
        </div>
    @else
        <x-portal::admin.empty-card title="No Support Ticket" />
    @endif
</x-dashboard-layout>
