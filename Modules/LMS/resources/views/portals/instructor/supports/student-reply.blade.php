@php
    $type = $type ?? '';
    $action = $type && $type == 'student' ? route('instructor.student.support') : route('instructor.ticket.reply');
@endphp


<x-dashboard-layout>
    <x-slot:title> {{ translate('support/reply') }} </x-slot:title>
    <x-portal::admin.breadcrumb back-url="{{ $action }}" title="Support Reply" page-to="Support Reply" />

    <x-portal::supports.reply action="{{ route('instructor.ticket.reply') }}" :ticket=$ticket replyForm="true"
        userType="instructor" />
</x-dashboard-layout>
