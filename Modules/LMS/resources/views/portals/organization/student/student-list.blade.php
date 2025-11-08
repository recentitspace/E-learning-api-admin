<x-dashboard-layout>
    <x-slot:title> {{ translate('Student/setting') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="All Student" page-to="Student" />
    @if (count($students) > 0)
        <x-portal::student.student-list :students="$students" />
    @else
        <x-portal::admin.empty-card title="No Student" />
    @endif
</x-dashboard-layout>
