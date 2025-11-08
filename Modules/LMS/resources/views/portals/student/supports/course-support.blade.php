<x-dashboard-layout>
    <x-slot:title> {{ translate('Course Support') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Course Support" page-to="Support"
        action-route="{{ route('student.course.support.create') }}" />

    <div class="card overflow-hidden">
        @if ($tickets->count() > 0)
            <x-portal::supports.ticket-list :tickets="$tickets" type="course" action="student.reply" userType="student"
                replyForm="false" icon="" />
        @else
            <x-portal::admin.empty-card title="You didn't create any ticket for course." />
        @endif
    </div>
</x-dashboard-layout>
