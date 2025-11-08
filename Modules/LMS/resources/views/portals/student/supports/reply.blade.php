@php
    $type = $type ?? '';
    $action = $type && $type == 'course' ? route('student.course.support.index') : route('student.supports.index');
@endphp

<x-dashboard-layout>
    <x-slot:title> {{ translate('support/reply') }} </x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ $action }}" title="Support view" page-to="Support view" />

    <x-portal::supports.reply action="{{ route('student.ticket.reply') }}" :ticket=$ticket replyForm="false" />
</x-dashboard-layout>
