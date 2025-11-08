<x-dashboard-layout>
    <x-slot:title> {{ translate('Create Course Support') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Create Course Support" page-to="Support"
        back-url="{{ route('student.course.support.index') }}" />
    <x-portal::supports.create action="{{ route('student.supports.store') }}" type="course" />
</x-dashboard-layout>
